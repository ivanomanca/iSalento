<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets", "Html", "Clear");

/**
 * PhotoGallery snippet.
 *	
 * EXAMPLE CODE:
 * 	 <span class="tr"></span>
        
    <div class="titolo_photo_gallery">
      <h1>GALLERIA FOTOGRAFICA</h1>
    </div>
    
	Isp_View_Snippet PhotoBreadcrumb
	
	Isp_View_Snippet photoItem
	
	Isp_View_Snippet PhotoBreadcrumb

	<div class="clear_both"/>
	<span class="br"/>
	<span class="bl"/>
 */
 
class cPhotoGallery extends Isp_View_Snippet{
	public $snippetType = "List";
	
	/**
	 * Object state
	 */
	public $pageTitle = null; 
	public $photoBreadUp = null;
	public $photoBreadDw = null;
	public $photoItem = null; 
	public $allowLeftNav = false;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classPageTitle = "titolo_photo_gallery";
	public $classTr = "tr"; // Top right round corner image
	public $classBl = "bl"; // bottom left
	public $classBr = "br"; // bottom right
	
	
	/**
	 * Constructor
	 *
	 * @param string $pageTitle 
	 * @param PhotoBreadcrumb $photoBreadUp - Isp_View_Snippet top separator 
	 * @param PhotoBreadcrumb $photoBreadDw - Isp_View_Snippet down separator 
	 * @param PhotoUl | PhotoCard $photoItem - Inner snippet (photo gallery or card)
	 * @param boolean $allowLeftNav - true to leave left margin for sx side  nav
	 */
	public function __construct($pageTitle = null, 
								$photoBreadUp = null, 
								$photoBreadDw = null,
								$photoItem = null,
								$allowLeftNav = false){
		// Store into object state
		$this->setState("pageTitle",$pageTitle);
		$this->setState("photoBreadUp",$photoBreadUp);
		$this->setState("photoBreadDw",$photoBreadDw);
		$this->setState("photoItem",$photoItem);
		$this->setState("allowLeftNav",$allowLeftNav);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		// Round top right corner 
		$code = $this->openTag(null, $this->classTr, "span");
		$code .= $this->closeTag("span");
		// Gallery title
		$code .= $this->openTag(null, $this->classPageTitle);
			$code .= "<h1>".$this->pageTitle."</h1>";
		$code .= $this->closeTag();
		// Upper photo breadcrumb, indicates page numebers
		if(isset($this->photoBreadUp)){
			$code .= $this->photoBreadUp->code;
		}
		// Actual photo gallery list or card
		if(isset($this->photoItem)){
			$code .= $this->photoItem->code;
		}
		// Bottom photo breadcrumb
		if(isset($this->photoBreadDw)){
			$code .= $this->photoBreadDw->code;
		}
		// Clearer
		$clear = new Clear("both");
		$code .= $clear->code;
		
		// Round bottom left corner 
		$code .= $this->openTag(null, $this->classBl, "span");
		$code .= $this->closeTag("span");
		// Round bottom right corner 
		$code .= $this->openTag(null, $this->classBr, "span");
		$code .= $this->closeTag("span");
		
		return $code;
	}	

}
?>