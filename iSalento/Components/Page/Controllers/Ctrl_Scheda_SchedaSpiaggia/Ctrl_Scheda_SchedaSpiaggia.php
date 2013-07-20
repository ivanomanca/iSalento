<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Scheda_SchedaSpiaggia extends Isp_Controller_Action_Instantiator{
						
	public $linkDelete = "index.php?component=Crud&task=delete&crudNtt=Struttura&0="; 
	
	public function init($pag=null){
				
		// Manage Urls
		Isp_Loader::loadClass("Isp_Url");

		$this->linkDelete.=$pag->paramsArray['id_struttura'];
		$pag->linkDeleteSpiaggia = $this->linkDelete;
			
		$this->loadForwardPages();
		return $pag;

	}
	
	/**
	 * @todo standardizzare la funzione per non far sbagliare a chi programma!
	 *
	 */
	public function loadForwardPages(){
		// Forward pages instructions to merge in the request
		$nextOkPage = array("page" => "FiltroInserisci",
						 	"pageType" => "Filtro");
						 
		$nextKoPage = array("page" => "...",
							"pageType" => "...");

		$_SESSION["nextOkPage"] = $nextOkPage;				 	
		$_SESSION["nextKoPage"] = $nextKoPage;				 	
		
	}
	

}

?>