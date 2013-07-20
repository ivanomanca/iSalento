<?php
/**
 * Controllore specifico di pagina.
 */
class Ctrl_Form_FormReg extends Isp_Controller_Action_Instantiator{

	public $urlNext = "index.php?component=Authenticate&task=register";

	public function init($pag = null){
		// Iserisco il link per la registrazione
		$pag->urlNext = $this->urlNext;
		// Se provengo da una registrazione avvenuta
		if(
		isset($this->front->request->params['ntt']) &&
		isset($this->front->request->params['idNtt']) &&
		$this->front->request->params['ntt'] == 'Utente'){
			$pag->registrationOk = true;
			$pag->nickInserted = $this->front->request->params['idNtt'];
		}else $pag->registrationOk = false;
		// ritorno la pagina
		return $pag;
	}

	/**
	 * @todo standardizzare la funzione per non far sbagliare a chi programma!
	 *
	 *
	public function loadForwardPages(){

		$nextOkPage = array("page" => "FormLogin",
						 	"pageType" => "Form");

		$nextKoPage = array("page" => "...",
							"pageType" => "...");

		$_SESSION["nextOkPage"] = $nextOkPage;
		$_SESSION["nextKoPage"] = $nextKoPage;


	}
	*/
}

?>