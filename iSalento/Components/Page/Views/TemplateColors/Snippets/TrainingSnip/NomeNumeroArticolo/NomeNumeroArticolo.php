<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Snippet prodotto/articolo che contiene il numero ed il nome dell'articolo
 *	
 * EXAMPLE CODE:
 * <div class="articolo">
		<div class="n_articolo">
			<a href="">art. 100</a>
		</div>
		<div class="nome_articolo">
			<a href="">Mezzapunta</a>
		</div>
	</div>
 */
 
class NomeNumeroArticolo extends Isp_View_Snippet{
	
	public $snippetType = "TrainingSnip";
	
	
	/**
	*Object state
	*/
	public $Narticolo = null;
	public $Nomearticolo = null;
	
	/**
	* Markup tags names (ids & classes names)
	*/
	public $classarticolo = "articolo";
	public $classNarticolo = "n_articolo";
	public $classNomearticolo = "nome_articolo";

	public function __construct($Narticolo, $Nomearticolo = null){

		//Store into object state
		$this->setState("Narticolo", $Narticolo);
		$this->setState("Nomearticolo", $Nomearticolo);
		
	// Padre
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	
	
	/**
	 * Qui va il codice html che verrˆ stampato nella pagina
	 */
	 
	 public function render(){
	 
	 /*$code ="<div class=\"$this->classarticolo\">"; altro modo per scrivere la riga di sotto*/
	 $code ="<div class=\"".$this->classarticolo."\">";
		//Div numero articolo
		$code .= $this->openTag(null,$this->classNarticolo);
		$code .= "<a>".$this->Narticolo."</a>";
		$code .=$this->closeTag();
		
		//Div nome articolo
		$code .= $this->openTag(null,$this->classNomearticolo);
		$code .= "<a>".$this->Nomearticolo."</a>";
		$code .=$this->closeTag();
	$code .= "</div>";
		
		return $code;

	}
	
}
?>