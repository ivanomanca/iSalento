<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 *  Pagina Scheda Spiaggia
 */

class SchedaSpiaggia extends Isp_View_Page {

	//Tab di appartenenza(mare)
	public $currentTab = 1;

	// Head info
	public $titleMeta = "Scheda iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha ..mare, spiagge nel Salento";
	public $linkDeleteSpiaggia;
	public $colonneServizi = 2;

	// Dictionary
	public $dictionary = array(
		   "it" =>  array( "titlePage" => "Scheda spiaggia -
											Spiagge, grotte, sport acquatici",
						   "descriptionPage" =>"versione alpha di iSalento",
						   "inBreve" => "In breve",
						   "readAllFoto" => "VEDI TUTTE >>",
						   "anteprimaFoto" => "Anteprima foto",
						   "descrAnteprimaFoto" => "Alcune foto in anteprima per ",
						   "descrReadAllFoto" => "Vedi tutte le foto ",
						   "anteprimaFoto" => "Anteprima foto",
						   "schedaTecnica" => "DETTAGLI : ",
						   "nomeStruttura" => "Nome",
						   "tipoStruttura" => "Tipo",
						   "servizi" => "Servizi",
						   "statoStruttura" => "Stato struttura",
						   "sito" => "Sito web : ",
						   "tipoSuolo" => "Tipo suolo",
						   "fondaleSpiaggia" => "Fondale spiaggia",
						   "relaxSpiaggia" => "Relax spiaggia",
						   "puliziaAcquaSpiaggia" => "Pulizia acqua spiaggia",
						   "puliziaSabbiaSpiaggia" => "Pulizia sabbia spiaggia",
						   "lunghezzaSpiaggia" => "Lunghezza spiaggia",
						   "larghezzaSpiaggia" => "Larghezza spiaggia",
						   "sicurezzaSpiaggia" => "Sicurezza",
						   "affollamentoSpiaggia" => "Affollamento",
						   "votoParticolaritaSpiaggia" => "Voto particolarità spiaggia",
						   "percentualeSpiaggiaLibera" => "Percentuale spiaggia libera",
						   "frequentazioniSpiaggia" => "Frequentazioni",
						   "ventoIdealeSpiaggia" => "Vento ideale",
						   "votoAccessibilitaSpiaggia" => "Voto accessibilità spiaggia",
						   "sportPraticatiSpiaggia" => "Sport praticati",
						   "categoriaAppartenenzaServizio" => "Categoria appartenenza del servizio",
						   "nomeServizio" => "Nome servizio",
						   "parcheggioSpiaggia" => "Parcheggio",
						   "titleDelete" => ">Elimina la spiaggia",
						   "delete" => "Elimina spiaggia",
						   "facilitaParcheggioSpiaggia" => "Facilità parcheggio spiaggia",
						   "descrizioneServizio" => "Descrizione servizio : ",
						   "readAllFoto" => "VEDI TUTTE >>"));

	// Dynamic data
	public $beanSpiaggia = null;

	public function getIngredients() {

		//Beaner scheda spiaggia
		$ingredients['beanStruttura'] = array("B7Struttura","userParams");

		//Beaner scheda spiaggia
		$ingredients['beanSpiaggia'] = array("B7Spiaggia","userParams");

		$ingredients['listaSport'] = array("A7Spggsport");

		return $ingredients;
	}

	public function skeleton() {

		 //Titolo
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$nomeSpiaggia = new TitleDescription($this->beanSpiaggia->Struttura->nome_struttura);

		$this->add($nomeSpiaggia);

		// Accorcio il nome :D
		$articolo = $this->beanStruttura->A7B7Articolo[0];

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($articolo->A7Tea[0]->titolo_tea));

		// ABSTRACT + FOTO
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAbstractFoto");
		$highlight = new SchedaAbstractFoto($this->beanStruttura,
											"struttura",
											$this->txt,
											$this->_urls->colors[$this->currentTab]);
		$this->add($highlight->snpOut);

		// ARTICLE EXPANSION
		Isp_Loader::loadVistaObj("Bones", null, "SchedaEspansioniArticolo");
		$espansioni = new SchedaEspansioniArticolo(	$articolo,
													$this->thisPageUrl,
													$this->_urls->colors[$this->currentTab]);
		$this->add($espansioni->snpOut);

		// TECHNICAL CARD
		$titoloSchedaTecnica = "<h2>".$this->txt['schedaTecnica'];
		$titoloSchedaTecnica .= $this->beanStruttura->Struttura->nome_struttura."</h2>";
		$this->add($titoloSchedaTecnica);

