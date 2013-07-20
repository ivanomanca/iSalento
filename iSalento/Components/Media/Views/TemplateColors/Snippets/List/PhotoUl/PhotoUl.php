<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets", "Html", "Href");

/**
 * PhotoGallery snippet.
 *	
 * EXAMPLE CODE:
 * 	   <ul class="galleria">
          <li>	
          		<a href="../MODELLO_SCHEDA/modello_scheda.html"> 
          			<img src="IMMAGINI/small_Salento-Puglia_1.jpg" alt="Alpha" title="Alpha" /> 
          		</a> 
          		<span class="ombra_diagonale"></span>
            	<h5 class="title_img"> 
            		<a href="../MODELLO_SCHEDA/modello_scheda.html">London October 2008 </a>
            	</h5>
          </li>
        </ul>
 */
 
class PhotoUl extends Isp_View_Snippet{
	public $snippetType = "List";
	
	/**
	 * Object state
	 */
	public $photoUrlArray = null; 
	public $ombra = true;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classGallery = "galleria";
	public $classOmbra = "ombra_diagonale"; 
	public $classTitleImg = "title_img"; 
	
	
	
	public function __construct($photoUrlArray, $ombra = true){
		// Store into object state
		$this->setState("photoUrlArray", $photoUrlArray);
		$this->setState("ombra", $ombra);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Ul gallery
		$code = $this->openTag(null, $this->classGallery, "ul");
		// Li
		foreach ($this->photoUrlArray as $url){
			$code .= $this->openTag(null, null, "li");
			// Photo url
			$href = new Href($url);
			$code .= $href->code;
			// Ombra
			if ($this->ombra){
				$code .= $this->openTag(null, $this->classOmbra, "span", true);
			}
			// Didascalia
			if(isset($url->title)){
				$code .= "<h5 class=\"".$this->classTitleImg."\">";
					// re-render href to show title instead of <img>
					$href->labelTitle = true;
					$href->run();
					$code .= $href->code;
				$code .= "</h5>";		
			}
			// Close list item
			$code .= $this->closeTag("li");
		}
		// Close ul
		$code .= $this->closeTag("ul");
	
		return $code;
	}	

}
?>