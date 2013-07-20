<?php
/**
 * Snippets
 * @todo gestire i link dei css come assoluti anzich relativi (temporaneamente 
 * il link relativo si trova nel padre Isp_View_Snippet).
 */
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";
// Relative level
$relative = "../../../../../../";

// Faccio includere il codice libreria (!non serve!!)
//$ini = ini_set('include_path',ini_get('include_path').PATH_SEPARATOR.'../../../../../../Library');
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;


Isp_Loader::loadClass('Isp_Url');
Isp_Loader::loadClass('Isp_Url_Photo');
//Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
Isp_Loader::loadVistaObj("Snippets","Meta","cHead");

/**
 * cHead
 */
$cHead = new cHead(new Meta("Snippets!")/*,
					new LinkRel(new Isp_Url($dir."Tests/Components/Page/Views/TemplateColors/Snippets/CSS/template.css"),
								array(new Isp_Url($dir."Tests/Components/Page/Views/TemplateColors/Snippets/CSS/template_sezione_giallo.css")))*/);
//$headOut = $cHead->out();
//echo $headOut;

/**
 * Navigazione
 */
Isp_Loader::loadVistaObj("Snippets","Layout","cHeader");
Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNavTab");
$currentColor = "verde";
$urls = array(new Isp_Url("/sub1/carlo","subOne"),
			new Isp_Url("/sub2/","subTwo"),
			new Isp_Url("/sub3/","suThree"));
								
$subNav1 = new SubNav($urls);
$subNav2 = new SubNav($urls);
$subNav3 = new SubNav($urls);

$navTab1 = new cTopNavTab("giallo",new Isp_Url("/link1/","TAB1"),$subNav1);
$navTab2 = new cTopNavTab("verde",new Isp_Url("/link2/","TAB2"),$subNav2);
$navTab3 = new cTopNavTab("blu",new Isp_Url("/link2/","TAB2"),$subNav3);
$tabs = array($navTab1,$navTab2,$navTab3);

$topNav = new cTopNav($tabs,$currentColor);
//$outTopNav = $topNav->out();
//echo $outTopNav;

/**
 * Testata
 */
Isp_Loader::loadVistaObj("Snippets","Layout","Testata");
$testata = new Testata();
//$outTestata = $testata->out();
//echo $outTestata;

/**
 * Header
 */
$header = new cHeader($topNav,$testata);
//$outHeader = $header->out();
//echo $outHeader;

/**
 * Side bar
 */
Isp_Loader::loadVistaObj("Snippets","Navigation","cSideNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","SideListNav");
$sxNav1 =  new SideListNav($urls,"verde");
$sxNav2 =  new SideListNav($urls,"giallo");
//$outSxNav = $sxNav1->out();
//echo($outSxNav);								

// Left
$sideNav = new cSideNav(array($sxNav1,$sxNav2));
//$outSideNav = $sideNav->out();
// Right
$extraNav = new cSideNav(array($sxNav1,$sxNav2),"extra");
//$outExtraNav = $sideNav->out();

/**
 * Line Navigation
 */
// Breadcrumb
Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");
$bread = new LineNav($urls,">");
//$outBread = $bread->out();
// Footer
$footer = new LineNav($urls,"|","footer");
//$outFooter = $footer->out();

/**
 * Central page
 */
// TITLE DESCRIPTION
Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
$titDescr = new TitleDescription("Titolo!!!","Breve descrizione della pagina..");
// IN BOX ITEMS
Isp_Loader::loadVistaObj("Snippets","PageElements","PicTitleAbstract");
$urlPhoto = new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt",$relative);
$urlTitle = new Isp_Url($urlPhoto->path,"Questo il mio articolo");
$readAllUrl = new Isp_Url($urlPhoto->path,"leggi tutto..");
$abstract = "Il festival &egrave promosso ed organizzato da Regione Puglia, Provincia di Lecce, Unione dei Comuni della Grecia Salentina e Istituto Diego Carpitella in collaborazione con Camera di Commercio di Lecce e Gioco del Lotto.";
$inBoxItems = new PicTitleAbstract($urlPhoto,$urlTitle,$abstract,$readAllUrl);
// LIST SEPARATOR
Isp_Loader::loadVistaObj("Snippets","List","Separator");
$listSep = new Separator($urlTitle,$readAllUrl);
// LIST ITEM
Isp_Loader::loadVistaObj("Snippets","List","cListItem");
$listItem = new cListItem($listSep,$inBoxItems,true);
// LIST
Isp_Loader::loadVistaObj("Snippets","List","cList");
$list = new cList(array($listItem,$listItem,$listItem));
// CASE BOX
Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
//$caseBlock = new cCaseBlock("Prova",null,"Testo interno!!");

