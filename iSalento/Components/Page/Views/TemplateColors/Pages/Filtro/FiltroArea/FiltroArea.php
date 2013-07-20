<?
Isp_Loader::loadClass('Isp_View_Page');
Isp_Loader::loadVistaObj("Pages","Filtro", "Filtro");
/**
 * Filtro Mare
 *
 */
class FiltroArea extends Filtro{
	public $currentTab = 3;
	// Static txt
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Area Salento - Spiagge, grotte, sport acquatici",
					"descriptionPage" =>"versione alpha di iSalento",
					"blockTitle" => "SALENTO",
					"readAll" => "Leggi tutto.."),
					);
	
					
	public function skeleton(){
		
		$this->useDefaultFiltro();
    	
    	return $this->useDefaultTemplate();
 	   
	}
}

?>
