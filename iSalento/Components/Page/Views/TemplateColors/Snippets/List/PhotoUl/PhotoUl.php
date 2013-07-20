<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets", "Html", "Href");

/**
 * PhotoGallery snippet.
 *	
 * EXAMPLE CODE:
 * 	   <ul class="galleria" oppure id="focus_home">
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
	public $photoUrlMatrix = null; 
	public $ombra = true;
	public $home = false;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classGallery = "galleria";
	public $idHome = "focus_home";
	public $classOmbra = "ombra_diagonale"; 
	public $classTitleImg = "title_img"; 
	
	
	/**
	 * Constructor
	 *
	 * @param matrix $photoUrlMatrix - it contains page and photo link. Eg.
	 * array(array($urlPage1, $urlPhoto1), array($urlPage2, $urlPhoto2))
	 * @param boolean $ombra - activate shadow effect
	 * @param boolean $home - to render pics in home page
	 */
	public function __construct($photoUrlMatrix, $ombra = true, $home = false){
		// Store into object state
		$this->setState("photoUrlMatrix", $photoUrlMatrix);
		$this->setState("ombra", $ombra);
		$this->setState("home", $home);
		
		// Scegli se visualizzare la classe galleria o l'id per la home
		if($home){
			$this->classGallery = null;
		}else{
			$this->idHome = null;
		}
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Ul gallery
		$code = $this->openTag($this->idHome, $this->classGallery, "ul");
		// Li
		foreach ($this->photoUrlMatrix as $pic){
			$code .= $this->openTag(null, null, "li");
			// Photo url
			$href = new Href($pic[0], null, null, $pic[1]);
			$code .= $href->code;
			// Ombra
			if ($this->ombra){
				$code .= $this->openTag(null, $this->classOmbra, "span", true);
			}
			// Didascalia
			if(isset($pic[1]->title)){
				$code .= "<h5 class=\"".$this->classTitleImg."\">";
					// re-render href to show title instead of <img>
					$hrefPage = new Href($pic[0]);
					$code .= $hrefPage->code;
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