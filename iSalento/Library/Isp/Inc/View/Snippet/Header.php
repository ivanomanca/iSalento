<?
/**
 *  HEADER CONF
 */
Isp_Loader::loadClass('Isp_Url');
Isp_Loader::loadClass('Isp_Url_Page');
Isp_Loader::loadClass('Isp_Url_Photo');

// LABELS & COLORS
$tabLabels = array("Home", "Mare", "Foto", "Salento", "Rubriche"/*, "Noi"*/);
$tabDescription = array("iSalento Homepage",
						"Il mare del Salento - spiagge, grotte, la costa",
						"Foto Salento",
						"Il Salento",
						"Rubriche dal Salento");
$colors = array("nero","blu","verde","arancione","giallo","grigio");

// TOP NAVIGATION BAR URLS
$topTabUrls = array(	new Isp_Url_Page(strtoupper($tabLabels[0]), 
										"Extra", 
										"ExtraHome",
										null, 
										$tabDescription[0]),
						new Isp_Url_Page(strtoupper($tabLabels[1]), 
										"Filtro", 
										"FiltroMare",
										null,
										$tabDescription[1]),
						new Isp_Url_Page(strtoupper($tabLabels[2]), 
										"Filtro", 
										"FiltroFoto",
										null,
										$tabDescription[2]),
						new Isp_Url_Page(strtoupper($tabLabels[3]), 
										"Filtro", 
										"FiltroArea",
										null,
										$tabDescription[3]),
						new Isp_Url_Page(strtoupper($tabLabels[4]),
										 "Filtro", 
										 "FiltroArticolo",
										 null,
										 $tabDescription[4])/*,
						new Isp_Url_Page(strtoupper($tabLabels[5]), "Filtro", "ProgettoISalento")*/
					);
// TOP NAVIGATION BAR URLS


$topTabUrlsLower = array(new Isp_Url_Page($tabLabels[0], 
										"Extra", 
										"ExtraHome",
										null, 
										$tabDescription[0]),
						new Isp_Url_Page($tabLabels[1], 
										"Filtro", 
										"FiltroMare",
										null,
										$tabDescription[1]),
						new Isp_Url_Page( $tabLabels[2], 
										"Filtro", 
										"FiltroFoto",
										null,
										$tabDescription[2]),
						new Isp_Url_Page( $tabLabels[3], 
										"Filtro", 
										"FiltroArea",
										null,
										$tabDescription[3]),
						new Isp_Url_Page( $tabLabels[4],
										 "Filtro", 
										 "FiltroArticolo",
										 null,
										 $tabDescription[4])/*,
						new Isp_Url_Page( $tabLabels[5], "Filtro", "ProgettoISalento")*/
					);
				

// SUB NAV BARS URLS
$subUrlsMare = array(	new Isp_Url_Page(	"Spiagge", 
											"Lista", 
											"ListaStruttura", 
											array("id_tipostruttura-struttura"=>1),
											"Tutte le spiagge del Salento",
											"porto-cesareo.jpg"),
						new Isp_Url_Page(	"Kite-Wind-Surf",
											"Lista",
											"ListaStruttura",
											array("id_tipostruttura-struttura"=>3),
											"Punti per sport acquatici",
											"kite-surf.jpg"),
						new Isp_Url_Page(	"Grotte",
											"Lista",
											"ListaStruttura",
											array("id_tipostruttura-struttura"=>2),
											"Le grotte pi&uacute; bastarde",
											"Zinzulusa.jpg"),
						new Isp_Url_Page(	"Subaquea",
											"Lista",
											"ListaStruttura",
											array("id_tipostruttura-struttura"=>4),
											"Immersioni profondo rosso",
											"scuba.jpg"),
						new Isp_Url_Page(	"Lidi e movida",
											"Lista",
											"ListaStruttura",
											array("id_tipostruttura-struttura"=>5),
											"Lidi movida in spiaggia",
											"Cocoloco-beach.jpg"),);
										