		// Snippet che stampa un elenco puntato
		$serviziArray = array();
		foreach ($this->beanSpiaggia->A7Servizio as $servizio){
			array_push($serviziArray, $servizio->nome_servizio);
		}

		$frequantazioniArray = array();
		foreach ($this->beanSpiaggia->A7Spggfrequentazioni as $item){
			array_push($frequantazioniArray, $item->nome_spggfrequentazioni);
		}

		$ventoIdealeSpiaggiaArray = array();
		foreach ($this->beanSpiaggia->A7Spggventoideale as $item){
			array_push($ventoIdealeSpiaggiaArray, $item->nome_spggventoideale);
		}

		$tipoSuoloArray = array();
		foreach ($this->beanSpiaggia->A7Spggsuolo as $item){
			array_push($tipoSuoloArray, $item->tipo_spggsuolo);
		}

		$sportPraticatiSpiaggiaArray = array();
		foreach ($this->beanSpiaggia->A7Spggsport as $item){
			array_push($sportPraticatiSpiaggiaArray, $item->nome_spggsport);
		}

		Isp_Loader::loadVistaObj("Snippets", "Card", "ElencoPuntatoTabella");
		$serviziSnippet = new ElencoPuntatoTabella($serviziArray, $this->colonneServizi);
		$frequantazioniSnippet = new ElencoPuntatoTabella($frequantazioniArray, $this->colonneServizi);
		$ventoIdealeSpiaggiaSnippet = new ElencoPuntatoTabella($ventoIdealeSpiaggiaArray, $this->colonneServizi);
		$tipoSuoloSnippet = new ElencoPuntatoTabella($tipoSuoloArray, $this->colonneServizi);
		$sportPraticatiSpiaggiaSnippet = new ElencoPuntatoTabella($sportPraticatiSpiaggiaArray, $this->colonneServizi);

		$matrix = array(
				array(	$this->txt['nomeStruttura'],
						$this->beanStruttura->Struttura->nome_struttura),
				array(	$this->txt['tipoStruttura'],
						ucfirst($this->beanStruttura->Struttura->nome_tipostruttura)),
				array($this->txt['tipoSuolo'],$this->beanSpiaggia->A7Spggsuolo[0]->tipo_spggsuolo),
				array($this->txt['fondaleSpiaggia'],$this->beanSpiaggia->Spiaggia->fondale_spiaggia),
				array($this->txt['puliziaAcquaSpiaggia'],$this->beanSpiaggia->Spiaggia->pulizia_acqua_spiaggia),
				array($this->txt['puliziaSabbiaSpiaggia'],$this->beanSpiaggia->Spiaggia->pulizia_sabbia_spiaggia),
				array($this->txt['lunghezzaSpiaggia'],$this->beanSpiaggia->Spiaggia->lunghezza_spiaggia),
				array($this->txt['larghezzaSpiaggia'],$this->beanSpiaggia->Spiaggia->larghezza_spiaggia),
				array($this->txt['sicurezzaSpiaggia'],$this->beanSpiaggia->Spiaggia->sicurezza_spiaggia),
				array($this->txt['affollamentoSpiaggia'],$this->beanSpiaggia->Spiaggia->affollamento_spiaggia),
				array($this->txt['votoParticolaritaSpiaggia'],$this->beanSpiaggia->Spiaggia->voto_particolarita_spiaggia),
				array($this->txt['percentualeSpiaggiaLibera'],$this->beanSpiaggia->Spiaggia->percent_libera_spiaggia."%"),
				array($this->txt['relaxSpiaggia'],$this->beanSpiaggia->Spiaggia->relax_spiaggia),
				array($this->txt['votoAccessibilitaSpiaggia'],$this->beanSpiaggia->Spiaggia->voto_accessibilita_spiaggia),
				array($this->txt['facilitaParcheggioSpiaggia'],$this->beanSpiaggia->Spiaggia->facilita_parcheggio_spiaggia),
				array($this->txt['servizi'], $serviziSnippet),
				array($this->txt['frequentazioniSpiaggia'],$frequantazioniSnippet),
				array($this->txt['ventoIdealeSpiaggia'],$ventoIdealeSpiaggiaSnippet),
				array($this->txt['tipoSuolo'],$tipoSuoloSnippet),
				array($this->txt['sportPraticatiSpiaggia'],$sportPraticatiSpiaggiaSnippet),
				);

