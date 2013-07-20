<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * "Contenitore blocchetto": case block standard box.
 *	
 * EXAMPLE CODE:
 * 	<div class="contenitore_blocchetto">
      <div class="titolo_speciale, intestazione_colore">
          <h2>TITOLO</h2>
      </div>
      <div class="corpo_blocchetto">
      	Any snippet or string here!
      	
      	<div class= "approfondisci approfondisci_color"> <a href=""> Approfondisci </a> // opzionale
      </div>
    </div>
 */
 
class cCaseBlockHome extends Isp_View_Snippet{
	public $snippetType = "Home";
	
	/**
	 * Object state
	 */
	public $titleHeader = null; 
	public $inBoxItems = null;
	public $approfondisciUrl = null;
	public $color = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classCase = 'contenitore_blocchetto_home'; 
	public $classTitolo = 'titolo_speciale'; 
	public $classColor = 'intestazione_'; 
	public $classBody = 'corpo_blocchetto'; 
	public $classApprofondisci = 'approfondisci';
	public $classApprofondisciColor = 'approfondisci_';
	
	/**
	 * Constructor
	 *
	 * @param string $titleHeader - title to put on header
	 * @param string|Isp_View_Snippet $inBoxItems - snippet 
	 * or string to insert in the box
	 * @param string $color - Section color
	 * @param Isp_Url $approfondisciUrl -  a url to a page
	 */
	public function __construct($titleHeader=null, 
								$inBoxItems=null,
								$color=null,  
								Isp_Url $approfondisciUrl = null){
		// Store into object state
		$this->setState("titleHeader",$titleHeader);
		$this->setState("inBoxItems",$inBoxItems);
		$this->setState("approfondisciUrl", $approfondisciUrl);
		$this->setState("color", $color);
		if(isset($color)){
			$this->classColor = $this->classColor.$color;
			$this->classApprofondisciColor = $this->classApprofondisciColor.$color;
		}
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Div contenitore blocchetto
		$code = $this->openTag(null,$this->classCase);
			// Div titolo
			$code .= $this->openTag(null,$this->classTitolo." , ".$this->classColor);
				$code .= "<h2>".$this->titleHeader."</h2>";
			$code .= $this->closeTag();
			// Div corpo blocchetto
			$code .= $this->openTag(null,$this->classBody);
				// Any code inside
				if($this->inBoxItems instanceof Isp_View_Snippet){
					$code .= $this->inBoxItems->code;
				}else{// String
					$code .= $this->inBoxItems;
				}	
				
				// APPROFONDISCI
				if(isset($this->approfondisciUrl)){
					$code .= $this->openTag(null, $this->classApprofondisci." ".
													$this->classApprofondisciColor);
						$href = new Href($this->approfondisciUrl);
						$code .= $href->code;
					$code .= $this->closeTag();
				}
				
			$code .= $this->closeTag(); // Corpo blocchetto
		$code .= $this->closeTag(); // Contenitore blocchetto
			
		return $code;
	}	

}
?>