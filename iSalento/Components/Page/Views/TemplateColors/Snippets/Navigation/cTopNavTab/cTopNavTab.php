<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Navigation","SubNav");
/** Href snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 * Abstraction of the single Tab code for the 
 * Top navigation bar. It may handle a sub navibation 
 * bar snippet if passed as input.
 */
class cTopNavTab extends Isp_View_Snippet{
	public $snippetType = "Navigation";
		
	public $coloreSezione;
	public $url = null;
	public $sub = null;
	public $currentColor = null;
	public $firstLast = null; // string 'first' or 'last'
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classCurrent = "current";
	/**
	 * Contructor
	 *
	 * @param string $coloreSezione - color tab
	 * @param Isp_Url $url - a url object
	 * @param cSub_Nav $sub - a sub bar snippet object
	 * @param string $currentColor - it displays the subar 
	 * @param string $firstLast - 'first' or 'last' tab item (add round corners)
	 * if this color matches $coloreSezione
	 * 
	 */
	public function __construct($coloreSezione,
								Isp_Url $url,
								SubNav $sub = null,
								$currentColor = null,
								$firstLast = null){

		// Store into the object state
		$this->setState("coloreSezione",$coloreSezione);
		$this->setState("url",$url);
		$this->setState("sub",$sub);
		$this->setState("currentColor",$currentColor);
		$this->setState("firstLast",$firstLast);
		
		parent::__contruct();	
			
		// Ready to render by it self 
		if(isset($currentColor)){ // If color is passed as input
			$this->run();
		}	
	}
	
	public function render(){
		// The user is navigating in this tab (check matches color)
		if(isset($this->currentColor) && $this->currentColor == $this->coloreSezione){
			$currentClass = $this->classCurrent;
		}else{
			$currentClass = null;
		}
		
		// First-Last item check
		if(isset($this->firstLast)){
			$classFirstLast = $this->firstLast."_tab_img";
		}else{
			$classFirstLast = null;
		}
		
		// Li with section color (and opzional current class)
		$code = $this->openTag($this->coloreSezione,$classFirstLast." ".$currentClass,"li");
			// Internal url
			$href = new Href($this->url, null, $currentClass);
			$code .= $href->code;
			// Internal sub bar
			if(isset($this->sub)){
				$this->sub->color = $this->coloreSezione; // Assign color
				$this->sub->run(); // Render code
				$code .= $this->sub->code;
			}
		$code .= $this->closeTag("li");
		return $code;
	}
	
	/*
	public function defineCss(){
		$this->appendCss($this->getDefaultCss());
		$this->appendCss($this->sub->cssList);
		
	}
	*/
}
?>