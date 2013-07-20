<?
Isp_Loader::loadClass('Isp_View_Page');
Isp_Loader::loadVistaObj("Pages","Filtro","Filtro");
/**
 * Filtro Articolo
 *
 */
class FiltroArticolo extends Filtro{
	public  $currentTab = 4;
	
	// Static txt
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Rubriche - Spiagge, grotte, sport acquatici",
					"descriptionPage" =>"versione alpha di iSalento",
					"blockTitle" => "RUBRICHE",
					"readAll" => "Leggi tutto.."),
					);
	
					
	public function skeleton(){
		
		$this->useDefaultFiltro();	
    	return $this->useDefaultTemplate();
 	   
	}
}

?>
