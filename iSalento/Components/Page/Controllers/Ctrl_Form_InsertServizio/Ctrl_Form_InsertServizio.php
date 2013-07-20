<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Form_InsertServizio extends Isp_Controller_Action_Instantiator{
	public $linkForm = "index.php?component=Crud&task=insert&crudNtt=Servizio";
							
	public function init($pag=null){
		// Manage Urls
		Isp_Loader::loadClass("Isp_Url");
		$pag->urlForm = new Isp_Url($this->linkForm);
		
		$this->loadForwardPages();
		return $pag;

	}
	
	/**
	 * @todo standardizzare la funzione per non far sbagliare a chi programma!
	 *
	 */
	public function loadForwardPages(){
		// Forward pages instructions to merge in the request
		$nextOkPage = array("page" => "InsertServizio",
						 	"pageType" => "Form");
						 
		$nextKoPage = array("page" => "...",
							"pageType" => "...");

		$_SESSION["nextOkPage"] = $nextOkPage;				 	
		$_SESSION["nextKoPage"] = $nextKoPage;				 	
		
	}
	

}

?>