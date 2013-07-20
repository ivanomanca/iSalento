<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina update spiaggia
 *
 */
class UpdateSpiaggia extends Isp_View_Page{

	public $privilegioMin = Permission::REGISTERED;
	public $currentTab = 6;

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

	public $checkInserita = 0;
	public $checkInseritaNonSpuntata = 0;

	// Dati dinamici related
	public $listaLocalita = null;
	public $listaTipoStruttura = null;
	public $listaServizio = null;
	public $listaTipoSuolo = null;

	// Dictionary
	public $dictionary = array(
				"it" =>
				 array( "titlePage" => "Modifica struttura",
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
						"aggiorna" => "aggiorna",
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
						"titleExpand" => "Modifica scheda tecnica spiaggia",
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

		//Beaner scheda spiaggia
		$ingredients['beanStruttura'] = array("B7Struttura","userParams");

		//Beaner scheda spiaggia
		$ingredients['beanSpiaggia'] = array("B7Spiaggia","userParams");

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

				if($obj['id_localita'] == $this->beanStruttura->Struttura->id_localita)
					array_push($optionsLoc, array(	true,
											"",
											$obj['id_localita'],
											$obj['nome_localita']));
				else
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
	 	$this->add(new Input("text", $this->txt['nome'], "nome_struttura", false, $this->beanStruttura->Struttura->nome_struttura, 30));
	 	$this->add( "<br>");
		// Radio Stagione
		$this->add($this->txt['stagione']);

		if($this->beanStruttura->Struttura->estivo_invernale_struttura=="estivo")
			$this->add(new Input(	"radio", $this->txt['estiva'],
								"estivo_invernale_struttura", false,"estivo",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input(	"radio", $this->txt['estiva'],
								"estivo_invernale_struttura", false,"estivo"));

		if($this->beanStruttura->Struttura->estivo_invernale_struttura=="invernale")
			$this->add(new Input(	"radio", $this->txt['invernale'],
								"estivo_invernale_struttura", false,"invernale",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input(	"radio", $this->txt['invernale'],
								"estivo_invernale_struttura", false,"invernale"));

		if($this->beanStruttura->Struttura->estivo_invernale_struttura=="annuale")
			$this->add(new Input(	"radio", $this->txt['annuale'],
								"estivo_invernale_struttura", false,"annuale",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input(	"radio", $this->txt['annuale'],
								"estivo_invernale_struttura", false,"annuale"));

		$this->add( "<br>");
	 	// Radio Giorno notte
		$this->add($this->txt['apertura']);
		if($this->beanStruttura->Struttura->giorno_notte_struttura=="giorno")
			$this->add(new Input(	"radio",$this->txt['giorno'],
							"giorno_notte_struttura", false,"giorno",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input(	"radio",$this->txt['giorno'],
								"giorno_notte_struttura", false,"giorno"));
		if($this->beanStruttura->Struttura->giorno_notte_struttura=="notte")
			$this->add(new Input(	"radio",$this->txt['notte'],
							"giorno_notte_struttura", false,"notte",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input(	"radio",$this->txt['notte'],
							"giorno_notte_struttura", false,"notte"));
		if($this->beanStruttura->Struttura->giorno_notte_struttura=="sempre")
			$this->add(new Input(	"radio",$this->txt['sempre'],
							"giorno_notte_struttura", false,"sempre",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input(	"radio",$this->txt['sempre'],
							"giorno_notte_struttura", false,"sempre"));


		$this->add( "<br>");
		// Select Localita
		$this->add($this->txt['localita']);
		$this->add(new Select("id_localita", $optionsLoc));
		$this->add( "<br>");
		// Indirizzo o zona
		$this->add(new Input(	"text", $this->txt['indirizzo'],
								"indirizzo_zona_struttura", false, $this->beanStruttura->Struttura->indirizzo_zona_struttura, 45));
		$this->add( "<br>");
		// Sito web
		$this->add(new Input("text",$this->txt['sito'],"sito_struttura",false,$this->beanStruttura->Struttura->sito_struttura,50));
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
			//if($servizio)

			$this->checkInserita = 0;
			foreach ($this->beanStruttura->A7Servizio as $key2 => $valore)
			{
				if ($servizio->nome_servizio == $valore->nome_servizio)
				{
					$this->add(new Input(	"checkbox",
									ucfirst($servizio->nome_servizio),
									"id_servizio[$key]",
									true,
									$servizio->id_servizio,null,null,null,array("checked" => "yes")));
					$this->checkInserita = 1;
				}

			}
			if($this->checkInserita!=1 )
			{
				$this->add(new Input(	"checkbox",
								ucfirst($servizio->nome_servizio),
								"id_servizio[$key]",
								true,
								$servizio->id_servizio));
			}
			$this->add("<br />");
		}
		// Note
		$this->add( "<br />");

		$this->add(new TextArea($this->txt['note']."<br>","note_struttura", 70, 5,null,null,$this->beanStruttura->Struttura->note_struttura ));
		// Stato struttura
		$this->add( "<br />");
		if($this->privilegi <= 1) {
			$this->add($this->txt['statoStruttura']);

			if($this->beanStruttura->Struttura->stato_struttura=="bozza")
				$this->add(new Input(	"radio", $this->txt['bozza'],
									"stato_struttura", false,"bozza",null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input(	"radio", $this->txt['bozza'],
									"stato_struttura", false,"bozza"));

			if($this->beanStruttura->Struttura->stato_struttura=="proponi")
				$this->add(new Input(	"radio",$this->txt['proponi'],
									"stato_struttura", false,"proponi",null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input(	"radio", $this->txt['proponi'],
									"stato_struttura", false,"proponi"));
			if($this->beanStruttura->Struttura->stato_struttura=="approvato")
				$this->add(new Input(	"radio",$this->txt['approvato'],
									"stato_struttura", false,"approvato",null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input(	"radio",$this->txt['approvato'],
									"stato_struttura", false,"approvato"));
			if($this->beanStruttura->Struttura->stato_struttura=="revisionato")
				$this->add(new Input(	"radio",$this->txt['revisionato'],
									"stato_struttura", false,"rivisto",null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input(	"radio",$this->txt['revisionato'],
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
			$this->checkInserita = 0;
			foreach ($this->beanSpiaggia->A7Spggsuolo as $key2 => $valore)
			{
				if ($suolo->tipo_spggsuolo == $valore->tipo_spggsuolo)
				{
					$this->add(new Input("checkbox",$suolo->tipo_spggsuolo,"id_spggsuolo[$key]",true,$suolo->id_spggsuolo,null,null,null,array("checked" => "yes")));
					$this->checkInserita = 1;
				}
			}
			if($this->checkInserita!=1 )
			{
				$this->add(new Input("checkbox",$suolo->tipo_spggsuolo,"id_spggsuolo[$key]",true,$suolo->id_spggsuolo));
				$this->checkInserita=1;
			}
			$this->add("<br/>");
		}

		$this->add( "<br />");

		//colore spiaggia
		$this->add("<b>".$this->txt['colore_spiaggia']."</b>");

		if($this->beanSpiaggia->Spiaggia->colore_spiaggia=="chiara")
			$this->add(new Input("radio", $this->txt['chiara'], "colore_spiaggia", false, "chiara",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['chiara'], "colore_spiaggia", false, "chiara"));
		if($this->beanSpiaggia->Spiaggia->colore_spiaggia=="scura")
			$this->add(new Input("radio", $this->txt['scura'], "colore_spiaggia", false, "scura",null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['scura'], "colore_spiaggia", false, "scura"));

		$this->add("<br/>");

		//fondale spiaggia
		$this->add("<b>".$this->txt['fondale_spiaggia']."</b>");
		if($this->beanSpiaggia->Spiaggia->fondale_spiaggia=="sabbia")
			$this->add(new Input("radio", $this->txt['sabbia'], "fondale_spiaggia", false, 'sabbia',null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['sabbia'], "fondale_spiaggia", false, 'sabbia'));
		if($this->beanSpiaggia->Spiaggia->fondale_spiaggia=="roccia")
			$this->add(new Input("radio", $this->txt['roccia'], "fondale_spiaggia", false, 'roccia',null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['roccia'], "fondale_spiaggia", false, 'roccia'));
		if($this->beanSpiaggia->Spiaggia->fondale_spiaggia=="misto")
			$this->add(new Input("radio", $this->txt['misto'], "fondale_spiaggia", false, 'misto',null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['misto'], "fondale_spiaggia", false, 'misto'));

		$this->add("<br/>");

		//pulizia acqua spiaggia
		$this->add("<b>".$this->txt['pulizia_acqua_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_pulizia_acqua_spiaggia; $i++)
		{
			if ($this->beanSpiaggia->Spiaggia->pulizia_acqua_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "pulizia_acqua_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "pulizia_acqua_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//pulizia sabbia spiaggia
		$this->add("<b>".$this->txt['pulizia_sabbia_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_pulizia_sabbia_spiaggia; $i++)
		{
			if ($this->beanSpiaggia->Spiaggia->pulizia_sabbia_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "pulizia_sabbia_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "pulizia_sabbia_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//vento ideale MM
		$this->add("<b>".$this->txt['vento_ideale']."</b>");
		$this->add("<br/>");
		foreach ($this->listaVentoIdeale as $key => $vento)
		{
			$this->checkInserita = 0;
			foreach ($this->beanSpiaggia->A7SpggVentoideale as $key2 => $valore)
			{
				if ($vento->nome_spggventoideale == $valore->nome_spggventoideale)
				{
					$this->add(new Input("checkbox",$vento->nome_spggventoideale,"id_spggventoideale[$key]",true,$vento->id_spggventoideale,null,null,null,array("checked" => "yes")));
					$this->checkInserita = 1;
				}

			}
			if($this->checkInserita!=1 )
			{
				$this->add(new Input("checkbox",$vento->nome_spggventoideale,"id_spggventoideale[$key]",true,$vento->id_spggventoideale));
				$this->checkInserita = 1;
			}


			$this->add("<br/>");
		}



		$this->add("<br/>");

		//frequentata da MM
		$this->add("<b>".$this->txt['frequentata_da']."</b>");
		$this->add("<br/>");
		foreach ($this->listaFrequentataDa as $key => $frequentataDa)
		{
			$this->checkInserita = 0;
			foreach ($this->beanSpiaggia->A7Spggfrequentazioni as $key2 => $valore)
			{
				if ($frequentataDa->nome_spggfrequentazioni == $valore->nome_spggfrequentazioni)
				{
					$this->add(new Input("checkbox",$frequentataDa->nome_spggfrequentazioni,"id_spggfrequentazioni[$key]",true,$frequentataDa->id_spggfrequentazioni,null,null,null,array("checked" => "yes")));
					$this->checkInserita = 1;
				}

			}
			if($this->checkInserita!=1 )
			{
				$this->add(new Input("checkbox",$frequentataDa->nome_spggfrequentazioni,"id_spggfrequentazioni[$key]",true,$frequentataDa->id_spggfrequentazioni));
				$this->checkInserita = 1;
			}
			$this->add("<br/>");
		}


		$this->add("<br/>");

		//Percentuale spiaggia libera
		$this->add("<b>".$this->txt['percent_libera_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_percent_libera_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->percent_libera_spiaggia==$i*10)
				$this->add(new Input("radio", $this->txt['percentuale'.$i*10], "percent_libera_spiaggia", false, $i*10,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['percentuale'.$i*10], "percent_libera_spiaggia", false, $i*10));
		}

		$this->add("<br/>");

		//larghezza spiaggia
		$this->add(new Input("text", $this->txt['larghezza_spiaggia'], "larghezza_spiaggia", false, $this->beanSpiaggia->Spiaggia->larghezza_spiaggia));

		$this->add("<br/>");

		//lunghezza spiaggia
		$this->add(new Input("text", $this->txt['lunghezza_spiaggia'], "lunghezza_spiaggia", false, $this->beanSpiaggia->Spiaggia->lunghezza_spiaggia));

		$this->add("<br/>");

		//voto particolarità spiaggia
		$this->add("<b>".$this->txt['voto_particolarita_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_voto_particolarita_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->voto_particolarita_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "voto_particolarita_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "voto_particolarita_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//voto accessibilità spiaggia
		$this->add("<b>".$this->txt['voto_accessibilita_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_voto_accessibilita_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->voto_accessibilita_spiaggia==$i)
			$this->add(new Input("radio", $this->txt['valore'.$i], "voto_accessibilita_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
			$this->add(new Input("radio", $this->txt['valore'.$i], "voto_accessibilita_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//facilità parcheggio
		$this->add($this->add("<b>".$this->txt['facilita_parcheggio']."</b>"));
		$this->add("<br/>");

		for($i = 0; $i<=$this->range_voto_traspubblico_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->facilita_parcheggio_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "facilita_parcheggio_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "facilita_parcheggio_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//voto traspubblico
		$this->add("<b>".$this->txt['voto_traspubblico_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_voto_traspubblico_spiaggia; $i++)
		{
			if ($this->beanSpiaggia->Spiaggia->voto_traspubblico_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "voto_traspubblico_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "voto_traspubblico_spiaggia", false, $i));;
		}


		$this->add("<br/>");

		//Ingresso spiaggia
		$this->add("<b>".$this->txt['ingresso_spiaggia']."</b>");
		$this->add("<br/>");
		if($this->beanSpiaggia->Spiaggia->ingresso_spiaggia=="free")
			$this->add(new Input("radio", $this->txt['free'], "ingresso_spiaggia", false, 'free',null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['free'], "ingresso_spiaggia", false, 'free'));
		if($this->beanSpiaggia->Spiaggia->ingresso_spiaggia=="pagamento")
			$this->add(new Input("radio", $this->txt['pagamento'], "ingresso_spiaggia", false, 'pagamento',null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['pagamento'], "ingresso_spiaggia", false, 'pagamento'));
		if($this->beanSpiaggia->Spiaggia->ingresso_spiaggia=="invito")
			$this->add(new Input("radio", $this->txt['invito'], "ingresso_spiaggia", false, 'invito',null,null,null,array("checked" => "yes")));
		else
			$this->add(new Input("radio", $this->txt['invito'], "ingresso_spiaggia", false, 'invito'));

		$this->add("<br/>");

		//sicurezza spiaggia
		$this->add("<b>".$this->txt['sicurezza_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_sicurezza_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->sicurezza_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "sicurezza_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "sicurezza_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//affollamento spiaggia
		$this->add("<b>".$this->txt['affollamento_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_affollamento_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->affollamento_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "affollamento_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "affollamento_spiaggia", false, $i));
		}

		$this->add("<br/>");

		//relax spiaggia
		$this->add("<b>".$this->txt['relax_spiaggia']."</b>");
		$this->add("<br/>");

		for($i = 1; $i<=$this->range_relax_spiaggia; $i++)
		{
			if($this->beanSpiaggia->Spiaggia->relax_spiaggia==$i)
				$this->add(new Input("radio", $this->txt['valore'.$i], "relax_spiaggia", false, $i));
			else
				$this->add(new Input("radio", $this->txt['valore'.$i], "relax_spiaggia", false, $i,null,null,null,array("checked" => "yes")));
		}

		$this->add("<br/>");

		//sport praticabili MM
		$this->add("<b>".$this->txt['sport_praticabili']."</b>");
		$this->add("<br/>");
		foreach ($this->listaSport as $key => $sport)
		{
			$this->checkInserita=0;
			foreach ($this->beanSpiaggia->A7Spggsport as $key2 => $valore)
			{
				if($sport->nome_spggsport == $valore->nome_spggsport)
				{
					$this->add(new Input("checkbox",$sport->nome_spggsport,"id_spggsport[$key]",true,$sport->id_spggsport,null,null,null,array("checked" => "yes")));
					$this->checkInserita=1;
				}
			}
			if($this->checkInserita!=1 )
			{
				$this->add(new Input("checkbox",$sport->nome_spggsport,"id_spggsport[$key]",true,$sport->id_spggsport));
				$this->checkInserita=1;
			}

			$this->add("<br/>");
		}


		// Submit
		$this->add( "<br />");
		$this->add(new Input("submit", null, "nuddu", false, $this->txt['aggiorna']));
		// Close form
		$this->add(	"</form>");

		return $this->useDefaultTemplate();
	}



}
?>
