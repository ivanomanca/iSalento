<?php
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * "Snippet del form di Login".
 *
 * EXAMPLE CODE:
 */

class cLogin extends Isp_View_Snippet{
	public $snippetType = "PageElements";

	/**
	 * Object state
	 */
	public $formEnabled = true;
	public $userName = null;
	public $loginUrl = null;
	public $logoutUrl = null;
	public $welcomeMsg = null;
	public $errorMsg = null;

	public function __construct(	$formEnabled = true,
											$userName = null,
											$loginUrl = null,
											$logoutUrl = null,
											$welcomeMsg = null,
											$errorMsg = null){
		// Store into object state
		$this->setState("formEnabled",$formEnabled);
		$this->setState("userName",$userName);
		$this->setState("loginUrl",$loginUrl);
		$this->setState("logoutUrl",$logoutUrl);
		$this->setState("welcomeMsg",$welcomeMsg);
		$this->setState("errorMsg",$errorMsg);

		parent::__contruct();

		// Render into father's code variable
		$this->run();
	}

	public function render(){
		$code = null;
		if (isset($this->formEnabled) && $this->formEnabled) {
			Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");
			$code =	"<form method=\"post\" action=\"".$this->loginUrl->path."\">";

			// Username
			$inputUser =	new Input(	"text", "Username",
										"username_utente", false, null, 18);
			$code .= $inputUser->code;
			$code .= "<br />";

			// Password
			$inputPass = new Input(	"password", "Password",
										"crypted_password_utente", false, null, 18);
			$code .= $inputPass->code;

			$code .= "<br />";
			$inputRem = new Input("checkbox", "Ricordami", "rememeber", true);
			$code .= $inputRem->code;

			$code .= "<br />";

			// Submit
			$inputSub = new Input("submit", null, "nuddu", false, "login");
			$code .= $inputSub->code;

			$code .= "</form>";

			$code .= "<br />";
			// Errore
			if (!is_null($this->errorMsg)) {
				$code .= $this->errorMsg;
				$code .= "<br />";
			}

			$refRec = new Href(new Isp_Url("", "> recupera pw"));
			$code .= $refRec->code;
			$refReg = new Href(new Isp_Url("", "> registrati"));
			$code .= $refReg->code;

		}else{
			if (isset($this->welcomeMsg) && isset($this->userName)) {
				$code = $this->welcomeMsg." ".$this->userName."!";
			}
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			if (isset($this->logoutUrl)) {
				$refLogout = new Href($this->logoutUrl);
				$code .= $refLogout->code;
			}
		}

		return $code;
	}

}

?>