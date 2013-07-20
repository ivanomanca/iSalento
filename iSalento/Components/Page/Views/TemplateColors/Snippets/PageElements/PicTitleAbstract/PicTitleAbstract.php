<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Href");
/**
 * It contains foto, title and a short abstract 
 * to put in a general box (like list box, or 
 * special box) in order to preview a "scheda" page.
 *	
 * EXAMPLE CODE:
 * <div id="" class=""> // opzionale
	 * // Foto
	 * 		<div class="in_box_foto"> 
		      	<a href="<?= $page2Link->path ?>">
		      		<img alt="<?= $fotoLink->fotoAlt ?>" 
						 title="<?= $fotoLink->title ?>" 
						 src="<?= $fotoLink->path ?>"></img>
		      	</a> 
		    </div>
	    // Title
		    <h3> <a href="<?= $page2Link->path ?>"><?= $page2Link->title ?></a> </h3>
	    // Abstract
	   		 <p> $abstract </p>
	    // Read all option
	     	<div class="read_all"> 
		   		<a href="<?= $page2Link->path?>">Leggi articolo ...</a> 
		   	</div>
	</div>
 */
 
class PicTitleAbstract extends Isp_View_Snippet{
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $photoUrl = null; 
	public $titleUrl = null; 
	public $abstract = null; 
	public $readAll = null; 
	public $ombraFotoPx  = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classInput = null;	// Class for outer div
	public $idInput = null;		// Id for outer div
	public $classPhoto = "in_box_foto";
	public $classReadAll = "read_all";
	public $classOmbra = "ombra_foto_px_";
	
	/**
	 * Constructor
	 *
	 * @param Isp_Url_Photo $photoUrl
	 * @param Isp_Url $titleUrl - article's title url
	 * @param string $abstract - a short description
	 * @param Isp_Url $readAll - "leggi tutto, continua, etc" option
	 * @param int $ombraFotoPx - carica l'ombra relativa ai pixel specificati
	 * (100, 200, 600, 1200)
	 * @param string $classInput - active an outer div with specified class
	 * @param string $idInput - active an outer div with specified id
	 */
	public function __construct($photoUrl = null, 
								$titleUrl, 
								$abstract = null, 
								$readAll = null,
								$ombraFotoPx = null,
								$classInput = null,
								$idInput = null){
									
		// Store into object state
		$this->photoUrl = $photoUrl;
		$this->titleUrl = $titleUrl;
		$this->abstract = $abstract;
		$this->readAll = $readAll;
		$this->ombraFotoPx = $ombraFotoPx;
		$this->classInput = $classInput;
		$this->idInput = $idInput;
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
    	$code = "";
    	
		// Outer div, add only if is specified an id or class from input
    	if (isset($this->classInput) or isset($this->idInput)){
    		$code .= $this->openTag($this->idInput, $this->classInput);	
    	}
			// Div photo
			if(isset($this->photoUrl)){
				$classPhoto = $this->classPhoto;
				if (isset($this->ombraFotoPx)){
					$classPhoto .= " , ".$this->classOmbra.$this->ombraFotoPx;
				}
				$code .= $this->openTag(null, $classPhoto);
			    	$href = new Href($this->titleUrl, null, null, $this->photoUrl);
			    	$code .= $href->code;
		    	$code .= $this->closeTag();
			}
	    	// Div Title
	    	if(isset($this->titleUrl)){
		    	$href = new Href($this->titleUrl);
		    	$code .= "<h3>".$href->code."</h3>";
	    	}
	    	
	    	// Div Abstract
	    	$code .= "<p>".$this->abstract."</p>";
	    	
	    	// Div readAll
	    	if(isset($this->readAll)){
	    		$href = new Href($this->readAll,null,$this->classReadAll);
	    		$code .= $href->code;
	    	}
	    	
	    	if (isset($this->classInput) or isset($this->idInput)){
	    		$code .= $this->closeTag();
	    	}
    	
		return $code;
	}	
	
}
?>