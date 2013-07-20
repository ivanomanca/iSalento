<?php
/**
 * Controllore specifico di pagina.
 */
class Ctrl_Form_FormLogin extends Isp_Controller_Action_Instantiator{

	public $linkLogin = "index.php?component=Authenticate&task=login";
	public $linkLogout = "index.php?component=Authenticate&task=logout";

	public function init($pag = null){
		// Manage Urls
		Isp_Loader::loadClass("Isp_Url");
		if(!isset($_SESSION['user'])){
			// If not already logged in
			$pag->urlLogin = new Isp_Url($this->linkLogin, "Login");
		}else{
			$pag->urlLogout = new Isp_Url($this->linkLogout, "Logout");
		}
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