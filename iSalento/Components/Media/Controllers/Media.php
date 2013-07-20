<?
Isp_Loader::loadClass("Isp_Controller_Action_Instantiator");
/**********************************************************************
	path = 	Components/
					Media/
						Views/
							Photos/
								"id_foto"/
									"formato"/
										"nome_chiave".estensione

	->"id_foto" = (int) id assoluto della foto nel db
	->"dimensione" = (string) {"small","mid","large","big"} o {"640_480","800_600"}
	->"nome_chiave" = (string) il nome inserito nel form ricco di parole chiave!
	->"estensione" = {jpg, gif, png, tff}
****************************************************************************/

/* UTILITY
	$_FILES(
		[0] => Array
        (
            [name] => portocesareo.jpg
            [type] => image/jpeg
            [tmp_name] => /Applications/MAMP/tmp/php/phpxr20A8
            [error] => 0
            [size] => 135418
        )
    )
    
    $_POST(
               titolo = pc
               username= ivo
    	)
    )
*/
class Media extends Isp_Controller_Action_Instantiator {
	//url base in cui salvare le foto
	private $PhotosLibraryUrl = "Components/Media/Views/Photos/"; 
	private $PhotosCopyUrl = "Foto/"; 
	private $MAX_DIM = 4096;						//max dimensione in KByte per l'upload
	private $allowedCompressions = array("jpeg");	//compressioni accettate
	private $ispExtension = "jpg";					//estensione delle foto sul server			
	// LOGO
	private $logoName = "Bao.gif";
	private $posLogoX = 10;                         //Posizione del logo
	private $posLogoY = 10;
	private $transparency = 60;                     //Trasparenza usata per il logo
	// Applica il logo sui formati specificati
	private $applyLogoOnFormats = array("600" => true);
	// Non fare il controllo sulle proporzioni per i formati specificati
	private $noConstrainProportion = array("speciale" => true); 
	//dimensione delle foto da ridimensionare
	//private $formatResize = array("100","200","600","1200");
	//nome di default con cui salvare l'immagine se non si indica diversamente
	private $photoDefaultName = "iSalento-Lecce-Puglia"; 
	private $quality = 100; 							//qualit� di ridimensionamento immagine
    public $formatsArray = array(
								"100" => array(100, 75),
								"200" => array(200, 150),
								"600" => array(600, 450),
								"original" => array(1200, 900),
								"speciale" => array(296, 198)
								);
	//public $addSpecialeFormat = false;
								
	/**
	 * Upload di una foto
	 *
	 */
	public function uploadPhoto(){
		
		//ciclo for su tutti i file da effettuare l'upload
		for ($i = 0; $i < sizeof($_FILES); $i++){
	
			// Ricavo i campi da inserire nel database - fieldsArray
			$photoInfo = $this->front->request->params["photos"][$i];
			
			// Controlli sul file
			if($this->checkPhoto($_FILES[$i], $this->allowedCompressions, $this->MAX_DIM)){
				// Aggiungo il nome del file (uguale al tfv IT del primo upload)
				$photoInfo["nome_file_fotovideo"] = $photoInfo['nome_tfv'];
				
				// inserisco l'oggetto foto nel Db e ricavo l'id 
				$photoId = $this->dbInsertPhoto($photoInfo);
				if($photoId >= 0){
					
					// salvo sul file system del server il file Originale
					if($this->savePhotoOriginalsOnFileSystem($_FILES[$i]["tmp_name"], 
															 $photoId)){}
						
					// Sostituisco agli spazi vuoti i trattini
					$photoName = str_replace(" ", "-", $photoInfo['nome_file_fotovideo']);
					$photoName = stripslashes($photoName);

					// Scelta dei formati per le caches
					$formatsArray = $this->formatsArray;
					unset($formatsArray['original']); // Togli il formato originale
					// Se non � specificata la cache in formato speciale
					if(!isset($photoInfo['formato_speciale_fotovideo'])){
							unset($formatsArray['speciale']); // Non farla!
					}
					// salvo sul file system del server le copie dell'immagine 
					// originale ridimensionandole
					if($this->savePhotoCopiesOnFileSystem(	$photoId, 
															$photoName, 
															$formatsArray)){}

							
				}else{
					// Scrittura su db fallita
					//-----------------------------------------------
					// forward modulo Error
				}
			}
		}
		
		// Next page 
		$fwParams = $_SESSION['nextOkPage'];
		// adesso usa la view!
		$this->forward("getPage","Page", null, $fwParams);	
	}
	
	
	/**
	 * Inserisce i campi della foto nel db
	 * e ritorna l'id della foto.
	 *
	 * @param fieldsArray $photoInfo
	 * @return int id_fotovideo
	 * 
	 * @todo implementa il metodo mediaError nel componente Error!
	 */
	private function dbInsertPhoto($photoInfo) {
		// inserimento entit multiple
		$ntt = array("Fotovideo", "Tfv");		
		foreach($ntt as $key => $nttName){			
	        // istanzio l'Objmanager
	        if($this->instantiate("Isp_Db_ObjManager")){
	        
		        // Effettuo l'inserimento da Objmanager
		        $out = $this->instancedObj->insert_obj_to_db(	$nttName,
		        												$photoInfo);
				if($out === false) {
					// inserimento fallito
					$this->forward(	'mediaError',
									'Error',
									'Error',
									array(	'failedReq' => $this->front->request,
											'errArray' => $this
															->instancedObj
															->errorsArray));
					return -1;
				} else {
					// inserimento riuscito
					// aggiorno il fields_array
					$photoInfo = $out;
					
					if($key == 0){ // Main table
						$idMainTable = $this->instancedObj->id_performed;
					}
				}
	        }
		}
		
		// Id foto inserita
		return $idMainTable;
	}
	
