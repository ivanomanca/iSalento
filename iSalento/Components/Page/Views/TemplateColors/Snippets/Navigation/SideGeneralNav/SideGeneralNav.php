<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Li snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Li");

/**
 * EXAMPLE HTML CODE:
 *  <div class="nav_lat_generica">
        <div class="nav_lat_titolo_generica nav_lat_titolo_arancione">
          <h4><a href="#">Blocchetto generico</a></h4>
        </div>
        <div class="nav_lat_corpo_generica nav_lat_corpo_arancione">
        	 $snippet or strings!
        </div>
      </div>
 */

/**
 * Side navigation bar: general reusable
 */
class SideGeneralNav extends Isp_View_Snippet{
	public $snippetType = "Navigation";
		
	// Object state
	public $urlTitle = null;
	public $color = null;
	public $innerSnp = null;
	private $title = null;
	private $corpo = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classNavLat = "nav_lat_generica";
	public $classTitle = "nav_lat_titolo_generica nav_lat_titolo_";
	public $classCorpo = "nav_lat_corpo_generica nav_lat_corpo_";
	
	/**
	 * Constructor
	 *
	 * @param Isp_Url | string $urlTitle
	 * @param string $color
	 * @param Isp_Snippet | string | array $innerSnp -  contenuto interno
	 */
	public function __construct($urlTitle = null, $color = null, $innerSnp = null){

		// Store state
		$this->setState("urlTitle", $urlTitle);
		$this->setState("color", $color);
		$this->setState("innerSnp", $innerSnp);
		
		// Set colors
		if(isset($color)){
			$this->classTitle = $this->classTitle.$color;
			$this->classCorpo = $this->classCorpo.$color;
		}
		
			// Title check
		if(isset($this->urlTitle) and ($this->urlTitle instanceof Isp_Url)){
			$href = new Href($this->urlTitle);
			$this->title = $href->code;
		}elseif(isset($this->urlTitle) and is_string($this->urlTitle)){
			$this->title = $this->urlTitle;
		}else{
			$this->title = null;
		}
		// Corpo check
		$this->corpo = null;
		if(isset($this->innerSnp)){
			if($this->innerSnp instanceof Isp_View_Snippet){
				$this->corpo = $this->innerSnp->code;
			}elseif(is_string($this->innerSnp)){
				$this->corpo = $this->innerSnp;
			}elseif(is_array($this->innerSnp)){
				foreach ($this->innerSnp as $snp){
					if($snp instanceof Isp_View_Snippet){
						$this->corpo .= $snp->code;
					}else{
						$this->corpo .= $snp;
					}
				}
				
			}
		}
		
		parent::__contruct();		
		
		// Ready to render by it self 
		$this->run();
		
	}
	
	/**
	 * Html code for sub nav in capsule style
	 * 
	 * @return html code.
	 */
	public function render(){
	
		
		// Open nav 
		$code = $this->openTag(null, $this->classNavLat);
			// TITOLO
			$code .= $this->openTag(null, $this->classTitle);
				// h4
				$code .= "<h4>".$this->title."</h4>";
			// Close title
			$code .= $this->closeTag();	
			// CORPO
			$code .= $this->openTag(null, $this->classCorpo);
				// Code inside
				$code .= $this->corpo;
			// Close title
			$code .= $this->closeTag();
		// Close nav	
		$code .= $this->closeTag();
		return $code;
	}
	
}
?>