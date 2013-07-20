<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 * It displays espanzione articolo which is a piece of article
 *	
 * EXAMPLE CODE:
 *	<h3><a name="Prima_parte">Titolo</a></h3>
 * 	<p><span id="cap">N</span>egli ultimi anni il comparto moda...
 *	</p>      
 */
class ArticleExpansion extends Isp_View_Snippet{
	public $snippetType = "Card";
	
	/**
	 * Object state
	 */
	public $text = null;
	public $titleUrl = null; 
	public $capitalize = null; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idCap = 'cap';
	
	/**
	 * Constructor
	 *
	 * @param string $text - testo da visualizzare
	 * @param Isp_Url $titleUrl - Url di riferimento per l'ancora
	 * @param boolean $capitalize - true = prima lettera del testo maiuscola
	 */
	public function __construct($text, $titleUrl = null, $capitalize = false){
		// Store into object state
		$this->setState("text",$text);
		$this->setState("titleUrl",$titleUrl);
		$this->setState("capitalize",$capitalize);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		$code = "";
		if(isset($this->titleUrl)){
			$href = new Href($this->titleUrl);
			$code = "<h3>".$href->code."</h3>";
		}
		
		$code .= "<p>";
		if($this->capitalize){
			// estraggo la prima lettera del testo
			$first = $this->text[0];
			
			$code .= "<span id=\"".$this->idCap."\">".$first."</span>";
			$this->text = ltrim($this->text,$first);
		}
		
		// Short description
		$code .= $this->text."</p>";
		return $code;
	}	

}
?>