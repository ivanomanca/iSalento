<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 *
 */
class SchedaStruttura extends Isp_View_Page{
	public $currentTab = 1; // Tab di appartenenza
		
	// Head info
	public $titleMeta = "Scheda iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha ..mare, spiagge nel Salento";
	
	// Object state
	public $colonneServizi = 2;
	public $urlAdd;
	public $linkAddExpansion; 
	
	// Dictionary
	public $dictionary = array( 
		   "it" =>  array( "titlePage" => "Scheda struttura - 
											Spiagge, grotte, sport acquatici",
						   "descriptionPage" =>"versione alpha di iSalento",
						   "inBreve" => "In breve",
						   "readAllFoto" => "VEDI TUTTE >>",
						   "anteprimaFoto" => "Anteprima foto",
						   "descrAnteprimaFoto" => "Alcune foto in anteprima per ",
						   "descrReadAllFoto" => "Vedi tutte le foto ",
						   // Scheda tecnica
						   "schedaTecnica" => "DETTAGLI : ",
						   "nomeStruttura" => "Nome",
						   "tipoStruttura" => "Tipo",
						   //add expansion
						   "titleAddExpansion" => "Aggiungi paragrafo all'articolo",
						   "addExpansion" => "Aggiungi paragrafo"),
			"en" => array( "titlePage" => "Attraction Page",
						   "descriptionPage" =>"iSalento alpha version framework",
						   "inBreve" => "At a glace")
						   );
		
	// Dynamic data
	public $beanStruttura = null;
	
	public function getIngredients(){
		$ingredients['beanStruttura'] = array("B7Struttura", "userParams");
		return $ingredients;
	}
	
	public function setThisPageUrl(){
		$currentLevelUrl = new Isp_Url_Page(
										$this->beanStruttura->Struttura->nome_struttura,
										$this->pageType,
										$this->page,
										$this->paramsArray,
										$this->beanStruttura->A7B7Articolo[0]
																->A7Tea[0]->titolo_tea);
		return $currentLevelUrl;									
		
	}
	
	public function skeleton(){
		// Accorcio il nome :D
		$articolo = $this->beanStruttura->A7B7Articolo[0]; 
		
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($articolo->A7Tea[0]->titolo_tea));
		
		// ABSTRACT + FOTO
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAbstractFoto");
		$highlight = new SchedaAbstractFoto($this->beanStruttura,
											"struttura",
											$this->txt,
											$this->_urls->colors[$this->currentTab]);
		$this->add($highlight->snpOut);			
			
		// ARTICLE EXPANSION
		Isp_Loader::loadVistaObj("Bones", null, "SchedaEspansioniArticolo");
		$espansioni = new SchedaEspansioniArticolo(	$articolo, 
													$this->thisPageUrl,
													$this->_urls->colors[$this->currentTab]);
		$this->add($espansioni->snpOut);
										
/**
 * *************************************
 */     //By Dany

		//ADD EXPANSION
		if($this->privilegi<=1)
		{
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			$urlAddExpansion = new Href(new Isp_Url($this->linkAddExpansion,$this->txt['titleAddExpansion'], $this->txt['addExpansion']));
		
			$this->add($urlAddExpansion);
			$this->add( "<br>"); 
			$this->add( "<br>"); 
		}
/**
 * *************************************
 */
		
			
		// TECHNICAL CARD
		$titoloSchedaTecnica = "<h2>".$this->txt['schedaTecnica'];
		$titoloSchedaTecnica .= $this->beanStruttura->Struttura->nome_struttura."</h2>";
		$this->add($titoloSchedaTecnica);
		
		// Snippet che stampa un elenco puntato
		$serviziArray = array();
		foreach ($this->beanStruttura->A7Servizio as $servizio){
			array_push($serviziArray, $servizio->nome_servizio);
		}
		
		Isp_Loader::loadVistaObj("Snippets", "Card", "ElencoPuntatoTabella");
		$serviziSnippet = new ElencoPuntatoTabella($serviziArray, $this->colonneServizi);				
		// Preparo i valori per lo snippet schedaTecnica
		$matrix = array(
						array(	$this->txt['nomeStruttura'], 
								$this->beanStruttura->Struttura->nome_struttura),
						array(	$this->txt['tipoStruttura'], 
								ucfirst($this->beanStruttura->Struttura->nome_tipostruttura)),
					//	array("cico","::test vecchio::"),		
						
						
						// Continua tu dany - questo � il test vecchio!!
					//	array("Nome", "Cocoloco"),
						//array("Tipo", "Spiaggia"),
					//	array("Posti", 100),
						array("Servizi", $serviziSnippet)	
						);
		
		// Carico e istanzio lo snippet scheda tecnica
		Isp_Loader::loadVistaObj("Snippets", "Card", "SchedaTecnica");
		$this->add(new SchedaTecnica($matrix));
		// Some breaks lines
		$this->add("<br /><br />");
		
		// ANTEPRIMA 4 FOTO
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAnteprimaFoto");
		$anteprima = new SchedaAnteprimaFoto(	$this->beanStruttura, 
												"struttura", 
												$this->txt,
												$this->_urls->colors[$this->currentTab]);
		
		$this->add($anteprima->anteprimaFoto);										
												
		// RUN IN TEMPLATE							
		return $this->useDefaultTemplate();
	}
}

?>
