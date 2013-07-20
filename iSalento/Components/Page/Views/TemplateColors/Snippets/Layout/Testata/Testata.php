<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Testata contains the logo and 180¡ foto info
	 EXAMPLE CODE
	 <div id="testata">
		  <div id="logo">
			<h1> 
				<a title="iSalento" href="">
					<span>iSalento</span>
				</a>
			</h1>
		  </div>
		  <div id="image"> </div> //OPZIONALE
		</div>
 *
 */
class Testata extends Isp_View_Snippet{
	public $snippetType = "Layout";
	
	public $url = null; //Default 180¡ foto url
	public $siteTitle = "iSalento"; // Default 
	public $noImage = false;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idTestata = "testata";
	public $idLogo = "logo";
	public $idImage = "image";
	
	/**
	 * Contructor
	 *
	 * @param Isp_Url $url - image link
	 * @param string $siteTitle 
	 */
	public function __construct(Isp_Url $url = null, $siteTitle = null, $noImage = false){

		// 180¡ picture link
		if(isset($url)){ // From outside
			$this->url = $url;
		}else{ // Default
			//$this->url = new Isp_Url_Image("foto/180/");
		}
		
		// Change the default site title
		if(isset($siteTitle)){ 
			$this->siteTitle = $siteTitle;
		}
		
		$this->noImage = $noImage;
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	
	/**
	 * @todo Add 'title' and 'alt' properties in 'image' div.
	 */
	public function render(){
		// Div testata
		$code = $this->openTag($this->idTestata); 
			// Div logo
			$code .= $this->openTag($this->idLogo); 
				
			$href = new Href(new Isp_Url_Page(	"<span>".$this->siteTitle."</span>",
												"Extra",
												"ExtraHome",
												null,
												"iSalento Homepage"));
												
			$code .= "<h1>".$href->code."</h1>"; 
			$code .= $this->closeTag();	
			
			 // Div image
			if(!$this->noImage){
				$code .= $this->openTag($this->idImage, null, "div", true);
			}
			
		$code .= $this->closeTag();		
		return $code;
	}
	
	
}
?>