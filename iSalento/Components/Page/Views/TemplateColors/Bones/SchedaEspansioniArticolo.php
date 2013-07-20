<?php
Isp_Loader::loadClass('Isp_View_Bones');

class SchedaEspansioniArticolo extends Isp_View_Bones {
	public $espansion;
	public $snpOut = array();
	
	/**
	 * Constructor
	 *
	 * @param bean $articolo
	 * @param Isp_Url $thisPageUrl
	 * @param string $color
	 */
	public function __construct($articolo, $thisPageUrl, $color){
		
		// ARTICLE EXPANSION
		Isp_Loader::loadVistaObj("Snippets","Card","ArticleExpansion");
		// Prima espansione
		$text = $articolo->A7Tea[0]->descrizione_tea;
		$expansion1 = new ArticleExpansion($text, null, true);
		
		$expansionArray = array($expansion1); // Prima espansione
		$teas = $articolo->A7Tea;
		unset($teas[0]); // Tolgo la prima espansione
		
		foreach($teas as $tea){
			$tea->titolo_tea = ucfirst($tea->titolo_tea);
			$urlTitle = new Isp_Url($thisPageUrl->path, $tea->titolo_tea);
			array_push($expansionArray, new ArticleExpansion($tea->descrizione_tea, 
															 $urlTitle));
		}
		// cExpansion List
		Isp_Loader::loadVistaObj("Snippets","Card","cExpansionList");
		$this->espansion = new cExpansionList( $expansionArray, $color);
		
		array_push($this->snpOut, $this->espansion);
	}
}
?>