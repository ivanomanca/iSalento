<?
Isp_Loader::loadClass('Isp_View_Bones');
/**
 * Astrazione di blocchetti per linkare diverse liste.
 *
 */
class FiltroMultipleLinks extends Isp_View_Bones{
	
	public $cMultiple = null;
	
	/**
	 * Constructor
	 *
	 * @param NavigationUrls $_urls - un Isp_View_Reusable di configurazione
	 * @param int $currentTab
	 */
	public function __construct(NavigationUrls $_urls, $currentTab){
		// cMULTIPLE LINKS for Filter type page
		$linksMatrix = array();
		foreach ($_urls->subUrls[$currentTab] as $urlPage){
			// Build url Photo page preview from default settings	
			// Or set an url page preview config array here!						
			if(isset($urlPage->previewPhotoLink)){
				$urlPhoto = new Isp_Url_Photo(	null, 
												null,
												$urlPage->title,
												$urlPage->description,
												$urlPage->previewPhotoLink);
			}else{
				$urlPhoto = null;
			}
			$pic  = array($urlPage, $urlPhoto);
			array_push($linksMatrix, $pic);
		}
		
		Isp_Loader::loadVistaObj("Snippets","PageElements","cMultipleLinks");
		$this->cMultiple = new cMultipleLinks($linksMatrix);
		
		array_push($this->snpOut, $this->cMultiple);
		
	}

}
?>