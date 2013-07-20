<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista Localita
 *
 */
class ListaLocalita extends Isp_View_Page{
	public  $currentTab = 3;
	
	// Head info
	public $titleMeta = "Lista localita, iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha test..mare, spiagge nel Salento";
		
	// Object state
	public $comingPageInfo = array(); // for scheda to retrieve father list
	
	// Dictionary
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Localit&agrave - Spiagge, grotte, sport acquatici",
						"descriptionPage" =>"versione alpha di iSalento",
						"readAll" => "Leggi tutto..",
						"readAllDescription" => "Approfondisci"));
	
	// Dynamic data
	public $listaLocalita = null;
	
	public function getIngredients(){
		$ingredients['listaLocalita'] = array("A7B7Localita", "userParams");
		return $ingredients;
	}
	
	public function skeleton(){

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'], 
											$this->txt['descriptionPage']));
											
		// LISTA
		Isp_Loader::loadVistaObj("Bones", null, "ListaItems");
		$lista = new ListaItems($this->listaLocalita, 
								"localita",
								$this->txt,
								$this->comingPageInfo);
		$this->add($lista->snpOut);
		
		// RUN IN TEMPLATE		
		return $this->useDefaultTemplate();
	}
}

?>
