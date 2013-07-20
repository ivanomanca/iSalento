<?php

/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Abstraction of anchor tag <a href="">
 * 
 * EXAMPLE CODE:
  	<map name="Map" id="Map">
      <area shape="rect" coords="267,75,322,102" href="../MODELLO_LISTA/modello_lista.html" />
      <area shape="rect" coords="374,166,434,200" href="../MODELLO_LISTA/modello_lista.html" />
      <area shape="rect" coords="190,216,245,240" href="../MODELLO_LISTA/modello_lista.html" />
      <area shape="rect" coords="343,335,419,383" href="../MODELLO_LISTA/modello_lista.html" />
    </map>
  	
 */

class Map extends Isp_View_Snippet{

	public $snippetType = "Html";

	/**
	 * Object state
	 */
	public $name = null;
	public $matrixCoordUrl = array();
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idMap = "Map";

		/**
	 * Abstraction of href html tag
	 *
	 * @param $name - nome da assegnare al tag
	 * @param $matrix - matrice costituita da coppie di coord e url
	 * 					(i.e. $matrix=(array("267,75,322,102",$url1),
	 * 								   array("343,335,419,383",$url2)) )
	 * 
	 * @return string of html code
	 * 
	 */
	public function __construct($name = null, 
	                            $matrix = null){
		
	    $this->setState("name", $name);
	    $this->setState("matrixCoordUrl", $matrix);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		$code = "<map name=\"".$this->name."\" id=\"".$this->idMap."\" >";
			if(isset($this->matrixCoordUrl))
			{	
				// riga[1]  un oggetto Isp_Url
				foreach ($this->matrixCoordUrl as $riga){	
					$code .= "<area shape=\"rect\" coords=\"";
					$code .= $riga[0]."\" href=\"".$riga[1]->path."\" ";
					$code .= "title=\"".$riga[1]->title."\"";
					if(isset($riga[1]->description)){
						$code .= " :: ".$riga[1]->description."\"";
					}
					$code .=  " />";
				}
			}
		$code .= $this->closeTag("map");
		
		return $code;
	}
}


?>