<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets", "Html", "Href");

/**
 * PhotoCard snippet.
 *	
 * EXAMPLE CODE:
 * 	  <div id="photo_container">
       	<img src="IMMAGINI/torre.jpg" alt="" title=""/>
        <p>Torre Uluzzo</p>
      </div>
 */
 
class PhotoCard extends Isp_View_Snippet{
	public $snippetType = "Card";
	
	/**
	 * Object state
	 */
	public $photoUrl = null; 
	public $photoTitle = null;
	public $photoDescription = null;
	
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idContainer = "photo_container";
	
	/**
	 * Constructor
	 *
	 * @param Isp_Url_Photo $photoUrl - main photo link
	 * @param string $photoTitle
	 * @param string $photoDescription
	 */
	
	public function __construct(Isp_Url_Photo $photoUrl, 
								$photoTitle = null, 
								$photoDescription = null){
									
		// Store into object state
		$this->setState("photoUrl", $photoUrl);
		$this->setState("photoTitle", $photoTitle);
		$this->setState("photoDescription", $photoDescription);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		$code = $this->openTag($this->idContainer);
		// Image
		$picHref = new Href($this->photoUrl, null, null, $this->photoUrl);
		$code .= $picHref->code;
		// Text
		$code .= "<p>".$this->photoTitle."</p>";
		$code .= $this->closeTag();
		
		return $code;
	}	

}
?>