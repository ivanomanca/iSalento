<?
Isp_Loader::loadClass('Isp_View_Page');

class AllSnippets extends Isp_View_Page{
	public $currentColor = "verde";
	
	
	public function skeleton(){
		Isp_Loader::loadClass('Isp_Url');
		Isp_Loader::loadClass('Isp_Url_Photo');
		
		
		// -----HEADER----- //
		$urls = array(new Isp_Url("/sub1/carlo","ciao"),
					new Isp_Url("/sub2/","subTwo"),
					new Isp_Url("/sub3/","suThree"));
		$urlPhoto = new Isp_Url_Photo(1,"300x400","villa","alt");
		$urlTitle = new Isp_Url($urlPhoto->path,"Questo il mio articolo");
		$readAllUrl = new Isp_Url($urlPhoto->path,"leggi tutto..");
		$abstract = "Il festival &egrave promosso ed organizzato da Regione Puglia,";
		$abstract .= "Provincia di Lecce, Unione dei Comuni della Grecia Salentina e ";
		$abstract .= "Istituto Diego Carpitella in collaborazione con Camera di Commercio";
		
		Isp_Loader::loadVistaObj("Snippets","Navigation","SubNav");
		$subNav1 = new SubNav($urls);
		$subNav2 = new SubNav($urls);
		$subNav3 = new SubNav($urls);
		
		Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNavTab");
		$navTab1 = new cTopNavTab("giallo",new Isp_Url("/link1/","TAB1"),$subNav1);
		$navTab2 = new cTopNavTab("verde",new Isp_Url("/link2/","TAB2"),$subNav2);
		$navTab3 = new cTopNavTab("blu",new Isp_Url("/link2/","TAB2"),$subNav3);
		$tabs = array($navTab1,$navTab2,$navTab3);
		
		Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNav");
		$topNav = new cTopNav($tabs,$this->currentColor);
		
		// TESTATA
		Isp_Loader::loadVistaObj("Snippets","Layout","Testata");
		$testata = new Testata();
		
		// HEADER
		Isp_Loader::loadVistaObj("Snippets","Layout","cHeader");
		$header = new cHeader($topNav,$testata);
		
		// -----PAGE NAVIGATION----- //
		// SIDE BAR
		Isp_Loader::loadVistaObj("Snippets","Navigation","cSideNav");
		Isp_Loader::loadVistaObj("Snippets","Navigation","SideListNav");
		$sxNav1 =  new SideListNav($urls,"verde");
		$sxNav2 =  new SideListNav($urls,"giallo");								
		// Left
		$sideNav = new cSideNav(array($sxNav1,$sxNav2));
		// Right
		$extraNav = new cSideNav(array($sxNav1,$sxNav2),"extra");

		// LINE NAVIGATION
		// Breadcrumb
		Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");
		$bread = new LineNav($urls,">");
		// Footer
		$footer = new LineNav($urls,"|","footer");
		
		// -----GENERAL PURPOSE HTML----- //
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
		
		// -----CENTRAL PAGE----- //
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$titDescr = new TitleDescription("Titolo!!!","Breve descrizione della pagina..");
		
		// IN BOX ITEMS
		Isp_Loader::loadVistaObj("Snippets","PageElements","PicTitleAbstract");
		$inBoxItems = new PicTitleAbstract($urlPhoto,$urlTitle,$abstract,$readAllUrl,100);
		// LIST SEPARATOR
		Isp_Loader::loadVistaObj("Snippets","List","Separator");
		$listSep = new Separator($urlTitle,$readAllUrl);
		// LIST ITEM
		Isp_Loader::loadVistaObj("Snippets","List","cListItem");
		$listItem = new cListItem($listSep,$inBoxItems);

		// LIST
		Isp_Loader::loadVistaObj("Snippets","List","cList");
		$list = new cList(array($listItem,$listItem,$listItem));
		
		// CASE BOX
		Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
		$caseBlock0 = new cCaseBlock("Prova",null,"Testo interno!!",$this->currentColor);
		$caseBlock01 = new cCaseBlock("PicTitleAbst", null, $inBoxItems, $this->currentColor);
		
		
		// SEARCH FILTER
		Isp_Loader::loadVistaObj("Snippets","PageElements","SearchFilter");
		$searchFilter = new SearchFilter("Ricerca singola","Ordina per: ",$select);
		$caseBlock1 = new cCaseBlock($searchFilter->titleHeader,
									$searchFilter->classHeader,
									$searchFilter,$this->currentColor);
									
		// AT A GLANCE
		Isp_Loader::loadVistaObj("Snippets","PageElements","AtAGlance");
		$atAGlance = new AtAGlance("A colpo occhio",$urls);
		$caseBlock2 = new cCaseBlock($atAGlance->titleHeader,null,$atAGlance,$this->currentColor);
					
		// FOUR PHOTOS
		Isp_Loader::loadVistaObj("Snippets","PageElements","FourPhotos");
		$array4foto = array($urlPhoto, $urlPhoto, $urlPhoto, $urlPhoto);
		$four = new FourPhotos("Blocchetto 4 foto..",$array4foto,$readAllUrl);
		$caseBlock3 = new cCaseBlock("4 foto!",null,$four,$this->currentColor);
		
		
		// MULTIPLE LINKS ITEM
		Isp_Loader::loadVistaObj("Snippets","PageElements","MultipleLinksItem");
		$picUrl = new Isp_Url_Photo(2,"small","baia Gallipoli","baia alt");
		$multipleItem = new MultipleLinksItem($urlTitle,$picUrl,"Descrizione bloccheto foto..");
		$multipleItem1 = new MultipleLinksItem($urlTitle,$picUrl,"Descr 1..");
		$multipleItem2 = new MultipleLinksItem($urlTitle,$picUrl,"Descrizione bloccheto foto2..");
		$multipleItem3 = new MultipleLinksItem($urlTitle,$picUrl,"Descrizione bloccheto foto3..");
		// cMULTIPLE LINKS
		Isp_Loader::loadVistaObj("Snippets","PageElements","cMultipleLinks");
		$mLinksArray = array($multipleItem,$multipleItem1,$multipleItem2,$multipleItem3);
		$cMultiple = new cMultipleLinks($mLinksArray);
		$caseBlock4 = new cCaseBlock("BLOCCHETTI!",null,$cMultiple,$this->currentColor);

		// ARTICLE EXPANSION
		Isp_Loader::loadVistaObj("Snippets","Card","ArticleExpansion");
		$text = "Questa e con l'accento una prova per il testo del paragrafo<br><br>";
		$expansion1 = new ArticleExpansion($text, null, true);
		$expansion2 = new ArticleExpansion($text, $urlTitle);
		$expansion3 = new ArticleExpansion($text, $urlTitle);
		
		// cExpansion List
		Isp_Loader::loadVistaObj("Snippets","Card","cExpansionList");
		$cExpansion = new cExpansionList(array($expansion1, $expansion2, $expansion3));
		
		// SNAP snippets together
		$centralHtmlArray =  array($titDescr,
									$list,
									$caseBlock0,
									$caseBlock01,
									$caseBlock1,
									$caseBlock2,
									$caseBlock3,
									$caseBlock4,
									$cExpansion);

										
		// CENTRAL PAGE
		Isp_Loader::loadVistaObj("Snippets","Layout","cCentralPage");
		$cPage = new cCentralPage($centralHtmlArray,$sideNav,$extraNav,$bread,$footer);
		
		// HEAD
		Isp_Loader::loadVistaObj("Snippets","Meta","cHead");
		Isp_Loader::loadVistaObj("Snippets","Meta","Meta");
		$cHead = new cHead(new Meta("Snippets!"));
		
		// WRAPPER
		Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
		Isp_Loader::loadVistaObj("Snippets","Meta","Doctype");
		$wrap = new cWrapper(new Doctype(),$cHead,$header,$cPage,$this->currentColor);

		$body['wrap'] = $wrap->out();
		return $body;
	}
}

?>