	/**
	 * It computes the correct sizes to use prior resizing.
	 * This function takes into account if a horizontal or vertical 
	 * photo is passed. The algorith uses only one of the two passed 
	 * sizes for resizing and computes the other proportional size.
	 *
	 * @param string $photoFile - link to file
	 * @param array $formatSizes - Desired width and height for 
	 * resizing, es: array(100, 75)
	 * @return an array with new dimensions ready to be used in resizing.
	 * eg. array (200, 150), where 200 is width and 150 is heght.  
	 */
	public function computeSize($photoFile, $formatSizes){
		
		// Original sizes
		list($width, $height) = getimagesize($photoFile);

		if ($width >= $height){						   // Horizontal photo
			$conv = $height/$width;  				   // Dimensions' ratio
			$newWidth = $formatSizes[0]; 			   // Specified width
			$newHeight = $conv*$newWidth; 			   // Proportional calculated height
			$newHeight = number_format($newHeight, 0); // Round it	
		}else{									       // Vertical photo
			$conv = $width/$height;
			$newHeight = $formatSizes[1]; 			   // Specified height
			$newWidth = $conv*$newHeight; 			   // Proportional calculated width
			$newWidth = number_format($newWidth, 0);		
		 }

		 // Return correct proportional sizes to use
		 return array($newWidth, $newHeight);

	}
	
	/**
	 * Controlla se il file da inserire � un'immagine
	 * conforme ai requisiti
	 *
	 * @param string $photoFile
	 * @param $allowedExtensions
	 * @param $maxDimKB
	 * @return boolean
	 */
	public function checkPhoto($photoFile, $allowedExtensions, $maxDimKB) {
		// Verifica che il file sia stato caricato nella cache
		if(!is_uploaded_file($photoFile['tmp_name'])){
			return false;
		}
		
// !Skip control, remove this line		
return true;
		
		// controllo tipo e compressione
		$tipoCompressioneArray = explode('/', $photoFile['type']);
				
		if (!($tipoCompressioneArray[0] == 'image' &&
				in_array($tipoCompressioneArray[1], $allowedExtensions))) {
			// file non conforme ai requisiti per l'upload
			//-----------------------------------------------
			// forward modulo Error
			return false;
		}
		// controllo che non superi la DIM_MAX
		elseif ($photoFile['size'] > $maxDimKB*1024) {
			// file non conforme ai requisiti per l'upload
			//-----------------------------------------------
			// forward modulo Error
			return false;
		}
		else{
			// controllo avvenuto con successo
			return true;
		}
	}
	