// SELECT
$optionItem = array(true,"labelsel","value","description");
$optionItem1 = array(false,"label","value","description");
$optionItem2 = array(false,"label2","value2","description2");
$groupSelect = array(array($optionItem),
					 "Gruppo1"=>array($optionItem1,$optionItem2),
					 "Gruppo2"=>array($optionItem1,$optionItem2));
Isp_Loader::loadVistaObj("Snippets","Html","Select");
$select = new Select("testSelect",$groupSelect);
// LI
Isp_Loader::loadVistaObj("Snippets","Html","Li");
$li = new Li($urlTitle,"id test", "classe test");
// HREF
Isp_Loader::loadVistaObj("Snippets","Html","Href");
$href = new Href($urlPhoto,"id test", "classe test");
// CLEAR
Isp_Loader::loadVistaObj("Snippets","Html","Clear");
$clear = new Clear("left",true);

// SEARCH FILTER
Isp_Loader::loadVistaObj("Snippets","PageElements","SearchFilter");
$searchFilter = new SearchFilter("Ricerca singola","Ordina per: ",$select);
$caseBlock = new cCaseBlock($searchFilter->titleHeader,
							$searchFilter->classHeader,
							$searchFilter,$currentColor);
							
// AT A GLANCE
Isp_Loader::loadVistaObj("Snippets","PageElements","AtAGlance");
$atAGlance = new AtAGlance("A colpo occhio",$urls);
$caseBlock2 = new cCaseBlock($atAGlance->titleHeader,null,$atAGlance,$currentColor);

// FOUR PHOTOS
Isp_Loader::loadVistaObj("Snippets","PageElements","FourPhotos");
$array4foto = array(new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt",$relative),
					new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt",$relative),
					new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt",$relative),
					new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt",$relative));
$four = new FourPhotos("Blocchetto 4 foto..",$array4foto,$readAllUrl);
$caseBlock3 = new cCaseBlock("4 foto!",null,$four,$currentColor);


// Article expansion
Isp_Loader::loadVistaObj("Snippets","Card","ArticleExpansion");
$text = "Questa e con l'accento una prova per il testo del paragrafo<br><br>";
$expansion1 = new ArticleExpansion($text, null, true);
$expansion2 = new ArticleExpansion($text, $urlTitle);
$expansion3 = new ArticleExpansion($text, $urlTitle);

// cExpansion List
Isp_Loader::loadVistaObj("Snippets","Card","cExpansionList");
$cExpansion = new cExpansionList(array($expansion1, $expansion2, $expansion3));


// MULTIPLE LINKS ITEM
Isp_Loader::loadVistaObj("Snippets","PageElements","MultipleLinksItem");
$picUrl = new Isp_Url_Photo(2,"small","baia Gallipoli","baia alt",$relative);
$multipleItem = new MultipleLinksItem($urlTitle,$picUrl,"Descrizione bloccheto foto..");
$multipleItem1 = new MultipleLinksItem($urlTitle,$picUrl,"Descr 1..");
$multipleItem2 = new MultipleLinksItem($urlTitle,$picUrl,"Descrizione bloccheto foto2..");
$multipleItem3 = new MultipleLinksItem($urlTitle,$picUrl,"Descrizione bloccheto foto3..");
// cMULTIPLE LINKS
Isp_Loader::loadVistaObj("Snippets","PageElements","cMultipleLinks");
$mLinksArray = array($multipleItem,$multipleItem1,$multipleItem2,$multipleItem3);
$cMultiple = new cMultipleLinks($mLinksArray);
$caseBlock4 = new cCaseBlock("BLOCCHETTI!",null,$cMultiple,$currentColor);
//$caseBlock4->out("echo");

/**
 * Central page
 */
Isp_Loader::loadVistaObj("Snippets","Layout","cCentralPage");
$cPage = new cCentralPage($cExpansion,$sideNav,$extraNav,$bread,$footer);
//$outcPage = $cPage->out();

/**
 * Wrapper
 */
Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
Isp_Loader::loadVistaObj("Snippets","Meta","Doctype");
$wrap = new cWrapper(new Doctype(),$cHead,$header,$cPage,$currentColor);
$wrap->out("echo");

?>