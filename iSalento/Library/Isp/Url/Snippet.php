<?php
/** Isp_Url Object */
require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Url.php");

/**
 * Snippet link object
 * 
 * !OBSOLETE, The Isp_Loader provide this functionality easier.
 */
class Isp_Url_Snippet extends Isp_Url{
	/**
	 * It builds up the snippet link
	 *
	 * @param string $type - the type (folder) of snippet
 	 * @param string $name 
	 * @param string $component 
	 * @param string $template - template name
	 */
	public function __construct($type=null,
								$name=null,
								$component="Page",
								$template="TemplateColors"){
									
		$this->path = $_SERVER['DOCUMENT_ROOT'].
						"Components/$component/Views/$template/Snippets/";
		
		if(isset($type)){ // Tipo di snippet
			$this->path .= "$type/";		
		}
		
		if(isset($name)){ // Nome dello snippet
			$this->path .= $name.".php";		
		}							
	}
}
?>