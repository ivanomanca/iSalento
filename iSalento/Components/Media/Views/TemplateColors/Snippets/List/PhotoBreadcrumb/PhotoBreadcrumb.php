<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets", "Html", "Clear");
Isp_Loader::loadVistaObj("Snippets", "Html", "Href");

/**
 * PhotoGallery snippet.
 *	
 * EXAMPLE CODE:
 * 	  <div class="separatore">
          <div class="left">
            <h6>Pagina 1 di<a href=""> 4</a> </h6>
          </div>
          
          <div class="right"> 
          	<a  class="frecce_blu_sx" title="Indietro" href="">Indietro</a> 
          	<span> 1</span> | 
          	<a title="Pagina 2 di 4" href="">2</a> | 
          	<a title="Pagina 3 di 4" href="">3</a> 
          	<a class="frecce_blu_dx" title="Avanti" href="">Avanti</a> 
          </div>
          
          <div class="clear_both"></div>
       </div>
 */
 
class PhotoBreadcrumb extends Isp_View_Snippet{
	public $snippetType = "List";
	
	/**
	 * Object state
	 */
	public $leftArray = null; 
	public $leftTxtArray = null; 
	public $avantiIndietro = null;
	public $itemsArray = null;	
	public $separatorSymbol = "|";
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classSeparator = "separatore";
	public $classLeft = "left"; 
	public $classRight = "right"; 
	public $classFrecceSx = "frecce_blu_sx"; 
	public $classFrecceDx = "frecce_blu_dx"; 
	
	
	/**
	 * Contructor
	 *
	 * @param array $leftTxtArray - it contains text for left counter. Eg. "Pagina" 1 "di" 4;
	 * where $leftTxtArray[0] = "Pagina"; $leftTxtArray[1] = "di";
	 * @param array $leftArray - it contains number of Isp_Url for left counter. 
	 * Eg. Pagina "1" di "4" where $leftArray[0] = (int) 1; $leftArray[1] = (Isp_Url) 4
	 * @param array $avantiIndietro - array of Isp_Url for next/back page link. 
	 * Eg. "Indietro" 1 | 2 | 3 "Avanti" where $avantiIndietro[0] = Isp_Url "Indietro". 
	 * @param array $itemsArray - array of Isp_Url for pages (eg. 1 | 2 | 3). If an int 
	 * instead of Isp_Url is passed, it will display the current page.
	 */
	public function __construct($leftTxtArray = null,
								$leftArray = null, 
								$avantiIndietro = null, 
								$itemsArray = null){
		// Store into object state
		$this->setState("leftTxtArray",$leftTxtArray);
		$this->setState("leftArray",$leftArray);
		$this->setState("avantiIndietro",$avantiIndietro);
		$this->setState("itemsArray",$itemsArray);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Div separatore
		$code = $this->openTag(null, $this->classSeparator);
			// LEFT
			if(isset($this->leftArray)){
				$code .= $this->openTag(null, $this->classLeft);
					// Es. Pagina 
					$code .= "<h6>".$this->leftTxtArray[0]." ";
					// Current page or photo number
					$code .= $this->leftArray[0]." ".$this->leftTxtArray[1]." ";
					// Total number of items
					//if(isset($this->leftArray[1])){
						$totHref = new Href($this->leftArray[1]);
						$code .= $totHref->code;
					//}
				// Close left div	
				$code .= $this->closeTag();
			}
			// RIGHT
			if(isset($this->avantiIndietro) or isset($this->itemsArray)){
				$code .= $this->openTag(null, $this->classRight);
				// Indietro
				if(isset($this->avantiIndietro[0])){
					$indietro = new Href($this->avantiIndietro[0], null, $this->classFrecceSx );
					// Inject class name in Href and re-render
					//$indietro->class = $this->classFrecceSx;
					//$indietro->run();
					$code .= $indietro->code;
				}
				// Page or Photo Links
				if(isset($this->itemsArray)){
					foreach ($this->itemsArray as $key => $link){
						if(is_int($link)){
							$code .= "<span> $link </span>";
						}elseif ($link instanceof Isp_Url){
							$itemHref = new Href($link);
							$code .= $itemHref->code;
						}
						// Separator
					    $code .= " ".$this->separatorSymbol;
		
					}
					
					// Remove last separator
					rtrim($code, $this->separatorSymbol);
				}
				// Avanti
				if(isset($this->avantiIndietro[1])){
					$avanti = new Href($this->avantiIndietro[1], null, $this->classFrecceDx);
					// Inject class name in Href and re-render
					//$avanti->class = $this->classFrecceDx;
					//$avanti->run();
					$code .= $avanti->code;
				}
				$code .= $this->closeTag();	
			}
			// CLEARER
			$clear = new Clear("both");
			$code .= $clear->code;
		
		$code .= $this->closeTag();	
		
		return $code;
	}	

}
?>