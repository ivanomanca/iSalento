<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Meta snippet tratta i campi meta.
 *
 */
class Meta extends Isp_View_Snippet{
	public $snippetType = "Meta";
	
	public $titolo = null; // ??? serve lo stato??
	public $keywords = null;
	public $description = null;
	
	
	/**
	 * Costrutture
	 */
	public function __construct($titolo=null,$keywords=null,$description=null){

		// Inizializza le var
		$this->titolo = $titolo;
		$this->keywords = $keywords;
		$this->description = $description;
		
		parent::__contruct();		
		
		// Render into father's code variable
		$this->run();	
	}
	
	
	public function render(){
		$code = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />";
		$code .= "<title>$this->titolo</title>";
		$code .= "<meta name=\"description\" content=\"$this->description\" />";
		$code .= "<meta name=\"keywords\" content=\"$this->keywords\" />";
		return $code;
	}
}
?>