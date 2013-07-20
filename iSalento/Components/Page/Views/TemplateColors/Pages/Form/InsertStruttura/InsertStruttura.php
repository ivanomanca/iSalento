<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina inserimento struttura
 *
 */
class InsertStruttura extends Isp_View_Page{
	public $privilegioMin = Permission::REGISTERED;
	public  $currentTab = 6;

	public $urlForm = null; // Isp_Url object

	// Dati dinamici related
	public $listaLocalita = null;
	public $listaTipoStruttura = null;
	public $listaServizio = null;

	// Dictionary
	public $dictionary = array(
				"it" =>
				 array( "titlePage" => "Inserisci una nuova struttura",
						"descriptionPage" =>"versione alpha di iSalento",
						"nome" => "Nome : ",
						"apertura" => "Apertura : ",
						"giorno" => "Giorno",
						"notte" => "Notte",
						"sempre" => "Sempre",
						"bozza" => "Bozza",
						"proponi" => "Proponi",
						"approvato" => "Approvato",
						"revisionato" => "Revisionato",
						"salva" => "salva",
						"indirizzo" => "Indirizzo/Zona : ",
						"stagione" => "Stagione : ",
						"estiva" => "Estiva",
						"invernale" => "Invernale",
						"annuale" => "Annuale",
						"localita" => "Localit&agrave : ",
						"tipoStruttura" => "Tipo struttura : ",
						"statoStruttura" => "Stato struttura : ",
						"sito" => "Sito web : ",
						"note" => "Note ",
						"serviziHeader" => "SERVIZI",
						"locSconosciuta" => "Sconosciuta"
						));

	/**
	 * Lista di ingredienti diretti (che non dipendono da altri beans).
	 * Convenzione: l'array ingredients contiene i campi di retrieve del beaner,
	 * oppure i campi di ingresso del SimpleEnquirer.
	 * Nel secondo caso la chiave di $ingredients inizia per '*'. :D
	 * Se si vogliono prendere i dati dalla request basta specificare il nome
	 * dell'array nella request come stringa (es. 'userParams').
	 * La chiave dell'array ingredients � = al nome dell'oggetto istanziato
	 *
	 * @return l'array di ingredienti da processare nell'action ctrl
	 */
	public function getIngredients(){
		// Oggetto
		$ingredients['listaServizio'] = array( "A7Servizio",
												array("order_cre" => "id_categoria"));

		// SimpleEnquirer
		$ingredients['*listaLocalita'] = array(	"localita", array("nome_localita" => "ASC"));
		$ingredients['*listaTipoStruttura'] = array("tipostruttura",
													array("nome_tipostruttura" => "ASC"));

		return $ingredients;
	}

	/**
	 * !CONVENTION: No html o parole o cose statiche!!
	 * Tutto nello stato dell'oggetto.
	 *
	 * @return unknown
	 */
	public function skeleton(){
		// Imports
		Isp_Loader::loadVistaObj("Snippets", "Html", "Select");
		Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");
		Isp_Loader::loadVistaObj("Snippets", "Form", "TextArea","Crud");

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['titlePage']));

		// Prepare options for "lista localit�" select
		$defaultLoc = array(false, "", null, $this->txt['locSconosciuta']);
		$optionsLoc = array($defaultLoc);
		if(isset($this->listaLocalita)){ // Se sono presenti localita
			foreach ($this->listaLocalita as $obj) {
				array_push($optionsLoc, array(	false,
											"",
											$obj['id_localita'],
											$obj['nome_localita']));
			}
		}

		// Prepare options for "lista tipostruttura" select
		$optionsTipo = array();
		foreach ($this->listaTipoStruttura as $obj) {
			array_push($optionsTipo, array(	false,
										"",
										$obj['id_tipostruttura'],
										ucfirst($obj['nome_tipostruttura'])));
		}

		// Open form
	 	$this->add( "<form method=\"post\" action=".$this->urlForm->path.">");
	 	// Select tipoStruttura
		$this->add($this->txt['tipoStruttura']);
		$this->add(new Select("id_tipostruttura", $optionsTipo));
		$this->add( "<br>");
	 	// Nome struttura
	 	$this->add(new Input("text", $this->txt['nome'], "nome_struttura", false, null, 30));
	 	$this->add( "<br>");
		// Radio Stagione
		$this->add($this->txt['stagione']);
		$this->add(new Input(	"radio", $this->txt['estiva'],
								"estivo_invernale_struttura", false,"estiva"));
		$this->add(new Input(	"radio", $this->txt['invernale'],
								"estivo_invernale_struttura", false,"invernale"));
		$this->add(new Input(	"radio", $this->txt['annuale'],
								"estivo_invernale_struttura", false,"annuale"));
		$this->add( "<br>");
	 	// Radio Giorno notte
		$this->add($this->txt['apertura']);
		$this->add(new Input(	"radio",$this->txt['giorno'],
								"giorno_notte_struttura", false,"giorno"));
		$this->add(new Input(	"radio",$this->txt['notte'],
								"giorno_notte_struttura", false,"notte"));
		$this->add(new Input(	"radio",$this->txt['sempre'],
								"giorno_notte_struttura", false,"sempre"));
		$this->add( "<br>");
		// Select Localita
		$this->add($this->txt['localita']);
		$this->add(new Select("id_localita", $optionsLoc));
		$this->add( "<br>");
		// Indirizzo o zona
		$this->add(new Input(	"text", $this->txt['indirizzo'],
								"indirizzo_zona_struttura", false, null, 45));
		$this->add( "<br>");
		// Sito web
		$this->add(new Input("text",$this->txt['sito'],"sito_struttura",false,null,50));
		$this->add( "<br>");

		// Checkbox servizi
		$this->add("<br /><b> ---------".$this->txt['serviziHeader']." ---------</b><br />");
		$currentCategory = null;
		foreach ($this->listaServizio as $key => $servizio){
			// Mostra la label categoria
			if($servizio->nome_categoria != $currentCategory){
				$currentCategory = $servizio->nome_categoria;
				$this->add("<b><br />".ucfirst($currentCategory)."</b> <br />");
			}
			$this->add(new Input(	"checkbox",
									ucfirst($servizio->nome_servizio),
									"id_servizio[$key]",
									true,
									$servizio->id_servizio));
			$this->add("<br />");
		}
		// Note
		$this->add( "<br />");
		$this->add(new TextArea($this->txt['note']."<br>","note_struttura", 70, 5 ));
		// Stato struttura
		$this->add( "<br />");
		if($this->privilegi <= 1) {
			$this->add($this->txt['statoStruttura']);
			$this->add(new Input(	"radio", $this->txt['bozza'],
									"stato_struttura", false,"bozza"));
			$this->add(new Input(	"radio",$this->txt['proponi'],
									"stato_struttura", false,"proponi"));
			$this->add(new Input(	"radio",$this->txt['approvato'],
									"stato_struttura", false,"approvato"));
			$this->add(new Input(	"radio",$this->txt['revisionato'],
									"stato_struttura", false,"rivisto"));
			$this->add( "<br />");
		}
		// Submit
		$this->add( "<br />");
		$this->add(new Input("submit", null, "nuddu", false, $this->txt['salva']));
		// Close form
		$this->add(	"</form>");

		return $this->useDefaultTemplate();
	}



}
?>
