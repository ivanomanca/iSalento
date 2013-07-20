<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 *
 */
class ListaArticolo extends Isp_View_Page{
	public $currentTab = 4;
	
	 // Head info
	public $titleMeta = "Lista Articoli, iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha..mare, spiagge nel Salento";
	
	// Object state
	public $comingPageInfo = array(); // for scheda to retrieve father list
	
	// Dictionary
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Rubriche - Spiagge, grotte, sport acquatici",
					"descriptionPage" =>"versione alpha di iSalento",
					"readAll" => "Leggi tutto..",
					"readAllDescription" => "Approfondisci"));
	
	// Dynamic data
	public $listaArticolo = null;
	
	public function getIngredients(){
		$ingredients['listaArticolo'] = array("A7B7Articolo", "userParams");
		return $ingredients;
	}
	
	public function skeleton(){
									
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'], 
											$this->txt['descriptionPage']));
		
		// LISTA
		Isp_Loader::loadVistaObj("Bones", null, "ListaItems");
		$lista = new ListaItems($this->listaArticolo, 
								"articolo",
								$this->txt,
								$this->comingPageInfo);
		$this->add($lista->snpOut);
		
		return $this->useDefaultTemplate();
	}
}

?>
