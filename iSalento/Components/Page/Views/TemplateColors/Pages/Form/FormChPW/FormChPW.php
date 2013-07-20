<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina cambio password
 *
 */
class FormChPW extends Isp_View_Page{
	public $currentTab = 5;

	// Object State
	public $urlNext = null;
	public $changePwOk = null;

	// Dictionary
	public $dictionary = array(
			"it" =>
			 array(	"titlePage" => "CAMBIO DELLA PASSWORD",
						"descriptionPage" => "Tutti i campi sono obbligatori.",
						// campi
						"pw" => "Vecchia Password",
						"pw1" => "Nuova Password",
						"pw2" => "Ripeti la nuova Password",
						"nextButton" => "avanti",
						"chOk" => "La tua password e' stata cambiata!",
						"backToHome" => "Torna alla home",
						));

	public function skeleton(){

		if(!$this->changePwOk){
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

		 	// Vecchia password
		 	$this->add(new Input(	"password",
		 									$this->txt['pw'],
		 									"pw",
		 									true, null, 25));
		 	$this->add("<br /><br />");

		 	// Password1
		 	$this->add(new Input(	"password",
		 									$this->txt['pw1'],
		 									"pw1",
		 									true, null, 25));
		 	$this->add("<br /><br />");

		 	// Password2
		 	$this->add(new Input(	"password",
		 									$this->txt['pw2'],
		 									"pw2",
		 									true, null, 25));
		 	$this->add("<br /><br />");

			// Submit
			$this->add(new Input("submit", null, "next",
										true, $this->txt['nextButton']));
			// Close form
			$this->add(	"</form>");
			$this->add("<br /><br />");

		}else{
			// Cambio password avvenuto con successo
			$this->add($this->txt['chOk']);
			$this->add("<br /><br />");
			// Link to home
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			$this->add(new Href(new Isp_Url_Page(	$this->txt['backToHome'],
																"Extra",
																"ExtraHome")));
		}
		return $this->useDefaultTemplate();
	}
}
?>