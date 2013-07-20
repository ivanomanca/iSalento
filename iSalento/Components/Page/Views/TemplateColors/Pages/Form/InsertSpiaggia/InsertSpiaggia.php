<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina inserimento spiaggia
 *
 */
class InsertSpiaggia extends Isp_View_Page{
	public $privilegioMin = Permission::REGISTERED;
	public  $currentTab = 6;

	public $urlForm = null; // Isp_Url object


	//stato dell'oggetto
	public $range_relax_spiaggia = 5;
	public $range_affollamento_spiaggia = 5;
	public $range_voto_traspubblico_spiaggia = 10;
	public $range_sicurezza_spiaggia = 5;
	public $range_percent_libera_spiaggia =10;
	public $range_voto_particolarita_spiaggia = 10;
	public $range_pulizia_acqua_spiaggia = 5;
	public $range_pulizia_sabbia_spiaggia = 5;
	public $range_facilita_parcheggio_spiaggia = 5;
	public $range_voto_accessibilita_spiaggia = 10;

	// Dati dinamici related
	public $listaLocalita = null;
	public $listaTipoStruttura = null;
	public $listaServizio = null;
	public $listaTipoSuolo = null;

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

						//Scheda expand spiaggia
						"titleExpand" => "Inserisci scheda tecnica spiaggia",
						"chiara" => "Chiara",
						"scura" => "Scura",
						"roccia" => "Roccia",
						"sabbia" => "Sabbia",
						"misto" => "Misto",
						"pulizia_acqua_spiaggia" => "Pulizia dell'acqua : ",
						"valore0" => "0",
						"valore1" => "1",
						"valore2" => "2",
						"valore3" => "3",
						"valore4" => "4",
						"valore5" => "5",
						"valore6" => "6",
						"valore7" => "7",
						"valore8" => "8",
						"valore9" => "9",
						"valore10" => "10",
						"pulizia_sabbia_spiaggia" => "Pulizia della spiaggia : ",
						"percent_libera_spiaggia" => "Percentuale spiaggia libera : ",
						"percentuale10" => "10%",
						"percentuale20" => "20%",
						"percentuale30" => "30%",
						"percentuale40" => "40%",
						"percentuale50" => "50%",
						"percentuale60" => "60%",
						"percentuale70" => "70%",
						"percentuale80" => "80%",
						"percentuale90" => "90%",
						"percentuale100" => "100%",
						"lunghezza_spiaggia" => "Lunghezza spiaggia(in metri) : ",
						"larghezza_spiaggia" => "Larghezza spiaggia(in metri) : ",
						"voto_particolarita_spiaggia" => "Voto alla particolarità della spiaggia : ",
						"voto_traspubblico_spiaggia" => "Voto traspubblico della spiaggia : ",
						"facilita_parcheggio" => "Facilità nel trovare parcheggio : ",
						"affollamento_spiaggia" => "Affollamento spiaggia : ",
						"relax_spiaggia" => "Relax spiaggia : ",
						"sicurezza_spiaggia" => "Sicurezza della spiaggia : ",
						"ingresso_spiaggia" => "Ingresso alla spiaggia : ",
						"invito" => "Su invito",
						"pagamento" => "A pagamento",
						"free" => "Libera",
						"sport_praticabili" => "Sport praticabili : ",
						"tipo_suolo" => "Tipologia del suolo : ",
						"colore_spiaggia" => "Colore della spiaggia : " ,
						"fondale_spiaggia" => "Fondale della spiaggia : ",
						"voto_accessibilita_spiaggia" => "Voto all'accessibilità della spiaggia :",
						"vento_ideale" => "Vento ideale per la spiaggia : ",
						"frequentata_da" => "Frequentazione della spiaggia da : ",
						"locSconosciuta" => "Sconosciuta"
 						));

	/**
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

		$ingredients['listaTipoSuolo'] = array("A7Spggsuolo");
		$ingredients['listaVentoIdeale'] = array("A7Spggventoideale");
		$ingredients['listaFrequentataDa'] = array("A7Spggfrequentazioni");
		$ingredients['listaSport'] = array("A7Spggsport");

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


		// Prepare options for "lista localita" select
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
								"estivo_invernale_struttura", false,"estivo"));
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
			// Mostra la label$this->add("<br/>"); categoria
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
			$this->add(new Input(	"checkbox", $this->txt['bozza'],
									"stato_struttura", false,"bozza"));
			$this->add(new Input(	"checkbox",$this->txt['proponi'],
									"stato_struttura", false,"proponi"));
			$this->add(new Input(	"checkbox",$this->txt['approvato'],
									"stato_struttura", false,"approvato"));
			$this->add(new Input(	"checkbox",$this->txt['revisionato'],
									"stato_struttura", false,"rivisto"));
			$this->add( "<br />");
		}


		//--------------- Inizio Scheda tecnica spiaggia -----------------------

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['titleExpand']));


		$this->add("<b>".$this->txt['tipo_suolo']."</b>");
		$this->add( "<br />");
		foreach ($this->listaTipoSuolo as $key => $suolo)
		{
			$this->add(new Input("checkbox",$suolo->tipo_spggsuolo,"id_spggsuolo[$key]",true,$suolo->id_spggsuolo));
			$this->add("<br/>");
		}

		$this->add( "<br />");

		//colore spiaggia
		$this->add("<b>".$this->txt['colore_spiaggia']."</b>");
		$this->add(new Input("radio", $this->txt['chiara'], "colore_spiaggia", false, "chiara"));
		$this->add(new Input("radio", $this->txt['scura'], "colore_spiaggia", false, "scura"));

		$this->add("<br/>");

		//fondale spiaggia
		$this->add("<b>".$this->txt['fondale_spiaggia']."</b>");
		$this->add(new Input("radio", $this->txt['sabbia'], "fondale_spiaggia", false, 'sabbia'));
		$this->add(new Input("radio", $this->txt['roccia'], "fondale_spiaggia", false, 'roccia'));
		$this->add(new Input("radio", $this->txt['misto'], "fondale_spiaggia", false, 'misto'));

		$this->add("<br/>");

		//pulizia acqua spiaggia
		$this->add("<b>".$this->txt['pulizia_acqua_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_pulizia_acqua_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "pulizia_acqua_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//pulizia sabbia spiaggia
		$this->add("<b>".$this->txt['pulizia_sabbia_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_pulizia_sabbia_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "pulizia_sabbia_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//vento ideale MM
		$this->add("<b>".$this->txt['vento_ideale']."</b>");
		$this->add("<br/>");
		foreach ($this->listaVentoIdeale as $key => $vento)
		{
			$this->add(new Input("checkbox",$vento->nome_spggventoideale,"id_spggventoideale[$key]",true,$vento->id_spggventoideale));
			$this->add("<br/>");
		}
		$this->add("<br/>");

		//frequentata da MM
		$this->add("<b>".$this->txt['frequentata_da']."</b>");
		$this->add("<br/>");
		foreach ($this->listaFrequentataDa as $key => $frequentataDa)
		{
			$this->add(new Input("checkbox",$frequentataDa->nome_spggfrequentazioni,"id_spggfrequentazioni[$key]",true,$frequentataDa->id_spggfrequentazioni));
			$this->add("<br/>");
		}


		$this->add("<br/>");

		//Percentuale spiaggia libera
		$this->add("<b>".$this->txt['percent_libera_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_percent_libera_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['percentuale'.$i*10], "percent_libera_spiaggia", false, $i*10));
		}

		$this->add("<br/>");

		//larghezza spiaggia
		$this->add(new Input("text", $this->txt['larghezza_spiaggia'], "larghezza_spiaggia", false, null));

		$this->add("<br/>");

		//lunghezza spiaggia
		$this->add(new Input("text", $this->txt['lunghezza_spiaggia'], "lunghezza_spiaggia", false, null));

		$this->add("<br/>");

		//voto particolarità spiaggia
		$this->add("<b>".$this->txt['voto_particolarita_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_voto_particolarita_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "voto_particolarita_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//voto accessibilità spiaggia
		$this->add("<b>".$this->txt['voto_accessibilita_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_voto_accessibilita_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "voto_accessibilita_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//facilità parcheggio
		$this->add($this->add("<b>".$this->txt['facilita_parcheggio']."</b>"));
		$this->add("<br/>");

		for($i=0;$i<=$this->range_facilita_parcheggio_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "facilita_parcheggio_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//voto traspubblico
		$this->add("<b>".$this->txt['voto_traspubblico_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_voto_traspubblico_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "voto_traspubblico_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//Ingresso spiaggia
		$this->add("<b>".$this->txt['ingresso_spiaggia']."</b>");
		$this->add("<br/>");
		$this->add(new Input("radio", $this->txt['free'], "ingresso_spiaggia", false, 'free'));
		$this->add(new Input("radio", $this->txt['pagamento'], "ingresso_spiaggia", false, 'pagamento'));
		$this->add(new Input("radio", $this->txt['invito'], "ingresso_spiaggia", false, 'invito'));

		$this->add("<br/>");

		//sicurezza spiaggia
		$this->add("<b>".$this->txt['sicurezza_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_sicurezza_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "sicurezza_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//affollamento spiaggia
		$this->add("<b>".$this->txt['affollamento_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_affollamento_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "affollamento_spiaggia", false, $i));
		}


		$this->add("<br/>");

		//relax spiaggia
		$this->add("<b>".$this->txt['relax_spiaggia']."</b>");
		$this->add("<br/>");

		for($i=1;$i<=$this->range_relax_spiaggia;$i++)
		{
			$this->add(new Input("radio", $this->txt['valore'.$i], "relax_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//sport praticabili MM
		$this->add("<b>".$this->txt['sport_praticabili']."</b>");
		$this->add("<br/>");
		foreach ($this->listaSport as $key => $sport)
		{
			$this->add(new Input("checkbox",$sport->nome_spggsport,"id_spggsport[$key]",true,$sport->id_spggsport));
			$this->add("<br/>");
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
