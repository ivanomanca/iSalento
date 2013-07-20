<?
//$_SERVER['DOCUMENT_ROOT'] = "/Users/".$_SERVER['USER']."/Sites/iSalento/";
//require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;

Isp_Loader::loadClass('Isp_Url_Page');
Isp_Loader::loadClass('Isp_Url_Photo');
/**
 * File di configuarazione contente la mappa del sito.
 *
 */

class NavigationUrls{

	public $lang = null;
	public $privilegi = null;

	// Labels
	public $dictionary = array( "it" => array(
	// TOP TAB
					"home" => "Home",
					 "mare" => "Mare",
					 "foto" => "Foto",
					 "area" => "Salento",
					 "rubriche" => "Rubriche",
					 "inserisci" => "Inserisci",
					 "login" => "Accedi",
					 "descrHome" => "iSalento Homepage",
					 "descrMare" => "Il mare del Salento - spiagge, grotte, la costa",
					 "descrFoto" => "Foto Salento",
					 "descrArea" => "Il Salento",
					 "descrRubriche" => "Rubriche dal Salento",
					 "descrInserisci" => "Inserisci",
					 "chiSiamo" => "Chi Siamo",
					 
					 // SUB TABS
					 "spiagge" => "Spiagge",
					 "surf" => "Kite-Wind-Surf",
					 "grotte" => "Grotte",
					 "subacquea" => "Subacquea",
					 "lidi" => "Lidi e movida",
						 "descrSpiagge" => "Tutte le spiagge del Salento",
					 "descrKite" => "Punti per sport acquatici",
					 "descrGrotte" => "Le grotte pi&uacute; bastarde",
					 "descrSubacquea" => "Immersioni profondo rosso",
					 "descrLidi" => "Lidi movida in spiaggia",
					 // Foto
					 "cartoline" => "Cartoline",
					 "mareFoto" => "Mare",
					 "luoghiFoto" => "Luoghi",
					 "temiFoto" => "Temi",
					 "descrCartoline" => "Cartoline dal Salento",
					 "descrFotoMare" => "Naviga tra le foto del mare",
					 "descrFotoLuoghi" => "Foto sulle localita del Salento",
					 "descrFotoTemi" => "Sfoglia le foto tra le varie categorie",
					 // Area
					 "localita" => "Localit&agrave",
					 "arrivarci" => "Come arrivarci",
					 "sulPosto" => "Muoversi sul posto",
					 "descrLocalita" => "Esplora le localita del Salento",
					 "descrArrivarci" => "Info utili su come arrivare nel Salento",
					 "descrSulPosto" => "Consigli pratici alla mobilita interna",
					 // Rubriche
					 "arteRubriche" => "Arte & storia",
					 "mareRubriche" => "Mare",
					 "notteRubriche" => "Notte & divertimenti",
					 "naturaRubriche" => "Natura & relax",
					 "sportRubriche" => "Sport",
					 "cucinaRubriche" => "Cucina",
					 "shoppingRubriche" => "Shopping",
					 "folkloreRubriche" => "Folklore",
					 "infoRubriche" => "Info utili",
					 "descrArteRubriche" =>
					 "Scopri il lato artistico, storico e culturale",
					 "descrMareRubriche" => "Parliamo di mare",
					 "descrNotteRubriche" =>
					 			"Argomenti su vita notturna, musica e divertimento",
					 "descrNaturaRubriche" =>
					 			"Il lato naturalistico, paesaggistico e del relax",
					 "descrSportRubriche" =>
					 				"Action! E' tempo di muoversi",
					 "descrCucinaRubriche" =>
					 				"Bar, ricette e ristorazione",
					 "descrShoppingRubriche" => "Shoppingando..",
					 "descrFolkloreRubriche" =>
					 				"Folklore e tradizioni",
					 "descrInfoRubriche" =>
					 			"Ospedali, numeri utili ed altro",
					 "specialeHome" => "Primo Piano",
					 "descrSpecialeHome" => "In anteprima speciale"),
					
					 
								"en" => array("home" => "Home",
											  "mare" => "Beaches",
											  "foto" => "Photos",
											  "area" => "Salento",
											  "rubriche" => "Articles",
											  "chiSiamo" => "About Us",
											  ));

	// URLS
	public $topTabUrls = array();
	public $topTabUrlsLower;

