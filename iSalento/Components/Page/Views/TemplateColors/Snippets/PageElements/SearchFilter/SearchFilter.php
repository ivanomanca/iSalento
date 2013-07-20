<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Filter for list results.
 *	
 * EXAMPLE CODE:
 * 	<div class="ricerca_singola"> 
 * 	  <span>Mostra articoli solo per:</span>
      $selectSnippet->code
      <span> <input id="button1" type="submit" value="Vai" /> </span> 
    </div>
     
     @todo This needs a form!
     @todo span that wraps input tag in un necessary
 */
 
class SearchFilter extends Isp_View_Snippet{
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $titleHeader = null; // Title to set in the wrapping box
	public $description = null; 
	public $selectSnippet = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classSearchFilter = 'ricerca_singola'; 
	public $classHeader = 'cerca'; // To set in the wrapping box 
	
	/**
	 * Constructor
	 *
	 * @param string $titleHeader - title to put on header
	 * @param string $classHeaderInput - class name for inside header element
	 * @param Isp_View_Snippet $selectSnippet - snippet or to insert in 
	 * the box
	 */
	public function __construct($titleHeader=null, 
								$description=null, 
								$selectSnippet=null,
								$color=null){
		// Store into object state
		$this->setState("titleHeader",$titleHeader);
		$this->setState("description",$description);
		$this->setState("selectSnippet",$selectSnippet);
		$this->setState("color",$color);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Div ricerca singola
		$code = $this->openTag(null,$this->classSearchFilter);
			// Span for description
			$code .= "<span>".$this->description."</span>";
			// Select
			$code .= $this->selectSnippet->code;
			$code .= "<span> <input id=\"button1\" type=\"submit\" value=\"Vai\" /></span>";
			
		$code .= $this->closeTag();
		return $code;
	}	

}
?>