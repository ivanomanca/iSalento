<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 *
 * @todo settare le head info in dinamico!
 */
class ListaSpiaggia extends Isp_View_Page{
	public $currentTab = 1;
	// Stato
	public $fotoSize = 100; // Default size
	public $ombraFotoPx = 100; // Int px della foto
	
    // Head info
	public $titleMeta = "Lista Struttura, iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha..mare, spiagge nel Salento";
	
	// Object state
	public $comingPageInfo = array(); // for scheda to retrieve father list
	
	// Dictionary
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Queste sono le spiagge del Salento!",
					"descriptionPage" =>"versione alpha di iSalento",
					"readAll" => "Leggi tutto..",
					"readAllDescription" => "Approfondisci"));
	
	// Dynamic data
	public $listaSpiaggia = null;
	
	public function getIngredients(){
		
		// Beaner	
		$ingredients['listaSpiaggia'] = array("A7B7Spiaggia", "userParams");
		
		return $ingredients;
	}
	
	public function skeleton(){
		
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'], 
											$this->txt['descriptionPage']));
											
		// LISTA
		/*Isp_Loader::loadVistaObj("Bones", null, "ListaItems");
		$lista = new ListaItems($this->listaStruttura, 
								"struttura",
								$this->txt,
								$this->comingPageInfo);
		$this->add($lista->snpOut);*/
		
		$beanLista = $this->listaSpiaggia;
		$ntt = "spiaggia";
		$txt = $this->txt;
		$comingPageInfo = $this->comingPageInfo;
		
		// In box items
		Isp_Loader::loadVistaObj("Snippets","PageElements","PicTitleAbstract");
		Isp_Loader::loadVistaObj("Snippets","List","Separator");
		Isp_Loader::loadVistaObj("Snippets","List","cListItem");
		
		$upperNtt = ucfirst($ntt);
		$idNtt = "id_".$ntt;
		$nomeNtt = "nome_".$ntt;
		
		
		// LIST
		$listArray = array();
		foreach ($beanLista as $bean){
			if($ntt == "articolo"){
				$titolo = $bean->A7Tea[0]->titolo_tea;
				$articolo = $bean;
			}else{
				$titolo = $bean->Struttura->nome_struttura;
				$articolo = $bean->A7B7Articolo[0]; 
			}
						
			// *** LINKS E TESTI *** //
			// FOTO
			if(isset($bean->A7B7Fotovideo[0])){
				$urlPhoto = new Isp_Url_Photo( 
									$bean->A7B7Fotovideo[0]->Fotovideo->id_fotovideo,
									$this->fotoSize,
									$bean->A7B7Fotovideo[0]->Tfv->nome_tfv,
									$bean->A7B7Fotovideo[0]->Tfv->didascalia_tfv
									);
			}else{
				$urlPhoto = null;
			}
			// TITOLO
			$urlTitle = new Isp_Url_Page($titolo,
										"Scheda",
										"scheda".$upperNtt,
										//array($idNtt => $bean->$upperNtt->$idNtt)
										array("id_struttura" => $bean->Struttura->id_struttura)
										+ $comingPageInfo,
										$titolo);
			// DESCRIZIONE
			$abstract = $articolo->A7Tea[0]->abstract_tea;
			// LINK LEGGI TUTTO
			$readAllUrl = new Isp_Url(	$urlTitle->path, 
										$txt['readAll'] , 
										$txt['readAllDescription']." ".
										$titolo);
			// *** SNIPPETS *** //
			// Single box
			$inBoxItems = new PicTitleAbstract($urlPhoto, 
												$urlTitle, 
												$abstract, 
												$readAllUrl,
												$this->ombraFotoPx);
			// Separatore !Patch non riusabile!									
			if($ntt == "struttura"){
				$listSep = new Separator(ucfirst($bean->Struttura->nome_tipostruttura), 
										$bean->Struttura->nome_localita);
			}elseif ($ntt == "articolo"){
				$listSep = new Separator($bean->A7Tea[0]->data_tea,
									ucfirst($bean->Articolo->nome_categoria));
			}elseif ($ntt == "localita"){
				$listSep = new Separator(ucfirst(
												$bean->$upperNtt->costa_entroterra_localita));
			}else{
				$listSep = new Separator();
			}
				
			// Elemento di lista						
			$listItem = new cListItem($listSep, $inBoxItems, true);
			array_push($listArray, $listItem);
		}
	
		// List case
		Isp_Loader::loadVistaObj("Snippets","List","cList");
		$this->add(new cList($listArray));
		
		
		
		// RUN IN TEMPLATE		
		return $this->useDefaultTemplate();
		
	}
}

?>