	// Just a copy o previous urls with lower case label
	public $subUrls;
	public $criteriSub;

	// Colors
	public $colors = array(	"nero", "blu", "verde",
							"arancione", "giallo", "grigio", "grigio","grigio");
	// Default Meta cnt
	public $titleMeta = "iSalento.it - versione alpha";
	public $keywordsMeta =
		"iSalento, Salento, Lecce, Puglia, spiagge, mare, foto";
	public $descriptionMeta =
		"iSalento, versione alpha. Mare, spiagge, foto Salento";

	/**
	 * Constructor
	 *
	 * @param string $lang
	 * @param int $privilegi
	 */
	public function __construct($lang, $privilegi){
		// Set state
		$this->lang = $lang;
		$this->privilegi = $privilegi;

		// Dictionary
		$txt = $this->dictionary[$lang];

		// TOP NAVIGATION BAR URLS
		$this->topTabUrlsLower = array(
									new Isp_Url_Page($txt['home'],
													"Extra",
													"ExtraHome",
													null,
													$txt['descrHome']),
									new Isp_Url_Page($txt['mare'],
													"Filtro",
													"FiltroMare",
													null,
													$txt['descrMare']),
									new Isp_Url_Page($txt['foto'],
													"Filtro",
													"FiltroFoto",
													null,
													$txt['descrFoto']),
									new Isp_Url_Page($txt['area'],
													"Filtro",
													"FiltroArea",
													null,
													$txt['descrArea']),
									new Isp_Url_Page($txt['rubriche'],
													 "Filtro",
													 "FiltroArticolo",
													 null,
													 $txt['descrRubriche']),
									new Isp_Url_Page($txt['chiSiamo'],
													 "Static",
													 "AboutUs",
													 null,
													 $txt['chiSiamo']),
									);

		// TOP NAVIGATION BAR URLS
		foreach ($this->topTabUrlsLower as $url){
			$urlCopy = clone $url;
			$urlCopy->title = strtoupper($urlCopy->title);
			array_push($this->topTabUrls, $urlCopy);
		}

		// sotto barra home
		$subUrlsHome = array(	new Isp_Url_Page(	$txt["specialeHome"],
													"Lista",
													"ListaSpeciale",
													null,
													$txt['descrSpecialeHome']));
		// SUB NAV BARS URLS
		$subUrlsMare = array(
								new Isp_Url_Page(	$txt["spiagge"],
													"Lista",
													"ListaSpiaggia",
													null,
													$txt['descrSpiagge'],
													"lido-pizzo-side.jpg"),
								new Isp_Url_Page(	$txt["surf"],
													"Lista",
													"ListaStruttura",
													array("id_tipostruttura-struttura"=>3),
													$txt['descrKite'],
													"kite-surf.jpg"),
								new Isp_Url_Page(	$txt['lidi'],
													"Lista",
													"ListaStruttura",
													array("id_tipostruttura-struttura"=>5),
													$txt['descrLidi'],
													"Cocoloco-beach.jpg"),
								new Isp_Url_Page(	$txt['grotte'],
													"Lista",
													"ListaStruttura",
													array("id_tipostruttura-struttura"=>2),
													$txt['descrGrotte'],
													"grotte-marine.jpg"),
								new Isp_Url_Page(	$txt["subacquea"],
													"Lista",
													"ListaStruttura",
													array("id_tipostruttura-struttura"=>4),
													$txt['descrSubacquea'],
													"scuba.jpg"),
								);

		$subUrlsFoto = array(	new Isp_Url_Page(	$txt['mareFoto'],
													"Lista",
													"ListaFoto",
													array("id_categoria-fotovideo" => 2,
														  	"order_dec" =>
														  	"rilevanza_fotovideo"),
													$txt["descrFotoMare"],
													"punta-della-suina.jpg"),
								new Isp_Url_Page(	$txt['cartoline'],
													"Lista",
													"ListaFoto",
													array("marker_fotovideo" => "cartolina"),
													$txt['descrCartoline'],
													"gallipoli-borgo.jpg"),
								new Isp_Url_Page(	$txt["luoghiFoto"],
													"Lista",
													"ListaFoto",
													array("home_localita_fotovideo" => 1,
														 "order_dec" => "rilevanza_fotovideo"),
													$txt['descrFotoLuoghi'],
													"santa-cesarea.jpg"),
								new Isp_Url_Page(	$txt['temiFoto'],
													"Lista",
													"ListaFoto",
													null,
													$txt['descrFotoTemi'],
													"temi-foto.jpg"));

		$subUrlsSalento = array(new Isp_Url_Page(	$txt['localita'],
													"Lista",
													"ListaLocalita",
													null,
													$txt['descrLocalita']),
								new Isp_Url_Page(	$txt['arrivarci'],
													"Lista",
													"ComeArrivarci",
													null,
													$txt['descrArrivarci']),
								new Isp_Url_Page(	$txt['sulPosto'],
													"Lista",
													"ListaStruttura",
													array("id_tipostruttura"=>7),
													$txt['descrSulPosto']));

		$subUrlsRubriche = array(new Isp_Url_Page(	$txt['arteRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>1),
													$txt['descrArteRubriche'],
													"arte-rubriche.jpg"),
								new Isp_Url_Page(	$txt['mareRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>2),
													$txt['descrMareRubriche'],
													"lido-pizzo.jpg"),
								new Isp_Url_Page(	$txt['notteRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>3),
													$txt['descrNotteRubriche'],
													"otranto-notte.jpg"),
								new Isp_Url_Page(	$txt['naturaRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>4),
													$txt['descrNaturaRubriche'],
													"natura-e-relax.jpg"),
								new Isp_Url_Page(	$txt['sportRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>5),
													$txt['descrSportRubriche'],
													"kite-surf.jpg"),
								new Isp_Url_Page(	$txt['cucinaRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>6),
													$txt['descrCucinaRubriche'],
													"cucina.jpg"),
								new Isp_Url_Page(	$txt['shoppingRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>7),
													$txt['descrShoppingRubriche'],
													"shopping.jpg"),
								new Isp_Url_Page(	$txt['folkloreRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>8),
													$txt['descrFolkloreRubriche'],
													"folklore.jpg"),
								new Isp_Url_Page(	$txt['infoRubriche'],
													"Lista",
													"ListaArticolo",
													array("id_categoria-articolo"=>9),
													$txt['descrInfoRubriche']));
		// Links sottobarre
		$this->subUrls = array(	$subUrlsHome,
										$subUrlsMare,
										$subUrlsFoto,
										$subUrlsSalento,
										$subUrlsRubriche,
										null
										);

		// Criteri raffinamento ricerca (ulteriori sotto link per ogni sottobarra)						// Posizione nella mappa [2][0]
		//$criteriSubFotoMare = array(new Isp_Url_Page(""));


		// BARRA DI INSERIMENTO (SOOLO ADMINS)
		if($privilegi <= 4){
			$insertUrl  = new Isp_Url_Page( $txt['inserisci'],
											"Filtro",
											"FiltroInserisci",
											null,
											$txt['descrInserisci']);

			$insertUrlCopy = clone $insertUrl;
			$insertUrlCopy->title = strtoupper($insertUrlCopy->title);
			array_push($this->topTabUrlsLower, $insertUrl);
			array_push($this->topTabUrls, $insertUrlCopy);


			// SUB NAV BARS URLS
			$subUrlsInserisci = array(
										new Isp_Url_Page(	"Attrazione",
															"Form",
															"InsertStruttura",
															 null,
															"Inserisci una struttura"),
										new Isp_Url_Page(	"Foto",
															"Form",
															"UploadPhoto",
															 null,
															"Carica delle foto"),
										new Isp_Url_Page(	"Localit&agrave;",
															"Form",
															"InsertLocalita",
															 null,
															"Per localita si intende.."),
										new Isp_Url_Page(	"Articolo",
															"Form",
															"InsertArticolo",
															null,
															"Scrivi un articolo tematico"),
										new Isp_Url_Page(	"Servizio",
															"Form",
															"InsertServizio",
															null,
															"Aggiungi dei servizi"));
			array_push($this->subUrls, $subUrlsInserisci);
		}
		
		/*
		// Tab Login
		$logUrl  = new Isp_Url_Page( $txt['login'],
											"Form",
											"FormLogin",
											null,
											"");

		$logUrlCopy = clone $logUrl;
		$logUrlCopy->title = strtoupper($logUrlCopy->title);
		array_push($this->topTabUrlsLower, $logUrl);
		array_push($this->topTabUrls, $logUrlCopy);
		*/
	}
}


?>