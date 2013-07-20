<?php

/**
 * Controllore padre delle pagine di tipo scheda
 */
class Ctrl_Scheda extends Isp_Controller_Action_Instantiator{

	private $symbol = "underscore";
	private $symbolOriginal = "_";

	public function init($pag = null){
		// Build Lista page link
		Isp_Loader::loadClass("Isp_Url_Page");
		// Title for human reading
		if(isset($this->front->request->params['listaTitle'])){
			$title = $this->front->request->params['listaTitle'];
			$title = ucwords($title);
			// Fill the page with this info too
			$pag->paramsArray['listaTitle'] =
				$this->front->request->params['listaTitle'];
		}else{
			$title = null;
		}
		// Page name
		if(isset($this->front->request->params['listaPageName'])){
			$pageName = $this->front->request->params['listaPageName'];
			$pag->paramsArray['listaPageName'] = $this->front->request->params['listaPageName'];
		}else{ // Not defined
			$pag->listaUrl = null;
			return $pag;
		}
		// Page params
		$pageParams = array();
		foreach ($this->front->request->params as $key => $value){
			if(substr_count($key, $this->symbol)>0){
				// At least one occurence in the key
				// Fill the original first
				$pag->paramsArray[$key] = $value;
				// Convert
				$keyParam = str_replace($this->symbol,$this->symbolOriginal, $key);
				$pageParams[$keyParam] = $value;
			}
		}
		// Page description
		if(isset($this->front->request->params['listaPageDescription'])){
			$pageDescription = $this->front->request->params['listaPageDescription'];
			$pag->paramsArray['listaPageDescription'] =
										$this->front->request->params['listaPageDescription'];
		}else{ // Not defined
			$pageDescription = null;
		}

		$pag->listaUrl = new Isp_Url_Page(	$title,
											"Lista",
											$pageName,
											$pageParams,
											$pageDescription);
		//$pag->listaUrl = $listaUrl;
		//$last = array_pop($pag->breadUrls);
		array_push($pag->breadUrls, $pag->listaUrl);
		//array_push($pag->breadUrls, $last);

		return $pag;

	}

}

?>