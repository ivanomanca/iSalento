<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina form upload foto
 *
 */
class UploadPhoto extends Isp_View_Page{
	public $privilegioMin = Permission::REGISTERED;
	public  $currentTab = 6;

	public $urlForm = null; // Isp_Url object

	// Default photo number
	public $n = 5;
	public $lang =  "it"; // Default
	public $optionsFreq = null;

	// Page inputs
	public $ntt = null; // if entity or article related
	public $idNtt = null;
	public $idLoc = null;


	// Dictionary
	public $dictionary = array(
				"it" =>
				 array( "titlePage" => "Carica le foto",
						"descriptionPage" =>"versione alpha di iSalento",
						"locSconosciuta" => "Sconosciuta",
						"categoriaSconosciuta" => "** Non saprei! ** ",
						"titoloFoto" => "Titolo :",
						"didascalia" => "Didascalia",
						"specialFormat" => " Aggiungi formato 16:9 ",
						"cartolina" => " Cartolina ",
						"homeLocalita" => " Solo home localita ",
						"rilevanza" => "Rilevanza foto : ",
						"categoria" => "Categoria: ",
						"localita" => "Localita: ",
						"freqAggiornamento" => "Frequenza aggiornamento : ",
						"giornaliera" => "Giornaliera",
						"settimanale" => "Settimanale",
						"mensile" => "Mensile",
						"dueMesi" => "Due mesi",
						"seiMesi" => "Sei mesi",
						"annuale" => "Annuale",
						"dueAnni" => "Due anni",
						"cinqueAnni" => "Cinque anni",
						"mai" => "Mai!",
						'statoFoto' => "Stato foto : ",
						"bozza" => "Bozza",
						"proponi" => "Proponi",
						"approvato" => "Approvato",
						"revisionato" => "Revisionato",
						));

	// Dinamic data
	public $listaLocalita = null;
	public $listaCategoria = null;

	public function getIngredients(){
		$ingredients = array();
		$ingredients['*listaLocalita'] = array(	"localita",
												array("nome_localita" => "ASC"));
		// For categoria select
		$ingredients['*listaCategoria'] = array("categoria",
												array("nome_categoria" => "ASC"));

		return $ingredients;
	}

