<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * It contains title and description of the page
 *	
 * EXAMPLE CODE:
 * <h1>La prima frase usando uno snippet</h1>
 */
 
class PrimoSnippet extends Isp_View_Snippet{
	
	public $snippetType = "TrainingSnip";
	
	/**
	 * Contruttore, funzione chiamata in automatico 
	 */
	public function __construct(){
		
		// Padre
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	/**
	 * Qui va il codice html che verrˆ stampato nella pagina
	 */
	public function render(){
		
		$code = "<h1>La prima frase usando uno snippet</h1>";
		$code .= "<h2>La seconda frase usando uno snippet</h2>";
		return $code;
	}	
	
}
?>