<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * "Contenitore blocchetto": case block standard box.
 *	
 * EXAMPLE CODE:
 * 	<div class="contenitore_blocchetto">
      <div class="intestazione_blocchetto, colore "> (or id="titolo_speciale")
        <div class="cerca">
          <h2>CERCA</h2>
        </div>
      </div>
      <div class="corpo_blocchetto">
      	Any snippet or string here!
      </div>
    </div>
 */
 
class cCaseBlock extends Isp_View_Snippet{
	public $snippetType = "Boxes";
	
	/**
	 * Object state
	 */
	public $titleHeader = null; 
	public $inBoxItems = null;
	public $color = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classHeaderInput = null; // Passed from input
	public $classCase = 'contenitore_blocchetto'; 
	public $classHeader = 'intestazione_blocchetto'; 
	public $classBody = 'corpo_blocchetto'; 
	
	/**
	 * Constructor
	 *
	 * @param string $titleHeader - title to put on header
	 * @param string $classHeaderInput - class name for inside header element
	 * @param string|Isp_View_Snippet $inBoxItems - snippet or string to insert in 
	 * the box
	 * @param string $color - Section color
	 */
	public function __construct($titleHeader=null, 
								$classHeaderInput=null, 
								$inBoxItems=null,
								$color=null){
		// Store into object state
		$this->setState("titleHeader",$titleHeader);
		$this->setState("classHeaderInput",$classHeaderInput);
		$this->setState("inBoxItems",$inBoxItems);
		$this->setState("color",$color);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Div contenitore blocchetto
		$code = $this->openTag(null,$this->classCase);
			// Div intestazione
			$code .= $this->openTag(null,$this->classHeader);
				// Div personalized containing title
				if(isset($this->color)){
					$classInput = null;
					if(isset($this->classHeaderInput)){
						$classInput = $this->classHeaderInput." , ";
					}
					$classInput .= $this->color;
				}else{
					$classInput = $this->classHeaderInput;
				}
				$code .= $this->openTag(null,$classInput);
					$code .= "<h2>".$this->titleHeader."</h2>";
				$code .= $this->closeTag();
			$code .= $this->closeTag();
			// Div corpo blocchetto
			$code .= $this->openTag(null,$this->classBody);
				// Any code inside
				if($this->inBoxItems instanceof Isp_View_Snippet){
					$code .= $this->inBoxItems->code;
				}else{// String
					$code .= $this->inBoxItems;
				}	
			$code .= $this->closeTag();
		$code .= $this->closeTag();
			
		return $code;
	}	

}
?>