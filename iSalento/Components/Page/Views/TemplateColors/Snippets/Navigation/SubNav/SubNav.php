<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Href snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Li");

/**
 * Sub navigation bar snippet.
 *
 */
class SubNav extends Isp_View_Snippet{
	public $snippetType = "Navigation";
	
	public $urlArray;
	public $color;
	
	/**
	 * Constructor
	 * 
	 * !CONVENTION: The input array must contain at least
	 * two items in order to make this snippet work. It 
	 * doesn't make sense to use a subBar with just one 
	 * item.
	 *
	 * @param array $url - the array of Isp_Urls of the bar
	 * @param string $color - if passed in the constructor 
	 * it will make the snippet to autorender.
	 * 
	 */
	public function __construct($urlArray, $color=null){
		
		// Store state
		$this->urlArray = $urlArray;
		$this->color = $color;
		
		parent::__contruct();
		
		// Ready to render by it self 
		if(isset($color)){
			$this->run();
		}	
	}
	
	/**
	 * Html code for sub nav in capsule style
	 * 
	 * @return html code.
	 */
	public function render(){
		// Open unordered list
		$code = $this->openTag(null,"sub_".$this->color,"ul");
			// First item (for left capsule formatting)
			$li = new Li($this->urlArray[0],"sub_".$this->color."_first","");
			$sxCap = $li->code;
			unset($this->urlArray[0]); // Don't use it for middle items
			
			// Last item (right capsule)
			$last = array_pop($this->urlArray); // Get and unset last item
			$li = new Li($last,"sub_".$this->color."_last","");
			$dxCap = $li->code;
			
			// Append left capsule code
			$code .= $sxCap;
			// Middle items
			foreach ($this->urlArray as $item){
				$li = new Li($item, null, "");
				$code .= $li->code;
			}
			
			$code .= $dxCap;
		$code .= $this->closeTag("ul");
		return $code;
	}
	
	
}
?>