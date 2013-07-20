<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina inserimento articolo
 *
 */
class InsertArticolo extends Isp_View_Page{
	public $privilegioMin = Permission::REGISTERED;
	public $currentTab = 6;

	public $urlForm = null; // Isp_Url object
	public $espansionsNumber = 5; // Number of default expansions
	// Page inputs
	public $ntt = null; // if it is an entity related article
	public $idNtt = null;
	public $lang =  "it"; // Default

	// Dati dinamici related
	public $listaLocalita = null;	// if it is a general article (rubriche)
	public $listaCategoria = null;

	// Dictionary
	public $dictionary = array(
				"it" =>
				 array( "titlePage" => "Inserisci articolo",
						"descriptionPage" =>"versione alpha di iSalento",
						"localita" => "Localita: ",
						"categoria" => "Categoria: ",
						"rilevanza" => "Rilevanza:  ",
						"titolo" => "Titolo:  ",
						"riassunto" => "Riassunto:  ",
						"descrizione" => "Descrizione:  ",
						"bozza" => "Bozza",
						"proponi" => "Proponi",
						"approvato" => "Approvato",
						"revisionato" => "Revisionato",
						"salva" => "salva",
						"paragrafo" => "Paragrafo ",
						"lingua" => "Lingua :",
						"it" => "IT",
						"en" => "EN",
						"es" => "ES",
						"de" => "DE",
						"speciale" => "Speciale : ",
						"locSconosciuta" => "Sconosciuta",
						),
				"en" =>
				array( "titlePage" => "Insert Article",
						"descriptionPage" =>"versione alpha di iSalento",
						"localita" => "Town: ")
								);

	public $languageSet = array("it","en","de","es");

	/**
	 * Lista di ingredienti diretti (che non dipendono da altri beans).
	 * Convenzione: l'array ingredients contiene i campi di retrieve del beaner,
	 * oppure i campi di ingresso del SimpleEnquirer.
	 * Nel secondo caso la chiave di $ingredients inizia per '*'. :D
	 * Se si vogliono prendere i dati dalla request basta specificare il nome
	 * dell'array nella request come stringa (es. 'userParams').
	 * La chiave dell'array ingredients  = al nome dell'oggetto istanziato
	 *
	 * @return l'array di ingredienti da processare nell'action ctrl
	 */
	public function getIngredients(){
		$ingredients = array();
		// if general article load the localitˆ select (we're in rubriche)
		if(!isset($this->ntt)){
			$ingredients['*listaLocalita'] = array(	"localita",
													array("nome_localita" => "ASC"));
			// For categoria select
			$ingredients['*listaCategoria'] = array("categoria",
													array("nome_categoria" => "ASC"));
		}
		return $ingredients;
	}


