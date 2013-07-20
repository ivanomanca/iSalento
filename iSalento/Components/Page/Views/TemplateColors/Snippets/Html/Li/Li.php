<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Href snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 * List item abstraction. It is the basic element of a <ul> element.
 * 
 * EXAMPLE CODE:
  	<li id="" class=""><a href="#prima_parte">Prima parte</a></li>
 */
 
class Li extends Isp_View_Snippet{
	public $snippetType = "Html";
	
	/**
	 * Object state
	 */
	public $urlOrText = null; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $class = null; // Passed from input
	public $id = null; // Passed from input
	
	/**
	 * Abstraction of single list item element.
	 *
	 * @param mixed $urlOrText - a Isp_Url or simple text or array of Isp_Url
	 * to print in the list item
	 * @param string $id
	 * @param string$class
	 * @return rendered html code
	 */
	public function __construct($urlOrText=null, $id=null, $class=null){
									
		// Store into object state
		$this->setState("urlOrText",$urlOrText);
		$this->setState("id",$id);
		$this->setState("class",$class);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	
	public function render(){
		
		$code = $this->openTag($this->id, $this->class, "li");
			// If text
			if(isset($this->urlOrText) and is_string($this->urlOrText)){
				$code .= $this->urlOrText;
			}elseif(isset($this->urlOrText) and $this->urlOrText instanceof Isp_Url){ // Url
				$href = new Href($this->urlOrText);
				$code .= $href->code;
			}elseif (isset($this->urlOrText) and is_array($this->urlOrText)){ // Array di url
				foreach ($this->urlOrText as $url){
					$href = new Href($url);
					$code .= $href->code;
				}
			}
		$code .= $this->closeTag("li");
		return $code;
	
	}	
}
?>