<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina inserimento articolo
 *
 */
class FormReg extends Isp_View_Page{
	public $currentTab = 5;

	// Object State
	public $urlNext = null;
	public $registrationOk = null;
	public $nickInserted = null;

	// Dictionary
	public $dictionary = array(
			"it" =>
			 array(	"titlePage" => "REGISTRAZIONE DI UN NUOVO ACCOUNT",
						"descriptionPage" => "Tutti i campi sono obbligatori.",
						// campi
						"name" => "Nome",
						"surname" => "Cognome",
						"email" => "Email",
						"user" => "Username",
						"pw1" => "Password",
						"pw2" => "Ripeti la password",
						"nextButton" => "avanti",
						"regOk" => "A breve ti sara' inviata una email all'indirizzo da te specificato. Segui le istruzioni nella email per completare la registrazione del tuo username: ",
						"backToHome" => "Torna alla home",
						"captchaValue" => "digita qui il codice immagine"
						));

	public function skeleton(){
		// se provego da un errore reinserisco i dati validi nel form.
		$fields = array(	'nome_utente' => null,
								'cognome_utente' => null,
								'email_utente' => null,
								'username_utente' => null);

		if(isset($_SESSION['regValidFields'])){
			$fields = array_merge($fields, $_SESSION['regValidFields']);
		}

		if(!$this->registrationOk){
			// TITLE DESCRIPTION
			Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
			$this->add(new TitleDescription(	$this->txt['titlePage'],
														$this->txt['descriptionPage']));
			// Errors
			if (isset($this->errorMsg) && !is_null($this->errorMsg)) {
				$i = 0;
				foreach ($this->errorMsg as $errorString){
				$i++;
				$this->add($i.") ".$errorString);
				}
				$this->add("<br /><br />");
			}

			// Open form
			$this->add(	"<form method=\"post\" action=\""
							.$this->urlNext."\">");
			Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");

			// Nome
		 	/*$this->add(new Input(	"text",
		 									$this->txt['name'],
		 									"nome_utente",
		 									true, $fields['nome_utente'], 25));
		 	$this->add("<br /><br />");

		 	// Cognome
		 	$this->add(new Input(	"text",
		 									$this->txt['surname'],
		 									"cognome_utente",
		 									true, $fields['cognome_utente'], 25));
			$this->add("<br /><br />");*/

		 	// Email
		 	$this->add(new Input(	"text",
		 									$this->txt['email'],
		 									"email_utente",
		 									true, $fields['email_utente'], 25));
		 	$this->add("<br /><br />");

		 	// Username
		 	$this->add(new Input(	"text",
		 									$this->txt['user'],
		 									"username_utente",
		 									true, $fields['username_utente'], 25));
		 	$this->add("<br /><br />");


		 	// Password1
		 	$this->add(new Input(	"password",
		 									$this->txt['pw1'],
		 									"pw1",
		 									true, null, 25));
		 	$this->add("<br /><br />");

		 	// Password1
		 	$this->add(new Input(	"password",
		 									$this->txt['pw2'],
		 									"pw2",
		 									true, null, 25));
		 	$this->add("<br /><br />");

		 	// Captcha
		 	$this->add($this->getCaptchaCode());
		 	$this->add("<br /><br />");

			// Submit
			$this->add(new Input("submit", null, "next",
										true, $this->txt['nextButton']));
			// Close form
			$this->add(	"</form>");

			$this->add("<br /><br />");

		}else{
			// Registrazione avvenuta con successo
			$this->add($this->txt['regOk'].$this->nickInserted);
			$this->add("<br /><br />");
			// Link to home
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			$this->add(new Href(new Isp_Url_Page(	$this->txt['backToHome'],
																"Extra",
																"ExtraHome")));
		}
		return $this->useDefaultTemplate();
	}
	/**
	 * Funzione generatrice del Captcha
	 */
	private function getCaptchaCode(){
		$captchaString = "";
		$date = date_default_timezone_set('America/Los_Angeles');
		$rand = rand(0,9999999999999);
		$height = "70";
		$width  = "230";
		$img    = "$date$rand-$height-$width.jpgx";
		$captchaString .= "<input type='hidden' name='img' value='$img'>";
		$captchaString .=	"<!--<a href='http://www.opencaptcha.com'>-->"
								."<img src='http://www.opencaptcha.com/img/$img'"
								." height='$height' alt='captcha' width='$width'"
								." border='0' /></a><br />";
		$captchaString .=	"<input type=text name=code "
								."value='{$this->txt['captchaValue']}' size='25' />";
		return $captchaString;
	}
}
?>