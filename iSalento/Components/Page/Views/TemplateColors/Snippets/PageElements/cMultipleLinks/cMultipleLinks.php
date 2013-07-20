<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Clear");
Isp_Loader::loadVistaObj("Snippets","Html","Href");
Isp_Loader::loadVistaObj("Snippets","PageElements","MultipleLinksItem");

/**
 * Multiple links snippet to preview several sections 
 * in a small pic+title+abstract layout. This snippet 
 * may be incapsulated in a box.
 *	
 * EXAMPLE CODE:
 * 	<div class="blocchetto_links">
        <div class="colonna_sx"> MultipleLinksItem array </div>
        <div class="colonna_dx"> MultipleLinksItem array </div>
        <div class="clear_both"></div>
    </div>  
 */
class cMultipleLinks extends Isp_View_Snippet{
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $multipleLinksItemArray = null; 
	protected $clear; // Only for father access
	public $color = null;
	public $oneColumn = false;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classMultiple = 'blocchetto_links'; 
	public $classSxColon = 'colonna_sx'; 
	public $classDxColon = 'colonna_dx'; 
	public $classClear = 'both'; 


	/**
	 * Constructor
	 *
	 * @param matrix $urlMatrix -  it contains page and photo link. Eg.
	 * array(array($urlPage1, $urlPhoto1), array($urlPage2, $urlPhoto2))
	 * @param string $color - force color, if null default template color is used
	 * @param booelan $oneColums - set for one colums view
	 */
	public function __construct($urlMatrix, 
								$color = null, 
								$oneColumn = false){
									
		// Istantiate an array of items
		$multipleLinksItemArray = array();
		foreach ($urlMatrix as $pic){
			array_push($multipleLinksItemArray, new MultipleLinksItem($pic[0], $pic[1], $color));
		}
		
		// Store into object state
		$this->setState("multipleLinksItemArray",$multipleLinksItemArray);
		$this->setState("color", $color);
		$this->setState("oneColumn", $oneColumn);
		
		// Private internal snippet
		$clear = new Clear($this->classClear);
		$this->setState("clear",$clear);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		// Open blocchetto links div
		$code = $this->openTag(null,$this->classMultiple);
			// Due colonne
			if(!$this->oneColumn){
				// Left and right column code
				$sxColumn = "";
				$dxColumn = "";
				foreach ($this->multipleLinksItemArray as $key=>$snp){
					if($key % 2 == 0){ // If "pari" fill left column
						$sxColumn .= $snp->code;
					}else{ // dx column
						$dxColumn .= $snp->code;
					}
				}
				// Left column
				$code .= $this->openTag(null,$this->classSxColon);
					$code .= $sxColumn;
				$code .= $this->closeTag();
				// Right column
				$code .= $this->openTag(null,$this->classDxColon);
					$code .= $dxColumn;
				$code .= $this->closeTag();	
			}else{
				foreach ($this->multipleLinksItemArray as $snp){
					$code .= $snp->code;
				}
			}
			// Clear both
			$code .= $this->clear->code;

		// Close blocchett link div	
		$code .= $this->closeTag();
		
		return $code;
	}	

}
?>