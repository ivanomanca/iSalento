<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Home Page, categoria pagine "Extra"
 *
 */
class ExtraHome extends Isp_View_Page{
	public  $currentTab = 0;

	// Meta CNT
	public $titleMeta = "iSalento Homepage - Salento";
	public $keywordsMeta = "iSalento, Spiagge Salento, Mare Salento,
							Foto Salento, Salento, Lecce, Puglia";
	public $descriptionMeta = "Le guide pi complete sul Salento:
								mare, spiagge, foto, articoli.";

	// Dictionary
	public $dictionary = array(
			"it" =>
			 array( "approfondisci" => "Appofondisci &raquo;",
			 		"titoloCartina" => "Cartina, Mappa del Salento",
			 		"salentoLocalita" => "Salento e localita ...",
			 		"muoversiLocalita" => "Muoversi sul posto ...",
			 		"arrivareLocalita" => "Come raggiungerci ...",
			 		"cartolineHeader" => "CARTOLINE dal SALENTO",
			 		"dove" => "Dove",
			 		"cosa" => "Cosa",
			 		"cercaMiddleRight" => "&nbsp;Cerca!&nbsp;",
			 		"descrButton" => "Cerca le informazioni sul Salento!",
			 		'infoMiddleRight' => "Info",
			 		'fotoMiddleRight' => "Foto",
			 		'strutturaMiddleRight' => "Mare",
			 		'articoloMiddleRight' => "Articoli"
					));


	// Object state
	public $footerSymbol = " | ";
	public $fotoSizeCartoline = 100;
	public $nCartoline = 4;
	public $nomeImmagineCartina = "cartina_salento+italia3.png";
	public $coordinate = array(	"lecce" => "267,75,322,102",
								"otranto" => "374,166,434,200",
								"gallipoli" => "190,216,245,240",
								"leuca" => "343,335,419,383");
	public $middleRightButtonPath  = "index.php?component=Page&task=getPage";

	// Dynamic data
	public $listaFoto = null;
	public $listaLocalita = null;
	public $articoloNews = null;
	public $fotoNews = null;
	public $urlPageNews = null;
	public $urlPhotoNews = null;

	public function getIngredients(){
		$ingredients = array();
		// Richiesta per le cartoline
		$ingredients['listaFoto'] = array(	"A7B7Fotovideo",
											array("marker_fotovideo" => "cartolina",
												  "order_rnd" => "",
												  "righe" => $this->nCartoline));

		// if general article load the localitˆ select (we're in rubriche)
		$ingredients['*listaLocalita'] = array(	"localita",
													array("nome_localita" => "ASC"));
		// NEWS
		$ingredients['articoloNews'] = array(	"A7B7Articolo",
											array("speciale_articolo" => 1,
												  "order_rnd" => "",
												  "righe" => 1));
		return $ingredients;
	}

	public function getRelatedIngredients(){
		$ingredients = array();
		if(isset($this->articoloNews[0])){
			$ingredients['fotoNews'] =
					array("A7Fotovideo",
						array("id_articolo-fotovideo" =>
									$this->articoloNews[0]->Articolo->id_articolo,
							  "formato_speciale_fotovideo" => 1,
							  "order_rnd" => "",
							  "righe" => 1)
											);
		}
		return $ingredients;
	}

