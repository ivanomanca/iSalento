<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * CSS snippet per gli script allegati
 *
 */
class LinkRel extends Isp_View_Snippet{
	public $snippetType = "Meta";
	
	public $cssList = null; 

	
	/**
	 * Costrutture, il Layout non  null perch
	 * altrimenti non si istanzierebbe l'oggetto stesso
	 *
	 * @param isp_url $cssMain css di template
	 * @param isp_url $cssRelatedArray array di link collegati

	 */
	public function __construct($cssList){

		// Inizializza le var
		$this->cssList = $cssList;
		
		// ! Patch, reverse order..
		//sort($this->cssList,SORT_STRING);	
		$this->cssList = array_reverse($this->cssList);	

		
		// Render into father's code variable
		$this->run();	
	}
	
	/*
	public function render(){
		$code = "<link rel=\"stylesheet\" href=\"";
		// Related css
		$code .= $this->cssMain->path ."\" type=\"text/css\"/>";
		if(isset($this->cssRelatedArray)){
			$code .= "<style type=\"text/css\">";
			foreach ($this->cssRelatedArray as $url) {
				$code .= "@import url(".$url->path."); ";
			}
			$code .= "</style>";		
		}
		return $code;	
	}
	*/
	public function render(){
		$code = null;
		foreach ($this->cssList as $url) {
			$code .= "<link rel=\"stylesheet\" href=\"";
			$code .= $url->path ."\" type=\"text/css\"/> ";
		}
		return $code;
	}		
			
}
?>