	public function skeleton(){
		// Imports
		Isp_Loader::loadVistaObj("Snippets", "Html", "Select");
		Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");
		Isp_Loader::loadVistaObj("Snippets", "Form", "TextArea","Crud");


		// if general article load the localitˆ select (we're in rubriche)
		if(!isset($this->ntt)){
			// Prepare options for "lista localitˆ" select
			$defaultLoc = array(false, "", null, $this->txt['locSconosciuta']);
			$optionsLoc = array($defaultLoc);
			if(isset($this->listaLocalita)){
				foreach ($this->listaLocalita as $obj) {
					array_push($optionsLoc, array(	false,
												"",
												$obj['id_localita'],
												$obj['nome_localita']));
				}
			}

			// Prepare options for "lista tipostruttura" select
			$optionsCat = array();
			foreach ($this->listaCategoria as $obj) {
				// Delete "description" category reserved only for home page cards
				if($obj['id_categoria']!=0){
					array_push($optionsCat, array(	false,
												"",
												$obj['id_categoria'],
												$obj['nome_categoria']));
				}

			}
		}


		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['titlePage']));

		// Open form
		$this->add( "<form method=\"post\" action=\"".$this->urlForm->path."\">");

		// if general article load the localitˆ select (we're in rubriche)
		if(!isset($this->ntt)){
			// Select Localita
			$this->add($this->txt['localita']);
			$this->add(new Select("id_localita", $optionsLoc));
			$this->add("<br />");
			// Select categoria
			$this->add($this->txt['categoria']);
			$this->add(new Select("id_categoria", $optionsCat));
			$this->add("<br />");

			// Rilevanza
			$this->add($this->txt['rilevanza']);
			$this->add(new Input("radio","1", "rilevanza_articolo", false,1));
			$this->add(new Input("radio","2", "rilevanza_articolo", false,2));
			$this->add(new Input("radio","3", "rilevanza_articolo", false,3));
			$this->add(new Input("radio","4", "rilevanza_articolo", false,4));
			$this->add(new Input("radio","5", "rilevanza_articolo", false,5));
			$this->add(new Input("radio","6", "rilevanza_articolo", false,6));
			$this->add(new Input("radio","7", "rilevanza_articolo", false,7));
			$this->add(new Input("radio","8", "rilevanza_articolo", false,8));
			$this->add(new Input("radio","9", "rilevanza_articolo", false,9));
			$this->add(new Input("radio","10", "rilevanza_articolo", false,10));
			$this->add( "<br />");
		}else{ // We're coming from an entity insert
			// Send id_ntt as hidden
			$dbName = "id_".$this->ntt;
			$this->add(new Input("hidden", null, $dbName, false, $this->idNtt));
			// Default category = 0 for entity articles
			//$this->add(new Input("hidden", null, "id_categoria", false, 0));
			// Default schedahome_entita_articolo for entity articles
			$this->add(new Input("hidden", null, "schedahome_entita_articolo", false, 1));
			$this->add( "<br />");
		}

		// SPECIALE PER HOME PAGE
		$this->add(new Input( "checkbox",
							   $this->txt['speciale'],
								"speciale_articolo",
								false,
								1));
		$this->add( "<br />");
		// Article expansions
		for ($i = 0; $i < $this->espansionsNumber; $i++){

			// Titolo
			if($i > 0){ // Espansioni
				$this->add("<br /><h2>".$this->txt['paragrafo']." ".($i+1)." ------------");
				$this->add("------------------------------------------------</h2>");
			}
		 	$this->add(new Input(	"text", $this->txt['titolo'],
		 							"MORE#Tea[$i][titolo_tea]",
		 							false, null, 50));
		 	$this->add( "<br />");
		 	// Riassunto (abstract)
			$this->add(new TextArea($this->txt['riassunto']."<br />",
									"MORE#Tea[$i][abstract_tea]", 70, 3));
			$this->add( "<br />");
			// Descrizione
			$this->add(new TextArea($this->txt['descrizione']."<br />",
									"MORE#Tea[$i][descrizione_tea]", 70, 10));
			$this->add( "<br />");

			// Stato
			$this->add( "Stato: ");
			$this->add(new Input(	"radio", $this->txt['bozza'],
									"MORE#Tea[$i][stato_tea]", true,"bozza"));
			$this->add(new Input("radio",$this->txt['proponi'],
								"MORE#Tea[$i][stato_tea]", true,"proponi"));
			if($this->privilegi <= 1) { // For admins only
				$this->add(new Input(	"radio",
										$this->txt['approvato'],
										"MORE#Tea[$i][stato_tea]",
										true,
										"approvato",
										null,
										null,
										null,
										array("checked"=> null)));
				$this->add(new Input("radio",$this->txt['revisionato'],
									"MORE#Tea[$i][stato_tea]", true,"rivisto"));
			}
			$this->add( "<br />");
			// Language default
			/*$this->add(new Input(	"hidden", null,
									"MORE#Tea[$i][lingua_sigla_tea]",
									false, $this->lang));*/
			// Lingua
			$this->add( $this->txt['lingua']." ");
			foreach ($this->languageSet as $lang){
				// Checked la lingua della pagina
				if($this->lang == $lang){
					$checked = array("checked" => "yes");
				}else{
					$checked = null;
				}
				$this->add(new Input(	"radio",
										$this->txt[$lang],
										"MORE#Tea[$i][lingua_sigla_tea]",
										false,
										$lang,
										null,
										null,
										null,
										$checked));
			}

		}
		$this->add( "<br /><br />");
		// Submit
		$this->add(new Input("submit", null, "nuddu", false, $this->txt['salva']));
		// Close form
		$this->add(	"</form>");

		return $this->useDefaultTemplate();
	}
}
?>