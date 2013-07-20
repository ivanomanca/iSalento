<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Scheda_SchedaStruttura extends Isp_Controller_Action_Instantiator{
							
	public function init($pag=null){
				
		$pag->linkAddExpansion = "index.php?component=Page&task=getPage&pageType=Form&page=InsertArticolo";
			
		$this->loadForwardPages();
		return $pag;

	}
	
	/**
	 * @todo standardizzare la funzione per non far sbagliare a chi programma!
	 *
	 */
	public function loadForwardPages(){
		// Forward pages instructions to merge in the request
		$nextOkPage = array("page" => "InsertArticolo",
						 	"pageType" => "Form");
						 
		$nextKoPage = array("page" => "...",
							"pageType" => "...");

		$_SESSION["nextOkPage"] = $nextOkPage;				 	
		$_SESSION["nextKoPage"] = $nextKoPage;				 	
		
	}
	

}

?>