		// Carico e istanzio lo snippet scheda tecnica
		Isp_Loader::loadVistaObj("Snippets", "Card", "SchedaTecnica");
		$this->add(new SchedaTecnica($matrix));

		//$this->add("<br>".$this->txt['tipoStruttura'].$this->beanSpiaggia->Struttura->nome_tipostruttura);
		//$this->add("<br>".$this->txt['tipoSuolo'].$this->beanSpiaggia->A7Suolo[0]->tipo_suolo);
		//$this->add("<br>".$this->txt['fondaleSpiaggia'].$this->beanSpiaggia->Spiaggia->fondale_spiaggia);
		//$this->add("<br>".$this->txt['puliziaAcquaSpiaggia'].$this->beanSpiaggia->Spiaggia->pulizia_acqua_spiaggia);
		//$this->add("<br>".$this->txt['puliziaSabbiaSpiaggia'].$this->beanSpiaggia->Spiaggia->pulizia_sabbia_spiaggia);
		//$this->add("<br>".$this->txt['lunghezzaSpiaggia'].$this->beanSpiaggia->Spiaggia->lunghezza_spiaggia);
		//$this->add("<br>".$this->txt['larghezzaSpiaggia'].$this->beanSpiaggia->Spiaggia->larghezza_spiaggia);
		//$this->add("<br>".$this->txt['sicurezzaSpiaggia'].$this->beanSpiaggia->Spiaggia->sicurezza_spiaggia);
		//$this->add("<br>".$this->txt['affollamentoSpiaggia'].$this->beanSpiaggia->Spiaggia->affollamento_spiaggia);
		//$this->add("<br>".$this->txt['votoParticolaritaSpiaggia'].$this->beanSpiaggia->Spiaggia->voto_particolarita_spiaggia);
		//$this->add("<br>".$this->txt['percentualeSpiaggiaLibera'].$this->beanSpiaggia->Spiaggia->percent_libera_spiaggia."%");
		//this->add("<br>".$this->txt['relaxSpiaggia'].$this->beanSpiaggia->Spiaggia->relax_spiaggia);

/*		$this->add("<br>".$this->txt['frequentazioniSpiaggia']);
		foreach ($this->beanSpiaggia->A7Frequentazioni as $item)
			$this->add($item->nome_frequentazioni."<br>");

		$this->add("<br>".$this->txt['ventoIdealeSpiaggia']);
		foreach ($this->beanSpiaggia->A7Ventoideale as $item)
			$this->add($item->nome_ventoideale.", ");

		$this->add("<br>".$this->txt['tipoSuolo']);
		foreach ($this->beanSpiaggia->A7Suolo as $item)
			$this->add($item->tipo_suolo.", ");

		//$this->add("<br>".$this->txt['votoAccessibilitaSpiaggia'].$this->beanSpiaggia->Spiaggia->voto_accessibilita_spiaggia);
		//$this->add("<br>".$this->txt['facilitaParcheggioSpiaggia'].$this->beanSpiaggia->Spiaggia->facilita_parcheggio_spiaggia);

		$this->add("<br>".$this->txt['sportPraticatiSpiaggia']);
		foreach ($this->beanSpiaggia->A7Sport as $item)
			$this->add($item->nome_sport.", ");
*/
		$this->add("<br>");

//		foreach ($this->beanSpiaggia->A7Servizio as $item)
//		{
//			$this->add("<br>".$this->txt['categoriaAppartenenzaServizio'].$item->nome_categoria."<br>");
//			$this->add($this->txt['nomeServizio'].$item->nome_servizio."<br>");
//			$this->add($this->txt['descrizioneServizio'].$item->descrizione_servizio."<br>");
//		}

		if($this->privilegi<=1)
		{
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			$urlDelete = new Href(new Isp_Url($this->linkDeleteSpiaggia,$this->txt['titleDelete'], $this->txt['delete']));

			$this->add($urlDelete);
			$this->add( "<br>");
			$this->add( "<br>");
		}

		$this->add("<br>");

		//Blocco anteprima foto
		Isp_Loader::loadVistaObj("Bones", null, "SchedaAnteprimaFoto");
		$anteprima = new SchedaAnteprimaFoto(	$this->beanSpiaggia,
												"struttura",
												$this->txt,
												$this->_urls->colors[$this->currentTab]);

		$this->add($anteprima->anteprimaFoto);

		// RUN IN TEMPLATE
		return $this->useDefaultTemplate();
	}
}

?>