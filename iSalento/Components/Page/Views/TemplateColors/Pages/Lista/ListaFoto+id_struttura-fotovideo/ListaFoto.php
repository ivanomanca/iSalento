<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 * 
 * @todo questa pagina esiste solo per visualizzare 
 * un corretto breadcrumb quindi  una patch!
 *
 */
class ListaFoto extends Isp_View_Page{
	public  $currentTab = 2;
	
	// Head info
	public $titleMeta = "Foto Salento, iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha test..mare, spiagge nel Salento";
	
	// Dictionary
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => " LISTA FOTO ",
					"descriptionPage" =>"versione alpha di iSalento",
					/*FOTO INFO*/
					"nFoto" 		=> "Foto in album ",
					"pagina" 	=> "Pagina",
					"di" 	=> "di",
					"avanti" 	=> "Avanti",
					"indietro" 	=> "Indietro",
					"foto" => "Foto "),
			"en" => 
			array("nFoto" => "Photos found : "));
	
	// Object state
	public $fotoSize = 200; // Default size
	public $comingPageInfo = array(); // for scheda to retrieve father list
	public $noSideNav = true; // Annulla la navigazione laterale sinistra
	public $noExtraNav = true;
	
	// Dynamic data
	public $listaFoto = null;
	public $oggettoStruttura = null;
	
	public function getIngredients(){
		$ingredients['listaFoto'] = array("A7B7Fotovideo", "userParams");
		return $ingredients;
		
	}
	
	public function getRelatedIngredients(){
		if(isset($this->listaFoto[0])){
			$ingredients['oggettoStruttura'] = array("Struttura", 
											array("id_struttura" => 
											$this->listaFoto[0]->Fotovideo->id_struttura));
			return $ingredients;
		}
	}
	
	public function setThisPageUrl(){
		
		// Foto description
		if (isset($this->oggettoStruttura->nome_struttura)){
			$urlTitle = $this->oggettoStruttura->nome_struttura;
			$urldescription = $this->txt['foto'].$this->oggettoStruttura->nome_struttura;
			$urldescription .= " ( ".$this->oggettoStruttura->nome_tipostruttura; 
			$urldescription .= " ".ucfirst($this->oggettoStruttura->nome_localita)." ) ";
		}else{
			$urlTitle = null;
			$urldescription = null;
		}
		
		// Breadcrumb
		$currentLevelUrl = new Isp_Url_Page($urlTitle,
											$this->pageType,
											$this->page,
											$this->paramsArray,
											$urldescription);
		return $currentLevelUrl;	
		
	}
	
	public function skeleton(){
			
																
		// Photo Ul
		Isp_Loader::loadVistaObj("Snippets","List","PhotoUl");
					
		$urlPhotoArray = array();
		foreach ($this->listaFoto as $foto){
			
			// Trasmetto l'id della foto + 
			// lista di foto che voglio + 
			// la lista di provenienza codificata
			$fwParamsArray = array("idFotovideo" =>$foto->Fotovideo->id_fotovideo)
										+ $this->thisPageUrl->paramsArray
										+ $this->comingPageInfo;
			// Link alla pagina scheda foto
			$urlPage = new Isp_Url_Page($foto->Tfv->nome_tfv, 
										"Scheda", 
										"SchedaFoto", 
										$fwParamsArray,
										$foto->Tfv->didascalia_tfv );
			// Link della foto 							
			$urlPhoto = new Isp_Url_Photo(	$foto->Fotovideo->id_fotovideo,
											$this->fotoSize,
											$foto->Tfv->nome_tfv,
											$foto->Tfv->didascalia_tfv);
			$pic  = array($urlPage, $urlPhoto);
			array_push($urlPhotoArray, $pic);
		}
								
		$photoUl = new PhotoUl($urlPhotoArray);
		
		// Photo breadcrumb
		Isp_Loader::loadVistaObj("Snippets","Navigation","PhotoBreadcrumb");
		
		$photoBread = new PhotoBreadcrumb(array($this->txt['pagina'],$this->txt['di']), 
										array(1, 1));
		
		$dwBreadLabel = $this->txt['nFoto'].$this->thisPageUrl->title." :";
		$photoBreadBottom = new PhotoBreadcrumb(array($dwBreadLabel,""), 
												array(sizeof($this->listaFoto), ""),
												null, null, true);									
		// cPhotoGallery, wrapper
		Isp_Loader::loadVistaObj("Snippets","Boxes","cPhotoGallery");
		$this->add(new cPhotoGallery(	ucwords($this->thisPageUrl->description), 
										$photoBread, 
										$photoBreadBottom , 
										$photoUl));									
		
		return $this->useDefaultTemplate($this->noSideNav, $this->noExtraNav);
	}
}

?>
