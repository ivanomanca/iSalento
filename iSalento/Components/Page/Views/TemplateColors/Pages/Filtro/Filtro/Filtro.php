<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Lista struttura
 *
 */
class Filtro extends Isp_View_Page{
	
	public $currentTab;
	// Object state
	public $fotoSize = 100; // Default size
		
	
	public function useDefaultFiltro(){
														
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'], 
											$this->txt['descriptionPage']));
									
		// cMULTIPLE LINKS
		Isp_Loader::loadVistaObj("Bones", null, "FiltroMultipleLinks");
		$multiLinks = new FiltroMultipleLinks($this->_urls, $this->currentTab);
		
		// CASE BLOCK
		Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
		$this->add(new cCaseBlock(	$this->txt['blockTitle'], 
									null, 
									$multiLinks->cMultiple, 
									$this->_urls->colors[$this->currentTab]));
 	   
	}
	
	
}

?>
