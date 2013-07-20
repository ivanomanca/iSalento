<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 *
 */
class SchedaArticolo extends Isp_View_Page{
	public $currentTab = 4; // Tab di appartenenza
	
	// Head info
	public $titleMeta = "Articolo iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha test..mare, spiagge nel Salento";
	
	// Dictionary
	public $dictionary = array( 
		   "it" =>  array( "titlePage" => "Scheda Articolo - 
											Spiagge, grotte, sport acquatici",
						   "descriptionPage" =>"versione alpha di iSalento",
						   "inBreve" => "In breve",
						   "readAllFoto" => "VEDI TUTTE >>",
						   "descrReadAllFoto" => "Vedi tutte le foto ",
						   "anteprimaFoto" => "Anteprima foto",
						   "descrAnteprimaFoto" => "Alcune foto in anteprima per "));
	// Objectc state
						
	// Dynamic data
	public $beanArticolo = null;
	
	public function getIngredients(){
		$ingredients['beanArticolo'] = array("B7Articolo", "userParams");
		return $ingredients;
	}
	
	/**
	 * Setta l'url di questa pagina
	 *
	 * @return Isp_Url_Page
	 */
	public function setThisPageUrl(){
		$currentLevelUrl = new Isp_Url_Page($this->beanArticolo->A7Tea[0]->titolo_tea,
											$this->pageType,
											$this->page,
											$this->paramsArray,
											$this->beanArticolo->A7Tea[0]->abstract_tea);
		return $currentLevelUrl;									
		
	}
	
	public function skeleton(){
									
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->beanArticolo->A7Tea[0]->titolo_tea));
		
		// ABSTRACT	+ FOTO	
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAbstractFoto");
		$highlight = new SchedaAbstractFoto($this->beanArticolo,
											"articolo",
											$this->txt,
											$this->_urls->colors[$this->currentTab]);
		$this->add($highlight->snpOut);									
		
		// ARTICLE EXPANSION
		Isp_Loader::loadVistaObj("Bones", null, "SchedaEspansioniArticolo");
		$espansioni = new SchedaEspansioniArticolo(	$this->beanArticolo, 
													$this->thisPageUrl,
													$this->_urls->colors[$this->currentTab]);
		$this->add($espansioni->snpOut);
		
		// TECHNICAL CARD
		// waiting for ambra..
		

		// ANTEPRIMA FOTO
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAnteprimaFoto");
		$anteprima = new SchedaAnteprimaFoto(	$this->beanArticolo, 
												"articolo", 
												$this->txt,
												$this->_urls->colors[$this->currentTab]);
		
		$this->add($anteprima->anteprimaFoto);			
		
		// RUN IN TEMPLATE							
		return $this->useDefaultTemplate();
	}
}

?>
