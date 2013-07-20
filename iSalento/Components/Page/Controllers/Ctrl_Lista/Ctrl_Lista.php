<?php

/**
 * Controllore padre delle pagine di tipo scheda
 */
class Ctrl_Lista extends Isp_Controller_Action_Instantiator{

	private $symbol = "underscore";
	private $symbolOriginal = "_";

	public function init($pag = null){

		// Ricava l'ultimo url del breadcrumb se definito
		if(!is_null($pag->setThisPageUrl())){
			$currentUrl = $pag->setThisPageUrl();
		}else{
			$currentUrl = $pag->thisPageUrl; // Default
		}

		// CONVERTO I PARAMETRI
		$convertedParams = array();
		if(isset($currentUrl->paramsArray)){
			foreach ($currentUrl->paramsArray as $key => $value){
				// Copy only params which contain "_" in the key

				if(substr_count($key, "_")>0){// At least one occurence in the key
					$keyParam = str_replace($this->symbolOriginal,$this->symbol, $key);
					$convertedParams[$keyParam] = $value;
				}
			}
		}

		$params2Card = array("listaTitle" => $currentUrl->title,
									"listaPageName" => $currentUrl->page,
									"listaPageDescription" => $currentUrl->description) +
									$convertedParams;

		//$pag->convertedParams = $convertedParams;
		$pag->comingPageInfo = $params2Card;

		return $pag;
	}

}

?>