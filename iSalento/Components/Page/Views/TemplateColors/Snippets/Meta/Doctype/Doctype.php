<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Handle the Doctype HTML chunk.
 *
 */
class Doctype extends Isp_View_Snippet{
	public $snippetType = "Meta";	
	
	// Lingua
	public $lang = "IT";
	
	/**
	 * Costrutture
	 */
	public function __construct($lang=null){

		// Cambia la lingua del doctype
		if(isset($lang)){
			$this->lang = $lang;
		}
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	/**
	 * Codice specifico del doctype
	 */
	public function render(){
		$code = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//".
				$this->lang."\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">";
		return $code;
	}
}
?>