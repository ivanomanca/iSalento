<?php
/**
 * Classe snippet padre per la gestione degli snippet html.
 * Verrˆ riempito in una prima fase e visualizzato in un'altra.
 *
 * @todo $snippetType manually specified can be automatically
 * retrieved from static class path operations
 */
abstract class Isp_View_Snippet{

	//public $relative = "../../../../../../";
	public $relative = "";
	public $addHtmlComment = true; // Aggiunge un commento con il nome dello snippet
	// Stabilisce il tipo di output dell'html (echo, code, file, su pdf, ecc.)
	public $outHtmlMode = "code";
	// Snippet type: manually specify the snippet type
	public $snippetType = null;
	// Nome della classe
	public $className = null;
	// Rappresenta il codice dello snippet da stampare
	public $code = null;
	// All the Css to include (Array of Isp_Url)
	public $cssList = array();
	// Section color to overwrite in children
	public $color = null;

	/**
	 * Costruttore
	 *
	 */
	public function __contruct($outHtmlMode=null){
		if(isset($outHtmlMode)){
			$this->outHtmlMode = $outHtmlMode;
		}
		// Load default css
		$this->appendCss($this->getDefaultCss($this->color));
		// Remove duplicates
		//$this->cssList = $this->arrayUnique($this->cssList);


	}

	/**
	 * Store inputs information into object state. It also
	 * stores required css if a snippet is passed.
	 *
	 * @param string $inputName - the name in the object state
	 * @param mixed var $inputValue - the actual variable
	 */
	public function setState($inputName, $inputValue){
		$this->$inputName = $inputValue;
		// Append further css required if snippet
		if($inputValue instanceof Isp_View_Snippet){
			$this->appendCss($this->$inputName->cssList);
		}
		// If the snippet is contained in an array
		if(is_array($inputValue)){
			$array = $this->$inputName; // Copy actual array
			foreach ($array as $item){
				if($item instanceof Isp_View_Snippet)
				$this->appendCss($item->cssList);
			}

		}
	}


	/**
	 * It contains the single snippet specific
	 * code to render html.
	 */
	public function render(){}

	/**
	 * Stores the code into the state
	 *
	 */
	public function run(){
		// Erase code var in case an external run() is called
		$this->code = null;
		// Print Html tag comment
		if($this->addHtmlComment){
			if($this->snippetType != "Html"){
				$tag = "\n<!--";
				$tag .= " ".$this->snippetType;
				$tag .= " - ".$this->className;
				$tag .= " -->";
				$this->code = $tag;
			}
		}
		$this->code .= $this->render();
	}

	/**
	 * Append default css if not overwritten.
	 * Overwrite to take control over default
	 * and specify further css in composite snippets.
	 *
	 * @todo make this function automate
	 */
	//public function defineCss(){}

	/**
	 * Append a Isp_Url to css list
	 *
	 * @param Isp_Url|array $cssUrl
	 */
	public function appendCss($cssUrl){
		// If file does not exist
		if(!$cssUrl){return;}
		if(is_array($cssUrl) && is_array($this->cssList)){ // Array
			foreach ($cssUrl as $url) {
				if(!in_array($url, $this->cssList)){
					array_push($this->cssList, $url);
				}
			}
			/*if(!empty($this->cssList)){
				$diff = array_diff($cssUrl, $this->cssList);
			}else{
				$diff = $cssUrl;
			}
				$this->cssList = array_merge($this->cssList, $diff);
				//$this->cssList = $this->arrayUnique($this->cssList);
			*/
		}else{ // Scalar
			if(!in_array($cssUrl, $this->cssList)){
				array_push($this->cssList, $cssUrl);
			}
		}
	}

	/**
	 * Get the default css url for the current class.
	 *
	 * @todo Make Component and template recognition automatic
	 * @return Isp_Url link or false if file does not exist
	 */
	public function getDefaultCss($color=null){

		// Get class name to build the path
		$this->className = get_class($this);
		$className = $this->className;

		// Snippet path
		$basePath = Isp_Loader::buildVistaPath("Snippets",
											$this->snippetType,
											null,
											"Page",
											"TemplateColors",
											$this->relative);
		$path = $basePath.$className."/Css/".$className.".css";
		if(file_exists($path)){
			$cssUrl = new Isp_Url($path);
			// Push color url in array
			if(isset($color)){// Upper color string for CSS convention
				$color = ucfirst($color);
				$pathColor = $basePath.$className."/Css/".$className.$color.".css";
				if(file_exists($pathColor)){
					$cssUrlColor = new Isp_Url($pathColor);
					$cssUrl = array($cssUrlColor,$cssUrl);
				}

			}
		}else{
			$cssUrl = false;
		}
		return $cssUrl;
	}


	/**
	 * Apre uno snippet generico
	 *
	 * @param string $idName se presente aggiunge il nome dell'id
	 * @param string $className come idName
	 * @param string $tag il tipo di tag da aprire (default div)
	 * @param boolean $close - true per chiudere il tag in un comando
	 */
	public function openTag($idName=null, $className=null, $tag="div", $close = false){
		$code = "<$tag";
		if(isset($idName)){
			$code .= " id=\"$idName\"";
		}
		if(isset($className)){
			$code .= " class=\"$className\"";
		}
		$code .= ">";
		// Close tag
		if($close){
			$code.= "</$tag>";
		}
		return $code;
	}
	/**
	 * Chiude uno snippet generico
	 *
	 * @param string $tag il tipo di tag da chiudere (default div)
	 */
	public function closeTag($tag="div"){
		$code = "</$tag>";
		return $code;
	}


	/**
	 * Stampa il codice di uscita su diversi supporti
	 * @param string $mode - "echo, code, file.."
	 */
	public function out($mode=null){
		// Default
		if(!isset($mode)){
			// Use internal state
			$mode = $this->outHtmlMode;
		}
		switch ($mode){
			case  "echo":
			 	echo($this->code);
			case "code":
				return $this->code;
			case "file":
				// stampa su file
			case "pdf":
				// stampa su pdf
			case "mail":
				// stampa su email..
			default:
                return null;
		}
	}

	/**
	 * Removes duplicates, even using matrix array.
	 * It serializes into byte stream representation the
	 * array in case objects are passed for comparison.
	 * Then it removes duplicates and intersect unique
	 * keys.
	 *
	 * @param array $array
	 * @return array with no duplicates
	 */
	private function arrayUnique($array) {
		//sort($array,SORT_STRING);
   		return array_intersect_key($array, array_unique(array_map('serialize', $array)));
	}

}
?>
