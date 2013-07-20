<?php
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Login page
 *
 */
class FormLogin extends Isp_View_Page{
	public $currentTab = 5; 

	// Object State
	public $urlLogin = null; // Isp_Url object
	public $urlLogout = null; // Isp_Url object

	// Dictionary
	public $dictionary = array(
		"it" =>
		 array(	"titlePage" => "LOGIN",
					"descriptionPage" => "Inserisci le tue credenziali per l'accesso",
					"loginButton" => "Accedi",
					"ciao" => "Sei attualmente loggato su iSalento come: ",
					"user" => "Username",
					"pw" => "Password"
					));

	public function skeleton(){
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription(	$this->txt['titlePage'],
													$this->txt['descriptionPage']));

		// If user is logged show the logout form
		if(isset($_SESSION['user'])){
			$this->add(	$this->txt['ciao']." ".
							$_SESSION['user']->username_utente);
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");

			$this->add("<br /><br />");
			// aggiungo il link per il logout
			$this->add(new Href($this->urlLogout));

		}else{ // login form

			// Open form
			$this->add(	"<form method=\"post\" action=\""
							.$this->urlLogin->path."\">");

			// Username
			Isp_Loader::loadVistaObj("Snippets", "Form", "Input", "Crud");
		 	$this->add(new Input(	"text",
		 									$this->txt['user'],
		 									"username_utente",
		 									true, null, 25));
		 	$this->add("<br />");

		 	// Password
		 	$this->add(new Input(	"password",
		 									$this->txt['pw'],
		 									"crypted_password_utente",
		 									true, null, 25));
		 	$this->add("<br /><br />");

			// Submit
			$this->add(new Input("submit", null, "nuddu",
										false, $this->txt['loginButton']));
			// Close form
			$this->add(	"</form>");

			$this->add("<br />");

			// Errors
			if (isset($this->errorMsg) && !is_null($this->errorMsg)) {
				$this->add($this->errorMsg[0]);
			}

			// Link to registration
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			$this->add(new Href(new Isp_Url_Page(">registrati", "Form", "FormReg")));

		}
		return $this->useDefaultTemplate();
	}
}
?>