	public function skeleton(){

		// Imports
		Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");
		Isp_Loader::loadVistaObj("Snippets", "Html", "Select");
		Isp_Loader::loadVistaObj("Snippets", "Form", "TextArea","Crud");

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['titlePage']));

		// Prepare options for "lista localitˆ" select
		$defaultLoc = array(false, "", null, $this->txt['locSconosciuta']);
		$optionsLoc = array($defaultLoc);
		$selected = false;
		if(isset($this->listaLocalita)){
			foreach ($this->listaLocalita as $obj) {
				// Make passed localita as default
				if(isset($this->idLoc)){
					if($obj['id_localita'] == $this->idLoc){
						$selected = true;
					}
				}
				array_push($optionsLoc, array(	$selected,
											"",
											$obj['id_localita'],
											$obj['nome_localita']));
				// Restore flag to normal
				$selected = false;
			}
		}

		// Prepare options for "lista tipostruttura" select
		$optionsCat = array();
		foreach ($this->listaCategoria as $obj) {
			// Delete "description" category reserved only for home page cards
			if($obj['id_categoria'] != 0){
				array_push($optionsCat, array(	false,
											"",
											$obj['id_categoria'],
											$obj['nome_categoria']));
			}

		}
		// Categoria sconosciuta
		//$unknownCat = array(false, "", null, $this->txt['categoriaSconosciuta']);
		//array_push($optionsCat, $unknownCat);

		// Prepare options for Frequenza aggiornamento
		$optionsFreq = array(
							array(false, "", 1, $this->txt['giornaliera']),
							array(false, "", 7, $this->txt['settimanale']),
							array(false, "", 31, $this->txt['mensile']),
							array(false, "", 2*31, $this->txt['dueMesi']),
							array(false, "", 6*31, $this->txt['seiMesi']),
							array(false, "", 12*31, $this->txt['annuale']),
							array(true, "", 24*31, $this->txt['dueAnni']),
							array(false, "", 5*12*31, $this->txt['cinqueAnni']),
							array(false, "", 99999, $this->txt['mai']),
							);

		// FORM
		$this->add("<form method=\"post\" enctype=\"multipart/form-data\" ");
		$this->add("action=\"".$this->urlForm->path."\">");

		// Upload input files
		for ($i = 0; $i < $this->n; $i++){
			$this->add("<h2>".($i+1)." ------------------------------------------------");
			$this->add("-------------------------------------</h2>");
			// File
			$this->add(new Input("file", null, "$i", false, null, 25));
			$this->add( "<br />");

			// Titolo
			$this->add(new Input("text",
								"<b>".$this->txt['titoloFoto']."</b> ",
								"photos[$i][nome_tfv]", false, null, 30));
			$this->add( "<br />");
			// Didascalia
			$this->add(new TextArea($this->txt['didascalia']."<br>",
									"photos[$i][didascalia_tfv]", 50, 3));
			$this->add( "<br />");
			// Default data
			$this->add(new Input(	"hidden",
									null,
									"photos[$i][lingua_sigla_tfv]",
									false,
									$this->lang));


			// Select Localita
			$this->add($this->txt['localita']);
			$this->add(new Select("photos[$i][id_localita]", $optionsLoc));
			$this->add("<br>");

			// We're coming from an entity/article insert
			if(isset($this->ntt)){
				// Send id_ntt as hidden
				$dbName = "id_".$this->ntt;
				$this->add(new Input(	"hidden", null,
										"photos[$i][$dbName]", false, $this->idNtt));

				// Send article's or entity's id_location too
				//$dbLoc = "id_".$this->loc;
				//$this->add(new Input("hidden", null, "photos[$i][$dbLoc]",
				//						false, $this->idLoc));

				// In case of localitˆ home page
				if($this->ntt == "localita"){
					$this->add(new Input(	"hidden", null,
											"photos[$i][home_localita_fotovideo]",
											 false, 1));
				}
			}

			// Select categoria
			$this->add( $this->txt['categoria']);
			$this->add(new Select("photos[$i][id_categoria]", $optionsCat));
			$this->add("<br>");
			// Select frequenza aggiornamento
			$this->add( $this->txt['freqAggiornamento']);
			$this->add(new Select("photos[$i][frequenza_aggiornamento_fotovideo]", $optionsFreq));
			$this->add("<br>");


			// RILEVANZA
			$this->add($this->txt['rilevanza']);
			$this->add(new Input("radio","1", "photos[$i][rilevanza_fotovideo]", false,1));
			$this->add(new Input("radio","2", "photos[$i][rilevanza_fotovideo]", false,2));
			$this->add(new Input("radio","3", "photos[$i][rilevanza_fotovideo]", false,3));
			$this->add(new Input("radio","4", "photos[$i][rilevanza_fotovideo]", false,4));
			$this->add(new Input("radio","5", "photos[$i][rilevanza_fotovideo]", false,5));
			$this->add(new Input("radio","6", "photos[$i][rilevanza_fotovideo]", false,6));
			$this->add(new Input("radio","7", "photos[$i][rilevanza_fotovideo]", false,7));
			$this->add(new Input("radio","8", "photos[$i][rilevanza_fotovideo]", false,8));
			$this->add(new Input("radio","9", "photos[$i][rilevanza_fotovideo]", false,9));
			$this->add(new Input("radio","10", "photos[$i][rilevanza_fotovideo]", false,10));
			$this->add( "<br>");

			// CHECK BOX
			// Marker
			$this->add(	new Input(	"checkbox",
									$this->txt['cartolina'],
									"photos[$i][marker_fotovideo]",
									true,
									"cartolina"));
			$this->add("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
			// Aggiungi formato speciale per home
			$this->add(new Input(	"checkbox", $this->txt['specialFormat'],
									"photos[$i][formato_speciale_fotovideo]", true, 1 ));
			$this->add("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");

			// Appartiene alla home di una localita?
			if(!isset($this->ntt) || $this->ntt != "localita"){
				// General case
				$this->add(new Input(	"checkbox", $this->txt['homeLocalita'],
										"photos[$i][home_localita_fotovideo]", true, 1));
			}
			$this->add( "<br />");

			// STATO
			$this->add($this->txt['statoFoto']);
				$this->add(new Input(	"radio",
										$this->txt['bozza'],
										"photos[$i][stato_fotovideo]",
										false,
										"bozza"));
				$this->add(new Input(	"radio",
										$this->txt['proponi'],
										"photos[$i][stato_fotovideo]",
										false,
										"proponi"
										));
			if($this->privilegi <= 1) {
				$this->add(new Input(	"radio",
										$this->txt['approvato'],
										"photos[$i][stato_fotovideo]",
										false,
										"approvato",
										null,
										null,
										null,
										array("checked" => null)));
				$this->add(new Input(	"radio",
										$this->txt['revisionato'],
										"photos[$i][stato_fotovideo]",
										false,
										"rivisto"));

			}

		 	$this->add("<br><br><br>");


		}

		// submit di upload
		$this->add(new Input("submit", null, "salva", false, "upload"));
		// Close form
		$this->add("</form>");

		return $this->useDefaultTemplate();
	}


}
?>
