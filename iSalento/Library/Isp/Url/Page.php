<?php
/** Isp_Url Object */
require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Url.php");

/**
 * Vista link object to manage either page links.
 */
class Isp_Url_Page extends Isp_Url{

	public $pageType = null; // Useful to assess the page navigation level
	public $page = null;
	public $paramsArray = array();
	public $pageFolder = null;
	public $previewPhotoLink = null;


	/**
	 * It builds up the Page link. eg:
	 * index.php?component=Page&task=getPage&pageType=Extra&page=ExtraHome
	 *
	 * @param string $pageType - the type (folder) of page
 	 * @param string $page - page name
 	 * @param string $title - title to display
 	 * @param array $paramsArray - page filter params; eg. array(id_localita => 1)
 	 * @param string $description - description for human reading
 	 * @param string $previewPhotoName - Name of picture to show ("foto mare.jpg")
	 * @param string $relative - don't automatically use $_SERVER['DOCUMENT_ROOT'].
	 * Prepend the $relative string to the path (es. ../../).
	 *
	 */
	public function __construct(	$title = null,
											$pageType,
											$page,
											$paramsArray = null,
											$description = null,
											$previewPhotoName = null,
											$relative = null){


		parent::__construct(null, $title, $description, $relative);
		// BUILD PATH FOR PAGE CALL
		// Capitalize for convention
		$pageType = ucfirst($pageType);
		$this->pageType = $pageType;
		$page = ucfirst($page);
		$this->page = $page;
		// Path
		$this->path .= "index.php?component=Page&task=getPage&pageType=";
		$this->path .= $this->pageType."&page=".$this->page;
		// Construct params for $_GET link
		if(isset($paramsArray)){
			$this->paramsArray = $paramsArray; // Set state
			foreach ($paramsArray as $param=>$value){
				$this->path .= "&".$param."=".$value;
			}
		}

		// GET PAGE FOLDER
		$this->pageFolder = Isp_Loader::getPageFolder(	$this->pageType,
														$this->page,
														$this->paramsArray);
		// BUILD PHOTO PREVIEW LINK
		if(isset($previewPhotoName)){
			$this->previewPhotoLink = $this->pageFolder."Images/".$previewPhotoName;
		}
	}
}
?>