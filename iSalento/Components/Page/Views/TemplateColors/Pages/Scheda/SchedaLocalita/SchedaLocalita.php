<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista Localita
 *
 */
class SchedaLocalita extends Isp_View_Page{
	public  $currentTab = 3; // Tab di appartenenza
	
	// Head info
	public $titleMeta = "Scheda iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha test..mare, spiagge nel Salento";
	
	// Dictionary
	public $dictionary = array( 
		   "it" =>  array( "titlePage" => "Scheda localita - 
											Spiagge, grotte, sport acquatici",
						   "descriptionPage" =>"versione alpha di iSalento",
						   "inBreve" => "In breve",
						   "readAllFoto" => "VEDI TUTTE >>",
						   "anteprimaFoto" => "Anteprima foto",
						   "descrAnteprimaFoto" => "Alcune foto in anteprima per ",
						   "descrReadAllFoto" => "Vedi tutte le foto "));
							
	// Dynamic data
	public $beanLocalita = null;
	
	public function getIngredients(){
		$ingredients['beanLocalita'] = array("B7Localita", "userParams");
		return $ingredients;
	}
	
	public function setThisPageUrl(){
		$currentLevelUrl = new Isp_Url_Page($this->beanLocalita->Localita->nome_localita,
											$this->pageType,
											$this->page,
											$this->paramsArray,
											$this->beanLocalita->A7B7Articolo[0]
																->A7Tea[0]->titolo_tea);
		return $currentLevelUrl;									
		
	}
	
	public function skeleton(){
		// Accorcio il nome :D
		$articolo = $this->beanLocalita->A7B7Articolo[0]; 
		
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($articolo->A7Tea[0]->titolo_tea));
		
		// ABSTRACT + FOTO
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAbstractFoto");
		$highlight = new SchedaAbstractFoto($this->beanLocalita,
											"localita",
											$this->txt,
											$this->_urls->colors[$this->currentTab]);
		$this->add($highlight->snpOut);			
			
		// ARTICLE EXPANSION
		Isp_Loader::loadVistaObj("Bones", null, "SchedaEspansioniArticolo");
		$espansioni = new SchedaEspansioniArticolo(	$articolo, 
													$this->thisPageUrl,
													$this->_urls->colors[$this->currentTab]);
		$this->add($espansioni->snpOut);
															
		// TECHNICAL CARD
		// waiting for ambra and dany..
		
		// ANTEPRIMA 4 FOTO
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAnteprimaFoto");
		$anteprima = new SchedaAnteprimaFoto(	$this->beanLocalita, 
												"localita", 
												$this->txt,
												$this->_urls->colors[$this->currentTab]);
		
		$this->add($anteprima->anteprimaFoto);										
												
		// RUN IN TEMPLATE							
		return $this->useDefaultTemplate();
	}
}

?>
