<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 *
 */
class SchedaFoto extends Isp_View_Page{
	public $currentTab = 2;
	
	// OBJECT STATE
	public $listaUrl = null; // Info sulla lista di proveninza
	public $id_fotovideo = null; // Inserito dal ctrl
	public $fotoSize = 600; // Default size
	public $count; // Current photo number
	public $urlDescriptionSymbol = " :: ";
	
	// Urls
	public $backUrl;
	public $nextUrl;
	public $lastUrl;
	public $countBackUrl;
	public $countNextUrl;
	public $urlPhoto;
	
	// Dictionary
	public $dictionary = array( 
		   "it" =>  array( "titlePage" => "Foto ",
						   "nFoto" 		=> "Foto in album ",
							"foto" 	=> "Foto",
							"di" 	=> "di",
							"avanti" 	=> "Avanti",
							"indietro" 	=> "Indietro"));
	
	// DYNAMIC DATA
	public $schedaFoto = null;
	public $listaFoto = null;
	
	public function getIngredients(){
		//$ingredients['schedaFoto'] = array("B7Fotovideo", "userParams");
		// Richiama tutta la lista
	//	$ingredients['listaFoto'] = array("A7B7Fotovideo", $this->listaUrl->paramsArray);
		$ingredients['listaFoto'] = array("A7B7Fotovideo", "userParams");
		return $ingredients;
	}
	
	public function setThisPageUrl(){
		
		// Foto description
		if (isset($this->urlPhoto->description)){
			$urlDescription = $this->urlPhoto->description;
		}else{
			$urlDescription = null;
		}
		// Breadcrumb
		$currentLevelUrl = new Isp_Url_Page($this->schedaFoto->Tfv->nome_tfv,
											$this->pageType,
											$this->page,
											$this->paramsArray,
											$urlDescription);
		return $currentLevelUrl;	
		
	}
	
	public function skeleton(){
		
	//alla fine bone con 4 array url, txt, count
								
		// Photo breadcrumb superiore
		Isp_Loader::loadVistaObj("Snippets","Navigation","PhotoBreadcrumb");
		$photoBread = new PhotoBreadcrumb(	array($this->txt['foto'], $this->txt['di']), 
											array($this->count+1, $this->lastUrl),
											array($this->backUrl, $this->nextUrl),
											array(	$this->countBackUrl, 
													$this->count+1, 
													$this->countNextUrl));
		
		// Photo breadcrumb inferiore											
		$dwBreadLabel = $this->txt['nFoto'].$this->listaUrl->title." :";
		$photoBreadBottom = new PhotoBreadcrumb(array($dwBreadLabel,""), 
												array(null, $this->lastUrl),
												array($this->backUrl, $this->nextUrl),
												array(	$this->countBackUrl, 
														$this->count+1, 
														$this->countNextUrl),
												true);		
													
		// PhotoCard								
		Isp_Loader::loadVistaObj("Snippets","Card","PhotoCard");
		$photoCard = new PhotoCard(	$this->urlPhoto, 
									$this->urlPhoto->title, 
									$this->urlPhoto->description);
		
		// PhotoGallery (Box contenitore)
		Isp_Loader::loadVistaObj("Snippets","Boxes","cPhotoGallery");
		$titlePage = $this->txt['titlePage'].$this->schedaFoto->Tfv->nome_tfv;
		if(isset($this->schedaFoto->nome_localita)){ // Aggiungi il nome della localita foto
			$titlePage .= " ( ".ucfirst($this->oggettoStruttura->nome_localita)." ) ";
		}
		$this->add(new cPhotoGallery(	$titlePage, 
										$photoBread, 
										$photoBreadBottom, 
										$photoCard));
		
		// RUN IN TEMPLATE							
		return $this->useDefaultTemplate( false, true );
	}
}

?>