	public function skeleton(){
		//Isp_Loader::loadVistaObj("Bones", null, "Template");
		//$tpl = new Template($this->_urls->colors[$this->currentTab]);

    	// HEAD
		Isp_Loader::loadVistaObj("Snippets","Meta","cHead");
		Isp_Loader::loadVistaObj("Snippets","Meta","Meta");
		$cHead = new cHead(new Meta($this->titleMeta,
									$this->keywordsMeta,
									$this->descriptionMeta));
		// TOP NAV
		Isp_Loader::loadVistaObj("Snippets","Navigation","SubNav");
		Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNavTab");
		// Top nav tabs
		$tabs = array();
		// Per tuttei gli urls definiti in _urls (classe di configurazione)
		for ($i = 0; $i<sizeof($this->_urls->topTabUrls); $i++){
			$sub = null;
			if(isset($this->_urls->subUrls[$i]) and $this->currentTab != 0){
			    // If a subNav bar esists
				$sub = new SubNav($this->_urls->subUrls[$i]);
			}
			array_push($tabs, new cTopNavTab(	$this->_urls->colors[$i],
												$this->_urls->topTabUrls[$i],
												$sub));
		}

		Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNav");
		$topNav = new cTopNav($tabs, $this->_urls->colors[$this->currentTab]);

		// TESTATA
		Isp_Loader::loadVistaObj("Snippets","Layout","Testata");
		$testata = new Testata(null, "iSalento", true);

		// HEADER
		Isp_Loader::loadVistaObj("Snippets","Layout","cHeader");
		$header = new cHeader($topNav, $testata);

		// CARTOLINE
		$fwParamsArray = array(
								   "marker_fotovideo" => "cartolina",
								   "listaTitle" => $this->_urls->subUrls[2][1]->title,
									"listaPageName" =>
												$this->_urls->subUrls[2][1]->page,
									"listaPageDescription" =>
												$this->_urls->subUrls[2][1]->description,
									"markerunderscorefotovideo" => "cartolina"
								   );

		$urlPhotoArray = array();
		if(!empty($this->listaFoto)){ // Se non ci sono foto nel db
			for ($i = 0; $i<4; $i++){
				$foto = $this->listaFoto[$i];
				// Trasmetto l'id della foto +
				// lista di foto che voglio +
				// la lista di provenienza codificata
	
				$cartolineArray = $fwParamsArray + array(	"idFotovideo" =>
															$foto->Fotovideo->id_fotovideo);
				// Link alla pagina scheda foto
				$urlPageCartoline = new Isp_Url_Page($foto->Tfv->nome_tfv,
											"Scheda",
											"SchedaFoto",
											$cartolineArray,
											$foto->Tfv->didascalia_tfv );
				// Link della foto
				$urlPhotoCartoline = new Isp_Url_Photo(	$foto->Fotovideo->id_fotovideo,
													$this->fotoSizeCartoline,
													$foto->Tfv->nome_tfv,
													$foto->Tfv->didascalia_tfv);
				$pic  = array($urlPageCartoline, $urlPhotoCartoline);
				array_push($urlPhotoArray, $pic);
			}
		}
		// Photo Ul
		Isp_Loader::loadVistaObj("Snippets","List","PhotoUl");
		$photoUl = new PhotoUl($urlPhotoArray, true, true);

		Isp_Loader::loadVistaObj("Snippets","Home","cCaseBlockHome");
		$cartolineBox = new cCaseBlockHome($this->txt['cartolineHeader'], $photoUl, "verde");

		// NEWS HOME
		/*if(isset($this->articoloNews[0])){
			$urlNewsPage = new Isp_Url_Page($this->articoloNews[0]->A7Tea[0]->titolo_tea,
										"Scheda",
										"SchedaArticolo",
										array("id_articolo" =>
											$this->articoloNews[0]->Articolo->id_articolo),
										$this->articoloNews[0]->A7Tea[0]->abstract_tea);
		}
		if(isset($this->fotoNews[0])){
			$urlNewsPhoto = new Isp_Url_Photo(	$this->fotoNews[0]->id_fotovideo,
											296,
											$this->fotoNews[0]->nome_file_fotovideo,
											$this->articoloNews[0]->A7Tea[0]->titolo_tea);
		}
		*/
		Isp_Loader::loadVistaObj("Snippets", "Home", "NewsHome");
		/*$news = new NewsHome(	$urlPage->description,
								$urlPage,
								$urlPhoto,
								$this->txt['approfondisci']);*/

		// Se presenti delle info nel db
		if(isset($this->urlPageNews)){
			$news = new NewsHome(	$this->urlPageNews->description,
									$this->urlPageNews,
									$this->urlPhotoNews,
									$this->txt['approfondisci']);

		}else{
			$news = null;
		}
		// MIDDLE LEFT

		// Url foto cartina
		$cartinaPath = $this->thisPageUrl->pageFolder."Images/".$this->nomeImmagineCartina;
		$urlPhotoCartina = new Isp_Url_Photo(	null,
										null,
										null,
										null,
										$cartinaPath);

		// Lista localita url
		//$urlPageCartina = clone $this->_urls->subUrls[3][0];

		// CARTOLINE
		$localitaFwParams = array(
								   "listaTitle" => $this->_urls->subUrls[3][0]->title,
									"listaPageName" =>
												$this->_urls->subUrls[3][0]->page,
									"listaPageDescription" =>
												$this->_urls->subUrls[3][0]->description,
								   );
		$gallipoliUrl = new Isp_Url_Page(	"Gallipoli",
											"Scheda",
											"SchedaLocalita",
											array("id_localita" => 1)+$localitaFwParams
											);
		$leucaUrl = new Isp_Url_Page(	"Leuca",
											"Scheda",
											"SchedaLocalita",
											array("id_localita" => 2)+$localitaFwParams
											);
		$otrantoUrl = new Isp_Url_Page(	"Otranto",
											"Scheda",
											"SchedaLocalita",
											array("id_localita" => 3)+$localitaFwParams
											);
		$lecceUrl = new Isp_Url_Page(	"Lecce",
											"Scheda",
											"SchedaLocalita",
											array("id_localita" => 4)+$localitaFwParams
											);

		// Matrice mappa
		$mapMatrix = array(
							array($this->coordinate['gallipoli'], $gallipoliUrl),
							array($this->coordinate['otranto'], $otrantoUrl),
							array($this->coordinate['leuca'], $leucaUrl),
							array($this->coordinate['lecce'], $lecceUrl),
							);
		// Carico e istanzio lo snippet scheda tecnica
		Isp_Loader::loadVistaObj("Snippets", "Home", "MiddleHome");
		$middleMap = new MiddleHome($this->txt['titoloCartina'],
									$urlPhotoCartina,
									"#Map",
									$mapMatrix);


		// MIDDLE RIGHT
		Isp_Loader::loadVistaObj("Snippets","Home","MiddleRight");
		// Links
		$urlLocalita = clone $this->_urls->subUrls[3][0];
		$urlLocalita->title = $this->txt['salentoLocalita'];
		$urlMuoversi = clone $this->_urls->subUrls[3][1];
		$urlMuoversi->title = $this->txt['muoversiLocalita'];
		$urlArrivare = clone $this->_urls->subUrls[3][2];
		$urlArrivare->title = $this->txt['arrivareLocalita'];

		$urlDirectLinks = array($urlLocalita,
								$urlMuoversi,
								$urlArrivare);
		// Select localita
		$optionsLoc = array();
		
		Isp_Loader::loadVistaObj("Snippets", "Html", "Select");
		if(isset($this->listaLocalita)){ // Se presenti delle loc nel db
			foreach ($this->listaLocalita as $obj) {
				array_push($optionsLoc, array(	false,
											"",
											$obj['id_localita'],
											$obj['nome_localita']));
			}
			$selectLocalita = new Select(	"id_localita",
											$optionsLoc,
											null,
											null,
											$this->txt['dove']);
		}else{
			$selectLocalita = null;
		}

		// Select COSA
		// Scheda localita
		$paramsInfoLink = "#KEYpageType#VALUEScheda#KEYpage#VALUESchedaLocalita";
		// Bread info
		$paramsInfoLink .= "#KEYlistaTitle#VALUE".$this->_urls->subUrls[3][0]->title;
		$paramsInfoLink .= "#KEYlistaPageName#VALUE".$this->_urls->subUrls[3][0]->page;
		$paramsInfoLink .= "#KEYlistaPageDescription#VALUE".
										$this->_urls->subUrls[3][0]->description;

		// Lista Foto Localita
		$paramsFotoLink = "#KEYpageType#VALUELista#KEYpage#VALUEListaFoto";
		$paramsFotoLink .= "#KEYhome_localita_fotovideo#VALUE1";
		$paramsFotoLink .= "#KEYorder_dec#VALUErilevanza_fotovideo";

		// Lista Strutture di mare
		$paramsStrutturaLink = "#KEYpageType#VALUELista#KEYpage#VALUEListaStruttura";
		//$paramsStrutturaLink .= "#KEYid_categoria-tipostruttura#VALUE2";
		// Temp!!
		$paramsStrutturaLink .= "#KEYlistaTitle#VALUEAttrazioni";
		$paramsStrutturaLink .= "#KEYlistaPageName#VALUEListaStruttura";
		$paramsStrutturaLink .= "#KEYlistaPageDescription#VALUEAttrazioni%20di%20Mare";

		// Lista Articoli
		$paramsArticoloLink = "#KEYpageType#VALUELista#KEYpage#VALUEListaArticolo";

		$optionsCosa = array(
				array(	false, "", $paramsInfoLink, $this->txt['infoMiddleRight']),
				array(	false, "", $paramsFotoLink, $this->txt['fotoMiddleRight']),
				array(	false, "", $paramsStrutturaLink, $this->txt['strutturaMiddleRight']),
				array(	false, "", $paramsArticoloLink, $this->txt['articoloMiddleRight']),
							);
		$selectCosa = new Select("#GETSIMULATOR",
								$optionsCosa,
								null,
								null,
								$this->txt['cosa']);
		// Button urls
		$buttonUrl = new Isp_Url($this->middleRightButtonPath,
								$this->txt['cercaMiddleRight'],
								$this->txt['descrButton']);

		$middleRight = new MiddleRight(	$urlDirectLinks,
										array($selectLocalita, $selectCosa),
										$buttonUrl);


		// BOTTOM
		// Multiple
		// MARE
		$linksMatrixMare = array();
		$linksMatrixFoto = array();
		$linksMatrixRubriche = array();
		$pickItemsIndex = array(0, 1, 2); // si pu˜ fare anche random!
		//for( $i = 0; $i<3; $i++){
		foreach ($pickItemsIndex as $i){
			$urlPage = $this->_urls->subUrls[1][$i];
			// Build url Photo page preview from default settings
			// Or set an url page preview config array here!
			if(isset($urlPage->previewPhotoLink)){
				$urlPhoto = new Isp_Url_Photo(	null,
												null,
												$urlPage->title,
												$urlPage->description,
												$urlPage->previewPhotoLink);
			}else{
				$urlPhoto = null;
			}
			$pic  = array($urlPage, $urlPhoto);
			array_push($linksMatrixMare, $pic);
		}

		$pickItemsIndex = array(0, 2, 3); // Scegli quali barre caricare
		foreach ($pickItemsIndex as $i){
			$urlPage = $this->_urls->subUrls[2][$i];
			// Build url Photo page preview from default settings
			// Or set an url page preview config array here!
			if(isset($urlPage->previewPhotoLink)){
				$urlPhoto = new Isp_Url_Photo(	null,
												null,
												$urlPage->title,
												$urlPage->description,
												$urlPage->previewPhotoLink);
			}else{
				$urlPhoto = null;
			}
			$pic  = array($urlPage, $urlPhoto);
			array_push($linksMatrixFoto, $pic);
		}

		$pickItemsIndex = array(2, 3, 0);
		foreach ($pickItemsIndex as $i){
			$urlPage = $this->_urls->subUrls[4][$i];
			// Build url Photo page preview from default settings
			// Or set an url page preview config array here!
			if(isset($urlPage->previewPhotoLink)){
				$urlPhoto = new Isp_Url_Photo(	null,
												null,
												$urlPage->title,
												$urlPage->description,
												$urlPage->previewPhotoLink);
			}else{
				$urlPhoto = null;
			}
			$pic  = array($urlPage, $urlPhoto);
			array_push($linksMatrixRubriche, $pic);
		}


		//$matrix = $urlPhotoArray;
		//array_pop($matrix);
		Isp_Loader::loadVistaObj("Snippets","PageElements","cMultipleLinks");
		$cMultipleBlu = new cMultipleLinks($linksMatrixMare,"blu", true);
		$cMultipleVerde = new cMultipleLinks($linksMatrixFoto,"verde", true);
		$cMultipleRosa = new cMultipleLinks($linksMatrixRubriche,"giallo", true);

		// Boxes
		$urlApprofondisciMare  = clone $this->_urls->topTabUrls[1];
		$urlApprofondisciMare->title  = $this->txt['approfondisci'];
		$urlApprofondisciFoto  = clone $this->_urls->topTabUrls[2];
		$urlApprofondisciFoto->title  = $this->txt['approfondisci'];
		$urlApprofondisciRubriche  = clone $this->_urls->topTabUrls[4];
		$urlApprofondisciRubriche->title  = $this->txt['approfondisci'];

		$mareBox = new cCaseBlockHome("MARE", $cMultipleBlu, "blu", $urlApprofondisciMare);
		$fotoBox = new cCaseBlockHome("FOTO", $cMultipleVerde, "verde", $urlApprofondisciFoto);
		$rubricheBox = new cCaseBlockHome(	"RUBRICHE",
											$cMultipleRosa,
											"giallo",
											$urlApprofondisciRubriche);


		// Footer
		$footerUrls = $this->_urls->topTabUrlsLower;
		// Non loggato
		if(!isset($_SESSION['user'])){
			array_push(	$footerUrls,
						new Isp_Url_Page("Login", "Form", "FormLogin"));
		}else{
			array_push(	$footerUrls,
						new Isp_Url_Page("Logout [".$_SESSION['user']->username_utente."]",
										 "Form",
										 "FormLogin"));
		}
		
		Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");
		$footer = new LineNav($footerUrls, $this->footerSymbol, "footer");

		// Statistics - Google Analytics
		Isp_Loader::loadVistaObj("Snippets","Statistics","Analytics");
        $analytics = new Analytics();

		// CENTRAL PAGE HOME
		Isp_Loader::loadVistaObj("Snippets","Home","cCentralPageHome");
		$cPage = new cCentralPageHome(	array($cartolineBox, $news),
										array($middleMap, $middleRight),
										array($mareBox,$fotoBox,$rubricheBox),
										$footer	);


		// WRAPPER
		Isp_Loader::loadVistaObj("Snippets","Meta","Doctype");
		Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
		$wrap = new cWrapper(	new Doctype($this->lang),
								$cHead,
								$header,
								$cPage,
								$this->_urls->colors[$this->currentTab],
								true,
								$analytics);


			/*
		Isp_Loader::loadVistaObj("Bones", null, "PageNavigation");
		$navigation = new PageNavigation(	$this->_urls,
											$this->breadUrls,
											$this->currentTab);


		//$tpl->sideNav = $navigation->sideNav;
		//$tpl->extraNav = $navigation->extraNav;
		//$tpl->bread = $navigation->bread;
		$tpl->footer = $navigation->footer;



		// Elementi di pagina centrale
		$tpl->snpArray = $this->snpArray;
*/


		$body['wrap'] = $wrap->out();
		return $body;
	}
}

?>
