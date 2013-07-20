<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
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
					"indietro" 	=> "Indietro"),
			"en" => 
			array("nFoto" => "Photos found : "));
	
	// Object state
	public $fotoSize = 200; // Default size
	public $comingPageInfo = array(); // for scheda to retrieve father list
	public $noSideNav = true; // Annulla la navigazione laterale sinistra
	public $noExtraNav = true;
	
	// Dynamic data
	public $listaFoto = null;
	
	public function getIngredients(){
		$ingredients['listaFoto'] = array("A7B7Fotovideo", "userParams");
		return $ingredients;
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
// @todo: calcolare le pagine e i numeri dipagina
		Isp_Loader::loadVistaObj("Snippets","Navigation","PhotoBreadcrumb");
		$urlPag1 = new Isp_Url("resource", "1");
		$urlPag2 = new Isp_Url("resource", "2");
		$urlPag3 = new Isp_Url("resource", "3");
		$urlPag4 = new Isp_Url("resource", "4");
		$urlIndietro = new Isp_Url("indietro", $this->txt['indietro']);
		$urlAvanti = new Isp_Url("avanti", $this->txt['avanti']);
		
		
		$photoBread = new PhotoBreadcrumb(array($this->txt['pagina'],$this->txt['di']), 
										array(1, 1));
		
		$dwBreadLabel = $this->txt['nFoto'].$this->thisPageUrl->title." :";
		$photoBreadBottom = new PhotoBreadcrumb(array($dwBreadLabel,""), 
												array(sizeof($this->listaFoto), ""),
												null, null, true);									
		// cPhotoGallery, wrapper
		Isp_Loader::loadVistaObj("Snippets","Boxes","cPhotoGallery");
		$pageTitle = ucwords($this->thisPageUrl->description);
		$this->add(new cPhotoGallery(	$pageTitle, 
										$photoBread, 
										$photoBreadBottom , 
										$photoUl));									
		
		return $this->useDefaultTemplate($this->noSideNav, $this->noExtraNav);
	}
}

?>
