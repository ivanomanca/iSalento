<?
Isp_Loader::loadClass('Isp_View_Page');
Isp_Loader::loadVistaObj("Pages","Filtro","Filtro");
/**
 * Filtro Foto
 *
 */
class FiltroFoto extends Filtro{
	public  $currentTab = 2;
	// Static txt
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "Foto Salento - Spiagge, grotte, sport acquatici",
					"descriptionPage" =>"versione alpha di iSalento",
					"blockTitle" => "FOTO",
					"readAll" => "Leggi tutto.."),
					);
	
					
	public function skeleton(){
		
		$this->useDefaultFiltro();	
    	return $this->useDefaultTemplate();
 	   
	}
}

?>
