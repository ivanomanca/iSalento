<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista struttura
 *
 * @todo settare le head info in dinamico!
 */
class ListaStruttura extends Isp_View_Page{
	public $currentTab = 1;
	
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
	public $listaStruttura = null;
	
	public function getIngredients(){
		
		// Beaner	
		$ingredients['listaStruttura'] = array("A7B7Struttura", "userParams");
		
		return $ingredients;
	}
	
	public function skeleton(){
		
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'], 
											$this->txt['descriptionPage']));
											
		// LISTA
		Isp_Loader::loadVistaObj("Bones", null, "ListaItems");
		$lista = new ListaItems($this->listaStruttura, 
								"struttura",
								$this->txt,
								$this->comingPageInfo);
		$this->add($lista->snpOut);
		
		// RUN IN TEMPLATE		
		return $this->useDefaultTemplate();
		
	}
}

?>
