<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Abstraction of anchor tag <a href="">
 * 
 * EXAMPLE CODE:
  	<a class="" id="" href="#prima_parte">Prima parte</a>
  	
  	or (if an image url is passed)
  	
  	<a class="" id="" href="#prima_parte">
  		<img alt="" "title="" "src="" />
  	</a>
  	
 */
 
class Href extends Isp_View_Snippet{
	public $snippetType = "Html";
	
	/**
	 * Object state
	 */
	public $url = null; 
	public $urlPhoto = null; 
	public $mapAttribute = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classA = null; // Passed from input
	public $idA = null; // Passed from input
	public $classImg = null; // Passed from input
	public $idImg = null; // Passed from input
	
	/**
	 * Abstraction of href html tag
	 *
	 * @param Isp_Url $url - a url object (usually page target)
	 * @param string $idA - an id name for css style for a tag
	 * @param string $classA - a class name for css style for a tag
	 * @param Isp_Url_Photo $urlPhoto - An image is passed too!
	 * @param string $idImg - an id name for css style for img tag
	 * @param string $classImg - a class name for css style for img tag
	 * @return string of html code
	 * 
	 * @todo REFACTORING con i tipi di ISP_URL, standardizzare
	 */
	public function __construct(Isp_Url $url = null, 
								$idA = null, 
								$classA = null,
								Isp_Url_Photo $urlPhoto = null,
								$idImg = null, 
								$classImg = null, $map = null){
									
		// Store into object state
		$this->setState("url", $url);
		$this->setState("idA", $idA);
		$this->setState("classA", $classA); 
		$this->setState("urlPhoto", $urlPhoto); 
		$this->setState("idImg", $idImg);
		$this->setState("classImg", $classImg);
		$this->setState("mapAttribute", $map);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		$code = "";
		if(isset($this->url)){
			$code .= "<a class=\"$this->classA\" ";
			if(isset($this->idA)){
				$code .= "id=\"$this->idA\" ";
			}
			$code .= "href=\"".$this->url->path."\"";
			$code .= " title=\"".$this->url->description."\"";
			$code .= ">";
		}
		// Add image tag if a Photo url is passed
		if(isset($this->urlPhoto)){
		
			$code .= "<img alt=\"".$this->urlPhoto->title."\" "; 
			// Set title to display on mouse over
			if(isset($this->urlPhoto->description) and isset($this->urlPhoto->title)){ 
				$title = $this->urlPhoto->title." :: ".$this->urlPhoto->description;
			}elseif(isset($this->urlPhoto->description)){ // Use photo url descripion
				$title = $this->urlPhoto->description;
			}elseif(isset($this->urlPhoto->title)){ // Use photo url title
				$title = $this->urlPhoto->title;
			}elseif(isset($this->url->description)){ // Use url description
				$title = $this->url->description;
			}elseif(isset($this->url->title)){ // Use url title
				$title = $this->url->title;
			}else{
				$title = null;
			}
			$code .= "title=\"".$title."\" "; 
			if(isset($this->mapAttribute)) //ottimizzarla in extraAttribute @todo!
			{
				$code .= "usemap=\"".$this->mapAttribute."\"";
			}

			if(isset($this->idImg))
				$code .= "id=\"".$this->idImg."\"";
			if(isset($this->classImg))
				$code .= "class=\"".$this->classImg."\"";
			$code .= "src=\"".$this->urlPhoto->path."\" ></img>"; 
		
		}else{ // Just a common Isp_Url
			$code .= ucfirst($this->url->title);
		}
		
		if(isset($this->url)){
			$code .= "</a>";
		}
		return $code;
	
	}	
}
?>