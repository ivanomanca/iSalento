<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Href");
Isp_Loader::loadVistaObj("Snippets","Html","Map");

/**
 * 
   <div id="contenuto_middle_left">
     <h1><span>cartina, mappa del Salento</span></h1>
     <img src="IMMAGINI/cartina_salento+italia3.png" alt="" border="0" usemap="#Map" title="" />
     <map name="Map" id="Map">
      <area shape="rect" coords="267,75,322,102" href="../MODELLO_LISTA/modello_lista.html" />
      <area shape="rect" coords="374,166,434,200" href="../MODELLO_LISTA/modello_lista.html" />
      <area shape="rect" coords="190,216,245,240" href="../MODELLO_LISTA/modello_lista.html" />
      <area shape="rect" coords="343,335,419,383" href="../MODELLO_LISTA/modello_lista.html" /></map>
   </div>   
**/

class MiddleHome extends Isp_View_Snippet{
	
	public $snippetType = "Home";
	
	/**
	 * Object state
	 */
	public $title 		 = null;
	public $urlImage 	 = null;
	public $mapAttribute = null;
	public $matrixCoordUrl = array();
	//public $coordsArray  = array();
	//public $url          = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idContenutoMiddleLeft = "contenuto_middle_left";
	public $idMap 				  = "Map";
	
	
	/**
	 * Contructor
	 *
	 * @param $title - Titolo dello snippets MiddleHome
	 * @param $urlImage - Isp_Url_Photo, url dell'immagine posizionata al centro
	 * @param $matrix - array costituito da coppie(array) di coordinate e url associati
	 */
	  public function __construct($title = null, 
	  							  Isp_Url_Photo $image = null,
	  							  $map = null,
	  							  $matrix = null){
	    
	  	$this->setState("title", $title);
	  	$this->setState("urlImage", $image);
	  	$this->setState("mapAttribute", $map);
	  	$this->setState("matrixCoordUrl", $matrix);

	  	parent::__contruct();
		
		// Render into father's code variable
		$this->run();                             	
	  }
	
	  
	  public function render() {
	  
	  	$code = $this->openTag($this->idContenutoMiddleLeft);
	  	
	  		if(isset($this->title))
		  	{
		  		$code .= $this->openTag(null, null, "h1");
		  		$code .= $this->openTag(null, null, "span");
		  			$code .= $this->title;
		  		$code .= $this->closeTag("span");
		  		$code .= $this->closeTag("h1");
	  		}
	  		
	  		if(isset($this->urlImage))
	  		{
	  			$href = new Href(null,null,null,$this->urlImage,null, null, $this->mapAttribute);	
	  			$code .= $href->code;
	  		}
	  		if(!empty($this->matrixCoordUrl))
	  		{
	  			$map = new Map("Map",$this->matrixCoordUrl);
	  			$code .= $map->code;
	  		}
	  	$code .= $this->closeTag("div");
	  	
	  	return $code;
	  }

}


       
?>