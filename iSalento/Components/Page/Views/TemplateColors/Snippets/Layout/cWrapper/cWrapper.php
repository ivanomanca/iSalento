<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Meta","LinkRel");

/**
 * EXAMPLE:
 	$code .= $outDoctype;
 	$code .= <html xmlns=\"http://www.w3.org/1999/xhtml\">;
	 	$code .= $headOut;
		$code .= "<body>";
			$code .= "<div id=\"container\">";
				$code .= $outHeader;
				$code .= $outcPage;
			$code .= "</div>";
			// Javascript code
		$code .= "</body>";
	$code .= "</html>";
 */

/**
 * Total document wrapper for head and body.
 */
class cWrapper extends Isp_View_Snippet{
	public $snippetType = "Layout";
	
	// Input snippets
	public $doctype = null;
	public $head;
	public $header;
	public $page;
	// Section color
	public $color=null;
	public $homePage = false;
	public $appendJavascript = null;
	
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idContainer = "container"; // Page container
	public $classImgSfondo = "immagine_body_"; // Linea grafica
	
	/**
	 * Constructor
	 * 
	 * @param Doctype $doctype - doctype snippet
	 * @param cHead $head - a head snippet
	 * @param cHeader $header - header (logo+topNav)
	 * @param cCentralPage $page - central page snippet
	 * @param string $sectionColor 
	 * @param boolean $homePage - home page config
	 * @param Snippet | array $appendJavascript - snippet o array 
	 * di snippet contenenti codice in calce alla pagina (es. javascript)
	 */
	public function __construct(Doctype $doctype=null, 
								cHead $head=null,
								cHeader $header=null,
								$page=null,
								$color=null,
								$homePage = false,
								$appendJavascript = null){

		// Store into the object state
		$this->setState("doctype",$doctype);
		$this->setState("head",$head);
		$this->setState("header",$header);
		$this->setState("page",$page);
		$this->setState("color",$color);
		$this->setState("appendJavascript", $appendJavascript);
		
		// Setto il colore della linea di sfondo
		if($homePage){
			$this->classImgSfondo = $this->classImgSfondo."home";
		}else{
			$this->classImgSfondo = $this->classImgSfondo.$color;
		}

		
		parent::__contruct();
		
		// Set Css links first
		$linkRel = new LinkRel($this->cssList);
		$this->head->linkRel = $linkRel;
		$this->head->run();
			
		$this->run();
	}
	
	public function render(){
		
		// Doctype
		$code = $this->doctype->code; 				
		// Html
		$code .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">"; 
		// Head info
		$code .= $this->head->code;
		// Open body
		$code .= $this->openTag(null, $this->classImgSfondo, "body");
			// Div page container
			$code .= $this->openTag($this->idContainer);
				// Header info
				if(isset($this->header)){
					$code .= $this->header->code;
				}
				// Central page info
				if(isset($this->page)){
					$code .= $this->page->code;
				}
			// Close container
			$code .= $this->closeTag();
			// Javascript
			if(isset($this->appendJavascript)){
				if($this->appendJavascript instanceof Isp_View_Snippet){
					$code .= $this->appendJavascript->code;
				// If array of scripts	
				}elseif (is_array($this->appendJavascript)){
					foreach ($this->appendJavascript as $script){
						// Check for snippets
						if($script instanceof Isp_View_Snippet ){
							$code .= $script->code;
						// Check for strings
						}elseif(is_string($script)){
							$code .= $script;
						}
						
					}
				}
			}
			
		// Close body
		$code .= $this->closeTag("body");
		// Close html
		$code .= $this->closeTag("html");
		return $code;
	}
	
}
?>