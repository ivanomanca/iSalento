<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Href");
Isp_Loader::loadVistaObj("Snippets","Html","Clear");

/**
 * Single item of a Multiple Links filter. The item is made up
 * of pic+title+description.
 *	
 * EXAMPLE CODE:
 * 	<div class="box_lista_links, box_lista_color">
      <div class="box_foto_lista_links"> 
      	<a href="page.html"><img alt="" title="" src="image.jpg"></img></a> 
      </div>
                  
      <a href="page.html">Traditional London Pubs</a><br/>
      Sup a pint of ale in one of London's atmospheric
      
      <div class="clear_left">&nbsp;</div>
    </div>
 */
class MultipleLinksItem extends Isp_View_Snippet{
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $url = null;
	public $urlPhoto = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classBox = 'box_lista_links'; 
	public $classBoxPhoto = 'box_foto_lista_links'; 
	public $classClear = 'left'; 
	public $classColor = 'box_lista_';

	/**
	 * Constructor of the single item
	 *
	 * @param Isp_Url $titleUrl - title 
	 * @param Isp_Url_Photo $urlPhoto - pic link
	 */
	public function __construct(Isp_Url $url = null, Isp_Url_Photo $urlPhoto = null, $color = null){
		// Store into object state
		$this->setState("url",$url);
		$this->setState("urlPhoto",$urlPhoto);
		if(isset($color)){
			$this->classColor = $this->classColor.$color;
		}else{
			$this->classColor = null;
		}
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		if(isset($this->classColor)){
			$classBox = $this->classBox." , ".$this->classColor;
		}else{
			$classBox = $this->classBox;
		}
		// Open global box div
		$code = $this->openTag(null, $classBox);
			
			if(isset($this->urlPhoto)){
				// Open box photo
				$code .= $this->openTag(null,$this->classBoxPhoto);
					// Photo link
					$href = new Href($this->url, null, null, $this->urlPhoto);
					$code .= $href->code;
				// Close box photo
				$code .= $this->closeTag();
			}
			
			// Title
			$hrefTitle = new Href($this->url);
			$code .= $hrefTitle->code;
			$code .= "<br />";
			
			// Description
			$code .= $this->url->description;
		
			// Clear left
			$clear = new Clear($this->classClear,true);
			$code .= $clear->code;
			
		// Close box 
		$code .= $this->closeTag();
		return $code;
	}	

}
?>