	/**
	*
	* Salva le tre copie ridimensionate a partire dalla foto originale
	* LOGICA:
	*   1)Prendo l'immagine dalla cartella con Id photoId
	*	2)creo le cartelle necessarie per le copie
	*	3)ridimensiono l'immagine
	*	4)salvo l'immagine nelle cartelle create
	*	
	* @param $photoId id della foto da cui creare le tre copie ridimansionate
	* @param string $photoName - Il nome con cui scrivere il file (nome_tfv)
	* @param array $formatsArray - L'array con i formati per fare le copie
	* @return true se successo
	*
	*/
	public function savePhotoCopiesOnFileSystem($photoId, $photoName, $formatsArray){
		
		// Link del file originale
		$linkPhotoOriginal = $_SERVER['DOCUMENT_ROOT'].$this->PhotosLibraryUrl;
		$linkPhotoOriginal .= "Originals/".$photoId."/".$this->photoDefaultName.".jpg";
		
		// Link per la cartella di base delle copie
		//$baseFolder = $_SERVER['DOCUMENT_ROOT'].$this->PhotosLibraryUrl."Copies/".$photoId."/";
		$baseFolder = $_SERVER['DOCUMENT_ROOT'].$this->PhotosCopyUrl.$photoId."/";
		
		// Crea cartella di base
		if(!$this->makeDir($baseFolder)) 
			return false;
		
		// Per ogni formato stabilito
		foreach ($formatsArray as $format => $arraySize){
			// Cartella con nome della prima dimensione della foto
			//$destinationFolder = $baseFolder.$formatsArray[$format][0]."/";
			$destinationFolder = $baseFolder.$arraySize[0]."/";
			// Crea la cartella (es. $baseFolder/100/ )
			if(!$this->makeDir($destinationFolder))
				return false;

			// Applica direttamente le dimensioni desiderate (utile per formati 16:9)
			if(isset($this->noConstrainProportion[$format]) and $this->noConstrainProportion[$format]){
				$newSizesArray = $arraySize;
			}else{ 	// Calcola le nuove dimensioni in proporzione (se specificato nelle configurazioni)
				$newSizesArray = $this->computeSize($linkPhotoOriginal, $arraySize);
			}
			// Verifica se si deve fare il resize con il logo
			if(isset($this->applyLogoOnFormats[$format]) and $this->applyLogoOnFormats[$format]){
				$addLogo = true;
			}else{
				$addLogo = false;
			}
			// Resize e sposta la copia nella cartella
			if(!$this->resizePhoto( $newSizesArray,
									$linkPhotoOriginal,
									$destinationFolder,
									$addLogo,
									$photoName))
				return false;	
		}
		return true;
	}
	
	/**
	* Ridimensiona l'immagine
	*
	* @param $newSizesArray - array con le nuove dimensioni
	* @param $source foto da ridimensionare 
	* @param $destination destinazione in cui salvare la foto ridimensionata
	* @param boolean $addLogo - true per sovraimporre il logo sulla copia
	* @param string  $photoName - Il nome con il quale scrivere il file
	*
	* @return true se successo
	*/
	public function resizePhoto($newSizesArray, 
								$source, 
								$destination, 
								$addLogo = false, 
								$photoName){

		list($width, $height, $type, $attr) = getimagesize($source);
		
		$thumb = imagecreatetruecolor($newSizesArray[0], $newSizesArray[1]);
		$imageCreate = imagecreatefromjpeg($source);
		imagecopyresampled(	$thumb, 
							$imageCreate, 
							0, 0, 0, 0, 
							$newSizesArray[0], $newSizesArray[1],
							$width, $height);

		// Se non si deve aggiungere il logo
		if(!$addLogo){
			// Output
			imagejpeg($thumb, $destination.$photoName.".jpg", $this->quality);
		}else{
			//Aggiunge il logo alla foto e la salva in $destination
			if(!$this->addLogo($thumb, $destination, $photoName)){
				return false;
			}
		}
		// Success!
		return true;

	}
	
