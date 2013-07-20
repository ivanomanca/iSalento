<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina inserimento struttura
 *
 */
class InsertLocalita extends Isp_View_Page{
	public $privilegioMin = Permission::REGISTERED;
	public  $currentTab = 6;

	// Dati dinamici related
	public $listaLocalita = null;

	// Dictionary
	public $dictionary = array(
				"it" =>
				 array( "titlePage" => "Inserisci una nuova localit&agrave",
						"descriptionPage" =>"versione alpha di iSalento",
						"nome" => "Nome : ",
						"costaEntroterra" => "Costa o Entroterra: ",
						"costa" => "Costa",
						"entroterra" => "Entroterra",
						"rilevanza" => "Rilevanza:  ",
						"bozza" => "Bozza",
						"proponi" => "Proponi",
						"approvato" => "Approvato",
						"revisionato" => "Revisionato",
						"salva" => "salva",
						"locInserite" => "Localit&agrave inserite"
						),
				"en" =>
				array( "titlePage" => "Insert Article",
						"descriptionPage" =>"versione alpha di iSalento",
						"localita" => "Town: ")
							);


	public function getIngredients(){
		// esempio Beaner
		//$ingredients['listaLocalita'] = array("A7Localita");

		// esempi SimpleEnquirer
		$ingredients['*listaLocalita'] = array(	"localita", array("nome_localita" => "ASC"));
		return $ingredients;
	}

	public function skeleton(){
		// Imports
		Isp_Loader::loadVistaObj("Snippets", "Html", "Select");
		Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");
		Isp_Loader::loadVistaObj("Snippets", "Form", "TextArea","Crud");

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['titlePage']));

		// Open form
	 	$this->add( "<form method=\"post\" action=".$this->urlForm->path.">");
	 	// Nome struttura
	 	$this->add(new Input("text", $this->txt['nome'], "nome_localita", false, null, 30));
	 	$this->add( "<br />");
		// Radio Giorno notte
		$this->add($this->txt['costaEntroterra']);
		$this->add(new Input("radio",$this->txt['costa'], "costa_entroterra_localita",
							true,"costa"));
		$this->add(new Input("radio",$this->txt['entroterra'], "costa_entroterra_localita",
							 true,"entroterra"));
		$this->add( "<br />");

		// Rilevanza
		$this->add($this->txt['rilevanza']);
		$this->add(new Input("radio","1", "rilevanza_localita", false,1));
		$this->add(new Input("radio","2", "rilevanza_localita", false,2));
		$this->add(new Input("radio","3", "rilevanza_localita", false,3));
		$this->add(new Input("radio","4", "rilevanza_localita", false,4));
		$this->add(new Input("radio","5", "rilevanza_localita", false,5));
		$this->add(new Input("radio","6", "rilevanza_localita", false,6));
		$this->add(new Input("radio","7", "rilevanza_localita", false,7));
		$this->add(new Input("radio","8", "rilevanza_localita", false,8));
		$this->add(new Input("radio","9", "rilevanza_localita", false,9));
		$this->add(new Input("radio","10", "rilevanza_localita", false,10));
		$this->add( "<br />");
		$this->add( "<br />");
		// Submit
		$this->add(new Input("submit", null, "nuddu", false, $this->txt['salva']));
		// Close form
		$this->add(	"</form>");

		Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
		$this->add("<h2>".$this->txt['locInserite']."</h2>");

		// Show which localita have already been inserted
		// Prepare options for "lista localitˆ" select
		if(isset($this->listaLocalita)){
			foreach ($this->listaLocalita as $obj) {
				$urlLoc = new Isp_Url_Page(ucfirst(htmlentities($obj['nome_localita'])),
											"Scheda",
											"SchedaLocalita",
											array("id_localita" => $obj['id_localita'],
												  "listaTitle" => "Localita",
												  "listaPageName" => "ListaLocalita"),
											ucfirst(htmlentities($obj['nome_localita'])));
				$this->add(new Href($urlLoc));
				$this->add( "<br />");
			}
		}

		return $this->useDefaultTemplate();
	}



}
?>