$subUrlsFoto = array(	new Isp_Url_Page(	"Cartoline", 
											"Lista", 
											"ListaFoto", 
											null,
											"Cartoline dal Salento"),
						new Isp_Url_Page(	"Mare",
											"Lista",
											"ListaFoto",
											array("id_tipostruttura-struttura"=>1),
											"Naviga tra le foto del mare"),
						new Isp_Url_Page(	"Luoghi",
											"Lista",
											"ListaStruttura",
											array("id_tipostruttura"=>7),
											"Foto sulle localita del Salento"),
						new Isp_Url_Page(	"Temi",
											"Lista",
											"ListaStruttura",
											null,
											"Sfoglia le foto tra le varie categorie"));

$subUrlsSalento = array(new Isp_Url_Page(	"Localit&agrave", 
											"Lista", 
											"ListaLocalita",
											null,
											"Esplora le localita del Salento"),
						new Isp_Url_Page(	"Come arrivarci",
											"Lista",
											"ComeArrivarci",
											null,
											"Info utili su come arrivare nel Salento"),
						new Isp_Url_Page(	"Muoversi sul posto",
											"Lista",
											"ListaStruttura",
											array("id_tipostruttura"=>7),
											"Consigli pratici alla mobilita interna"));
											
$subUrlsRubriche = array(new Isp_Url_Page(	"Arte & storia", 
											"Lista", 
											"ListaArticolo",
											array("id_categoria-articolo"=>1),
											"Scopri il lato artistico, storico e culturale"),
						new Isp_Url_Page(	"Mare",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>2),
											"Parliamo di mare"),
						new Isp_Url_Page(	"Notte & divertimenti",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>3),
											"Argomenti su vita notturna, musica e divertimento"),
						new Isp_Url_Page(	"Natura & relax",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>4),
											"Il lato naturalistico, paesaggistico e del relax"),
						new Isp_Url_Page(	"Sport",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>5),
											"Action! E' tempo di muoversi"),
						new Isp_Url_Page(	"Cucina",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>6),
											"Bar, ricette e ristorazione"),
						new Isp_Url_Page(	"Shopping",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>7),
											"Buona spesa, molta resa"),
						new Isp_Url_Page(	"Folklore",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>8),
											"Lu santu paulu de le tarante"),
						new Isp_Url_Page(	"Info utili",
											"Lista",
											"ListaArticolo",
											array("id_categoria-articolo"=>9),
											"Ospedali, numeri utili ed altro"));

$subUrls = array(null, $subUrlsMare, $subUrlsFoto, $subUrlsSalento, $subUrlsRubriche);


// BARRA DI INSERIMENTO (SOOLO ADMINS)
if(isset($privilegi) and $privilegi<=1){
	array_push($tabLabels, "Inserisci");
	array_push($tabDescription, "Inserisci");
	array_push($topTabUrls, new Isp_Url_Page(strtoupper($tabLabels[5]), 
											"Filtro", 
											"FiltroInserisci",
											null,
											$tabDescription[5]));
	array_push($topTabUrlsLower, new Isp_Url_Page(  $tabLabels[5], 
													"Filtro", 
													"FiltroInserisci",
													null,
													$tabDescription[5]));
	
	// SUB NAV BARS URLS
	$subUrlsInserisci = array(	new Isp_Url_Page(	"Attrazione", 
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
	array_push($subUrls, $subUrlsInserisci);
}




Isp_Loader::loadVistaObj("Snippets","Navigation","SubNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNavTab");
$tabs = array();
for ($i = 0; $i<sizeof($topTabUrls); $i++){
	$sub = null; 
	if(isset($subUrls[$i]) and ($i != 0)){  // If a subNav bar esists
		$sub = new SubNav($subUrls[$i]);
	}
	array_push($tabs, new cTopNavTab($colors[$i], $topTabUrls[$i], $sub)); 
}

Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNav");
$topNav = new cTopNav($tabs, $colors[$currentTab]);

// TESTATA
Isp_Loader::loadVistaObj("Snippets","Layout","Testata");
$testata = new Testata(null, "iSalento");

// HEADER
Isp_Loader::loadVistaObj("Snippets","Layout","cHeader");
$header = new cHeader($topNav, $testata);
?>