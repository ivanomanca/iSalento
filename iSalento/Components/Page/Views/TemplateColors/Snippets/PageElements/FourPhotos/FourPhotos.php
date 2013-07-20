<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 * It shows 4 aligned small pictures for preview.
 *	
 * EXAMPLE CODE:
 * 	<div class="blocchetto_4_foto">
	    <p>Piccola descrizione: attrazioni varie, spiaggie..</p>
	    <a href=""><img alt="" title="" src="IMMAGINI/small_Salento-Puglia_1.jpg"/></a>
	    <a href=""><img alt="" title="" src="IMMAGINI/small_Salento-Puglia_2.jpg"/></a>
	    <a href=""><img alt="" title="" src="IMMAGINI/small_Salento-Puglia_3.jpg"/></a>
	    <a href=""><img alt="" title="" src="IMMAGINI/small_Salento-Puglia_2.jpg"/></a>
	    <div class="approfondisci"><a href="">vedi altre ...</a></div>
     </div>
 */
class FourPhotos extends Isp_View_Snippet{
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $description = null;
	public $urlPicsMatrix = null; 
	public $approfondisciUrl = null; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $class4pics = 'blocchetto_4_foto'; 
	public $classApprofondisci = 'approfondisci'; 

	/**
	 * Constructor
	 *
	 * @param string $description - Descriptive text
	 * @param array $urlPicsMatrix - array(Isp_Url_Page, Isp_Url_Photo)
	 * @param Isp_Url $approfondisciUrl - page to link for further reading
	 */
	public function __construct($description, $urlPicsMatrix, $approfondisciUrl = null){
		// Store into object state
		$this->setState("description",$description);
		$this->setState("urlPicsMatrix",$urlPicsMatrix);
		$this->setState("approfondisciUrl",$approfondisciUrl);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Open blocchetto_4_foto div
		$code = $this->openTag(null,$this->class4pics);
		// Short description
		$code .= "<p>".$this->description."</p>";
		// 4 Pics	
		foreach ($this->urlPicsMatrix as $element){
			$href = new Href($element[0], null, null, $element[1]);
			$code .= $href->code;
		}
		// Approfondisci
		if(isset($this->approfondisciUrl)){
			$code .= $this->openTag(null,$this->classApprofondisci);
			$href = new Href($this->approfondisciUrl);
			$code .= $href->code;
			$code .= $this->closeTag();
		}
		$code .= $this->closeTag();
		return $code;
	}	

}
?>