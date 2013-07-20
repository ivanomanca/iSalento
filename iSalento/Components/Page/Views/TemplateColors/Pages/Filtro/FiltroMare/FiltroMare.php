<?
Isp_Loader::loadClass('Isp_View_Page');
Isp_Loader::loadVistaObj("Pages","Filtro","Filtro");
/**
 * Filtro Mare
 *
 */
class FiltroMare extends Filtro{
	public $currentTab = 1;
	// Static txt
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Mare Salento - Spiagge, grotte, sport acquatici",
					"descriptionPage" =>"Questa &egrave la descrizione della pagina 
										 per la versione alpha di iSalento",
					"blockTitle" => "MARE",
					"readAll" => "Leggi tutto..",
					"loginButton" => "Accedi",
					"ciao" => "Ciao",
					"user" => "User",
					"pass" => "Pass"),
					
			"en" =>
			array(	"titlePage" => "Salento's beaches",
					"descriptionPage" => "Here is a page description..")		
								);
	
	/**
	 * Build actual page code.
	 *
	 */
	public function skeleton(){
		
		$this->useDefaultFiltro();
    	
    	return $this->useDefaultTemplate();
 	   
	}
	
	
}

?>
