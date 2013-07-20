<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Li snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Li");

/**
 * EXAMPLE HTML CODE:
 *  <ul class="nav_lat_elenco nav_lat_elenco_grigio">
        <li class="nav_lat_titolo_grigio_chiaro"><a href="#">Collabora anche tu</a></li>
        <li><a href="#">Proponi un articolo</a></li>
        <li><a href="#">Aggiungi foto</a></li>
        <li><a href="#">Segnala evento</a></li>
        <li><a href="#">Segnala attrazioni</a></li>
        <li><a href="#">Le tue idee e commenti</a></li>
      </ul>
 */

/**
 * Side navigation bar.
 */
class SideListNav extends Isp_View_Snippet{
	public $snippetType = "Navigation";
		
	public $urlArray;
	public $color;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classNavLat = "nav_lat_elenco nav_lat_elenco_";
	public $classTitle = "nav_lat_titolo_";
	
	/**
	 * Constructor
	 * 
	 * !CONVENTION: The first item of the input array 
	 * contains the title of the bar. 
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
		$code = $this->openTag(null,$this->classNavLat.$this->color,"ul");
			// Title of the side bar
			$li = new Li($this->urlArray[0],null,$this->classTitle.$this->color);
			$code .= $li->code;
			unset($this->urlArray[0]); // Don't use it for middle items
			
			// Middle items
			foreach ($this->urlArray as $item){
				$li = new Li($item, null, "");
				$code .= $li->code;
			}
			
		$code .= $this->closeTag("ul");
		return $code;
	}
	
	
}
?>