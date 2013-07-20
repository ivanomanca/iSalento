<?php

/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 *   Contiene la sezione dedicata alle news
 * 
          <span class="tl_corner_white"></span>
          <span class="tr_corner_white"></span>  
          <span class="bl_corner_white"></span>
          <span class="br_corner_white"></span>
       	  <div class="side"></div>
   	    <a href=""><img class="foto_news" alt="" title="" src="IMMAGINI/big_Salento-Puglia_2.jpg"/></a>

          	<div class="banner">
            	<h3><a href="">Neque porro quisquam </a></h3>
           		 <p>Sip on delish daiquiris and killer martinis in these swish Sip on delish daiquiris and killer Sip on delish daiquiris Sip on delish daiquiris...</p>
           		 <div class="approfondisci"><a href="">Approfondisci &raquo;</a></div> 
            </div>
          	

*/

class NewsHome extends Isp_View_Snippet{
	
	public $snippetType = "Home";
	
	/**
	 * Object state
	 */
	public $description;
	public $urlNews;
	public $urlNewsPhoto;
	public $stringaApprofondisci;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classTlCornerWhite  = "tl_corner_white";
	public $classTrCornerWhite  = "tr_corner_white";
	public $classBrCornerWhite  = "br_corner_white";
	public $classBlCornerWhite  = "bl_corner_white";
	public $classSide 		    = "side";
	public $classFotoNews 	    = "foto_news";
	public $classBanner         = "banner";
	public $classApprofindisci  = "approfondisci";
	
	//public $idContenutoTopRight = "contenuto_top_right";
	
	
	/**
	 * Contructor
	 *
	 * @param description - descizione della news
	 * @param urlImage - url appartenente all'immagine della news - array(Isp_Url, Isp_Url_Photo)
	 * @param urlTitle - url appartenente al titolo della news - array(Isp_Url, Isp_Url_Photo)
	 * @param urlOther - url appartenente ad approfondimenti - array(Isp_Url, Isp_Url_Photo)
	 */
	  public function __construct($text, Isp_Url $urlNews, Isp_Url_Photo $urlNewsPhoto, $more){
	    
	  	$this->setState("description", $text);
	  	$this->setState("urlNews", $urlNews);
	  	$this->setState("urlNewsPhoto", $urlNewsPhoto);
	  	$this->setState("stringaApprofondisci", $more);

	  	parent::__contruct();
		
		// Render into father's code variable
		$this->run();                             	
	  }
	
	  
	  public function render() {
	  	
	  //	$code = $this->openTag($this->idContenutoTopRight, null, "div");
	  		
	  		$code = $this->openTag(null, $this->classTlCornerWhite, "span");
	  		$code .= $this->closeTag("span");
	  		$code .= $this->openTag(null, $this->classTrCornerWhite, "span");
	  		$code .= $this->closeTag("span");
	  		$code .= $this->openTag(null, $this->classBlCornerWhite, "span");
	  		$code .= $this->closeTag("span");
	  		$code .= $this->openTag(null, $this->classBrCornerWhite, "span");
	  		$code .= $this->closeTag("span");
	  		
	  		$code .= $this->openTag(null, $this->classSide, "div");
	  		$code .= $this->closeTag("div");	  		
		  		if(isset($this->urlNews))
		  		{
		  			if(isset($this->urlNewsPhoto))
		  			{	
		  				$href = new Href($this->urlNews,null,null,$this->urlNewsPhoto,null,$this->classFotoNews);
		  				$code .= $href->code;
		  			}
		  			else 
		  			{
		  				$href = new Href($this->urlNews,null,null,null,null,$this->classFotoNews);
		  				$code .= $href->code;
		  			}
		  		}	
	  		$code .= $this->openTag(null, $this->classBanner, "div");
	  			$code .= $this->openTag(null, null, "h3");
		  			if(isset($this->urlNews))
		  			{
			  			$href = new Href($this->urlNews);
			  			$code .= $href->code;
		  			}
	  			$code .= $this->closeTag("h3");
	  			$code .= $this->openTag(null, null, "p");
	  				if(isset($this->description))
	  					$code.= $this->description;
	  			$code .= $this->closeTag("p");
	  			$code .= $this->openTag(null, $this->classApprofindisci, "div");
	  				if(isset($this->urlNews))
		  			{
		  				if(isset($this->stringaApprofondisci))
		  					$this->urlNews->title = $this->stringaApprofondisci;
		  					
			  			$href = new Href($this->urlNews);
			  			$code .= $href->code;
		  			}
	  			$code .= $this->closeTag("div");
	  		$code .= $this->closeTag("div");
	  	
	  	return $code;
	  }
}
//vedere il contenuto del href
        
?>