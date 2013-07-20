<?php

class Media {
	
	//Costruttore
	public function __construct() {
		
	}
	
	public $dir_base = "/Components/Media/Views/Photos";
	
	/*Ricava e restituisce l'estensione del file*/
	public function get_estensione($file_name) {
		//ricava le ultime tre lettere del nome del file corrispondenti all'estensione
		return substr($file_name, -3);
	}
	
	/*Controlla se il file da inserire è un'immagine*/
	public function check_file($file_name) {
		
		$estensione = $this->get_estensione($file_name);
		if($estensione == 'gif' || $estensione == 'png' || $estensione == 'jpg' )
			return 0; //risultato positivo
		else 	
			return -1;
	}
	
	/* Effettua l'upload di un'immagine
		@param $upload_dir = directory in cui viene salvato il file sul server;
		@param $file_name = nome con cui salvare il file;	
		
		return 0 se andato con successo 1 altrimenti
	*/
	public function Upload($file_name) {
		
		if(!isset($_FILES)) $_FILES = $HTTP_POST_FILES;
		if(!isset($_SERVER)) $_SERVER = $HTTP_SERVER_VARS;

		/********************* VARIABILI UTILI ********************/
		/** $_FILES["nomefile"]["tmp_name"] (il nome temporaneo del file che viene attribuito al file sul server)
    	  * $_FILES["nomefile"]["name"] (il nome originario o il percorso del file sul client)
    	  * $_FILES["nomefile"]["size"] (la grandezza, espressa in bytes, del file)
    	  * $_FILES["nomefile"]["type"] (il MIME type del file, ad esempio application/x-zip-compressed)  */
		
		/*
		1) Ottieni id utente   $id_utente
		2) Ottieni dimensione con cui salvare 
		3) Controllare che il file sia un'immagine
		4) Crea, se non esiste, le directory $dir_base.id_utente/dimensione/
		5) Salvo il file nella directory creata al passo 3
		*/
		
		//QUI VA L'ID DELL'UTENTE
		$id_utente = "";
		$dir_utente = "/".$id_utente."/";
		
		//QUI VA LA DIMENSIONE CON CUI SALVARE LE FOTO
		$width = "640";
		$height = "480";
		$dir_dimensione = $width."_".$height."/";
		
		//Controllo che il file da inserire sia un'immagine
		$this->check_file($_FILES["upfile"]["tmp_name"]);	
		
		//ridimensiono l'immagine
		$this->ridimensiona($_FILES, $_FILES["upfile"]["tmp_name"], $width, $height, 80, $id_utente);
		
		//percorso completo in cui salvare il file
		$upload_dir = $this->dir_base.$dir_utente.$dir_dimensione;	
		
		if(@is_uploaded_file($_FILES["upfile"]["tmp_name"])) {

			@move_uploaded_file($_FILES["upfile"]["tmp_name"], $upload_dir.$file_name)
			or die("Impossibile spostare il file, controlla l'esistenza o i permessi della directory dove fare l'upload.");

		} 
		else {

			die("Problemi nell'upload del file " . $_FILES["upfile"]["name"]);
			return 1;
		}

		echo "L'upload del file " . $_FILES["upfile"]["name"] . " è avvenuto correttamente";
		return 0;
	}
	
	
	/* Ridimenziona immagine 
	
		$file_name = indica l'immagine da ridimensionare;
		$dir = directory in cui è salvata la foto;
		$new_width, $new_height = dimensioni che deve assumere la foto;
		$quality= livello di qualità che deve assumere la foto, è un valore compreso fra 1 e 100
	
	*/
	public function ridimensiona($file, $file_name, $new_width, $new_height, $quality, $id_utente) {
		
		$dir_dimensione = "/".$new_width."_".$new_height."/";
		$dir_utente = "/".$id_utente;
		
		//creo la directory dell'utente se non eiste
		if(!is_dir($this->dir_base.$dir_utente))
			mkdir($this->dir_base.$dir_utente, 0777);
			
		//creo la directory che rispecchia la dimensione dell'immagine inserita dall'utente
		if(!is_dir($this->dir_base.$dir_utente.$dir_dimensione))
			mkdir($this->dir_base.$dir_utente.$dir_dimensione, 0777);
			
		//Ottiene le info sull'immagine originale
		list($width, $height) = getimagesize($file);
		
		$thumb = imagecreatetruecolor($new_width, $new_height);
		
		//A seconda dell'estensione dell'immagine utilizzo l'opportuna funzione
		$estensione = $this->get_estensione($file);
		
		if($estensione == 'jpg') 
			$source = imagecreatefromjpeg($file);
		else if ($estensione == 'png')
				$source = imagecreatefrompng($file);
		else if ($estensione == 'gif')
				$source = imagecreatefromgif($file);
		
		imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		//Salvo l'immagine ridimensionata
		imagejpeg($thumb, $this->dir_base.$dir_utente.$dir_dimensione.$file_name, $quality);
	
	}
	
	/*Elimina il file
		
		$file_name = nome del file da eliminare;
		$dir_sorgente = directory in cui si trova il file;
	
	*/
	public function elimina_file($file_name, $dir_sorgente) {
	
		unlink($dir_sorgente.$file_name);
		
		//ELIMINARE DAL DB IL FILE
		
	}
	
	/*Sposta il file in un'altra locazione sul server
	
		$file_name = nome del file da spostare;
		$dir_sorgente = directory in cui si trova il file;
		$dir_destinazione = directory in cui spostare il file;
		$taglia = è un valore booleano che se settato a 1 effettua il taglia-incolla altrimenti il copia incolla
	
	*/
	public function sposta_file($file_name, $dir_sorgente, $dir_destinazione, $taglia) {
		
		copy($dir_sorgente.$file_name, $dir_destinazione.$file_name);
		
		if($taglia) {
			$this->elimina_file($file_name,$dir_sorgente);
			//ELIMINARE IL FILE DAL DB
		}
			
	}
	
	/*Rinomina il file*/
	public function rinomina($old_file_name, $new_file_name, $dir_sorgente) {
		
		rename($dir_sorgente.$old_file_name, $dir_sorgente.$new_file_name);
		//UPDATE DEL DB
	}
}

?>