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
	
	Isp_View_Snippet PhotoUl
	
	Isp_View_Snippet PhotoBreadcrumb

	<div class="clear_both"/>
	<span class="br"/>
	<span class="bl"/>
 */
 
class cPhotoGallery extends Isp_View_Snippet{
	public $snippetType = "Boxes";
	
	/**
	 * Object state
	 */
	public $pageTitle = null; 
	public $photoBreadUp = null;
	public $photoBreadDw = null;
	public $photoUl = null; 
	public $allowLeftNav = false;
	public $anchorName = "vistaFoto";
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classPageTitle = "titolo_photo_gallery";
	public $classTr = "tr"; // Top right round corner image
	public $classBl = "bl"; // bottom left
	public $classBr = "br"; // bottom right
	
	
	
	public function __construct($pageTitle = null, 
								$photoBreadUp = null, 
								$photoBreadDw = null,
								$photoUl = null,
								$allowLeftNav = false){
		// Store into object state
		$this->setState("pageTitle",$pageTitle);
		$this->setState("photoBreadUp",$photoBreadUp);
		$this->setState("photoBreadDw",$photoBreadDw);
		$this->setState("photoUl",$photoUl);
		$this->setState("allowLeftNav",$allowLeftNav);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		// Round top right corner 
		$code = $this->openTag(null, $this->classTr, "span", true);

		// Gallery title
		$code .= $this->openTag(null, $this->classPageTitle);
			// Anchor per visualizzare direttamente il riquadro foto
			$code .= "<a name=\"$this->anchorName\"></a>";
			$code .= "<h1>".$this->pageTitle."</h1>";
		$code .= $this->closeTag();
		// Upper photo breadcrumb, indicates page numebers
		if(isset($this->photoBreadUp)){
			$code .= $this->photoBreadUp->code;
		}
		// Actual photo gallery list
		if(isset($this->photoUl)){
			$code .= $this->photoUl->code;
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