	/**
	* Salva la foto originale sul file system
	*
	* @param $tmpNameFile il nome temporaneo del file in cache
	* @param $photoId l'id della foto da salvare
	*
	* @return true se successo
	*/
	public function savePhotoOriginalsOnFileSystem(	$tmpNameFile, $photoId ){		
		
		$destinationFolder = $_SERVER['DOCUMENT_ROOT'].$this->PhotosLibraryUrl;
		$destinationFolder .= "Originals/".$photoId."/";
		
		// Crea la cartella (es. $baseFolder/100/ )
		if(!$this->makeDir($destinationFolder))
			return false;
		// Calcola le nuove dimensioni in proporzione
		$newSizesArray = $this->computeSize($tmpNameFile, $this->formatsArray['original']);
		// Verifica se si deve fare il resize con il logo
		if(isset($this->applyLogoOnFormats['original']) and 
				$this->applyLogoOnFormats['original']){
			$addLogo = true;
		}else{
			$addLogo = false;
		}
		// Resize e sposta la copia nella cartella
		if(!$this->resizePhoto( $newSizesArray,
								$tmpNameFile,
								$destinationFolder,
								$addLogo,
								$this->photoDefaultName))
			return false;	
	
		return true;
				
	}
	
	
	/**
	*
	* crea la directory passato come argomento con permessi 777
	*
	* @param $dir directory da creare
	*
	* @return true se successo
	*
	*/
	public function makeDir($dir){
		
		//controllare se esiste già la cartella @todo!
		//Creo la cartella con permessi 777
		if(mkdir($dir, 0777)){
			return true;
		}else {
			return false;
		}
		
												
	}
	
	/**
	 * Aggiunge il logo all'immagine da ridimensionare
	*
	* @param $imageCreate l'immagine creata e ridimensionata
	* @param $destination è la destinazione in cui salvare la foto
	* @param string $photoName - Il nome con cui salvare il file
	*
	* @return true se successo
	*
	*/
	public function addLogo($imageCreate, $destination, $photoName){
		
		//mettere nell'intestazione del controller
		$pathLogo = $_SERVER['DOCUMENT_ROOT'].$this->PhotosLibraryUrl."Logo/".$this->logoName;
		
		//crea l'immagine del logo
		$logoCreate = imagecreatefromgif($pathLogo);
		//$logoCreate = imagecreatefrompng($pathLogo);
		
		//effettua il merge del logo con la foto passandogli:
		//1)$imageCreate = l'immagine creata a partire dalla foto
		//2)$logoCreate = logo creato a partire dall'immagine del logo 
		//3)$posLogoX = posizione lungo asse X del logo nella foto
		//4)$posLogoY = posizione lungo asse Y del logo nella foto
		//5)0 = posizione X a partire dal quale verrà utilizzato il logo
		//6)0 = posizione Y a partire dal quale verrà utilizzato il logo 
		//7)imageSX($logoCreate) = restituisce la larghezza del logo
		//8)imageSY($logoCreate) = restituisce l'altezza del logo
		imageCopyMerge(	$imageCreate, 
						$logoCreate, 
						$this->posLogoX, 
						$this->posLogoY, 
						0, 
						0, 
						imageSX($logoCreate), 
						imageSY($logoCreate), 
						$this->transparency);

		//Overwriting dell'immagine
		if(!imagejpeg($imageCreate, $destination.$photoName.".jpg", $this->quality))
			return false;
		
		return true;
	}
	
	// !Test per la funzione dbInsertPhoto, da cancellare!
	public function testDbInsertPhoto(){
		//$photoInfo = $this->front->request->params["photos"][$i];
		$photoInfo = $this->front->request->params["photos"][0];
		$idDb = $this->dbInsertPhoto($photoInfo);
		echo "l'id inserito per la foto ".$photoInfo["nome_tfv"]."e': ".$idDb;
	}
	// !test for computeSize function, da cancellare!
	public function testComputeSize(){
		// Passo il link del file e l'array del formato per ottenere le nuove dimensioni  
		$newSizesArray = $this->computeSize($_FILES[$i]['tmp_name'], $this->formatsArray["100"]);	
		echo("Dimensioni originali:<br>");
		print_r(getimagesize($_FILES[$i]['tmp_name']));
		echo("<br><br>Dimensioni calcolate per il resize:<br>");
		print_r($newSizesArray);
		
	}
}

?>