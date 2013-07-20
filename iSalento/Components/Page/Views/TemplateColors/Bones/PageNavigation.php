<?
Isp_Loader::loadVistaObj("Snippets","Navigation","SideListNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","SideGeneralNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","cSideNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");
Isp_Loader::loadVistaObj("Snippets","PageElements","cLogin");

Isp_Loader::loadClass('Isp_View_Bones');

class PageNavigation extends Isp_View_Bones {
	// Navigation snippets
	public $sideNav;
	public $extraNav;
	public $bread;
	public $footer;

	private $_urls;
	private $breadUrls;
	private $loginUrls;
	private $currentTab;
	private $errorMsg;
	public $breadSymbol = ">";
	public $footerSymbol = "|";

	// Dictionary temporary
	public $txt = array(	"loginButton" => "Accedi",
					"ciao" => "Bentornato ",
					"user" => "User",
					"pass" => "Pass");

// mettere extra level direttamente nella funzione pubblica che la usedrˆ
	public function __construct(	NavigationUrls $_urls,
											$breadUrls = null,
											$currentTab,
											$loginUrls = null,
											$errorMsg = null){

		$this->_urls = $_urls;
		$this->breadUrls = $breadUrls;
		$this->loginUrls = $loginUrls;
		$this->currentTab = $currentTab;
		$this->errorMsg = $errorMsg;

		// SIDE NAVIGATION
		// Left Navigation
		$sxNav1 = $this->getUpperSxNav(); // first bar
		$sxNavOther = $this->getSequentialSxNav(); // all others
		$sxNavArray = array_merge(array($sxNav1), $sxNavOther);
		$this->sideNav = new cSideNav($sxNavArray);

		// TEST LOGIN
		$loginTxt = array();
		// If user is logged show the logout form
		if(isset($this->loginUrls[1])){
			/*
			// urlLogout
			array_push(	$loginTxt,
							$this->txt['ciao'].$_SESSION['user']->username_utente."!");
			Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
			array_push($loginTxt, new Href($this->loginUrls[1]));
			*/
			$loginSnippet = new cLogin(	false, $_SESSION['user']->username_utente,
												null,
												$this->loginUrls[1],
												$this->txt["ciao"], null);
		}else{

			$loginSnippet = new cLogin(	true, null,
												$this->loginUrls[0], null,
												null, $this->errorMsg[0]);

			/* login form
			$loginTxt[0] = "<form method=\"post\" action=\""
								.$this->loginUrls[0]->path."\">";

			// Username
			Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");
			$loginTxt[1] =	new Input(	"text", $this->txt['user'],
												"username_utente", false, null, 18);
			$loginTxt[2] = "<br />";

			// Password
			$loginTxt[3] =	new Input(	"password", $this->txt['pass'],
												"crypted_password_utente", false, null, 18);
			$loginTxt[4] = "<br />";
			$loginTxt[5] =  new Input("checkbox", "Ricordami", "rememeber",true);
			$loginTxt[6] = "<br />";
			// Submit
			$loginTxt[7] =  new Input("submit", null, "nuddu", false, "login");
			// Close form
			$loginTxt[8] = "</form>";

			$loginTxt[9] = $this->errore."<br />";
			$loginTxt[10] = new Href(new Isp_Url("", "> recupera pw"));
			$loginTxt[11] = new Href(new Isp_Url("", "> registrati"));
			*/

		}
		
		$testoBarraDx[0] = "<br />";
		$testoBarraDx[1] = new Href(new Isp_Url_Page("REGISTRATI QUI!","Form","FormReg"));
		$testoBarraDx[2] = "<br />";
		
		// RIGHT NAVIGATION
		//$dxNav = new SideListNav($sxNavOther[1], $this->_urls->colors[5]);
		/*$dxNav = new SideGeneralNav(	new Isp_Url("Login test","LOGIN"),
												"grigio", $loginSnippet);*/
		
		
		$dxNav = new SideGeneralNav(new Isp_Url_Page("START","Form","FormReg"),
									"grigio",
									$testoBarraDx);
		//$this->extraNav = new cSideNav(array($sxNavArray[3]), "extra");
		$this->extraNav = new cSideNav(array( $dxNav), "extra");

		// LINE NAVIGATION
		// Breadcrumb
		$this->bread = new LineNav($this->breadUrls, $this->breadSymbol);

		// FOOTER
		$footerUrls = $this->_urls->topTabUrlsLower;
		// If user is logged show the logout form
		if(isset($this->loginUrls[1])){
			array_push(	$footerUrls,
						new Isp_Url($this->loginUrls[1]->path,
									"Logout [".$_SESSION['user']->username_utente."]"
									));
		}else{
			array_push(	$footerUrls,
						new Isp_Url_Page("Login", "Form", "FormLogin"));
		}
		$this->footer = new LineNav($footerUrls, $this->footerSymbol, "footer");
	}

	/**
	 * Calcola la prima barra in alto a sinistra. Di default  uguale alla
	 * main tab
	 *
	 * @return null se non la trova, oppure una SideListNav
	 */
	public function getUpperSxNav(){
		$sxNav = null;
		// First left side bar (se esiste e non  la home page)
		if(isset($this->_urls->subUrls[$this->currentTab]) and $this->currentTab != 0){
			$sxUrl1 = array($this->_urls->topTabUrls[$this->currentTab]);	 // Main Tab
			$sxUrl1 = array_merge($sxUrl1, $this->_urls->subUrls[$this->currentTab]); // Subs
			$sxNav =  new SideListNav($sxUrl1, $this->_urls->colors[$this->currentTab]);
		}

		return $sxNav;

	}

	/**
	 * Ritorna l'array di sidelist laterali in ordine di apparizione
	 * sulla top nav, escludendo la side list corrente.
	 *
	 * @return array di snippets sidelist nav
	 */
	public function getSequentialSxNav(){
		// Altre barre
		$topUrlsCopy = $this->_urls->topTabUrls;
		$subUrlsCopy = $this->_urls->subUrls;
		unset($topUrlsCopy[$this->currentTab]); // Tolgo la barra giˆ usata
		unset($subUrlsCopy[$this->currentTab]); // Tolgo la sottobarra giˆ usata

		// Tolgo la home
		unset($topUrlsCopy[0]);
		unset($subUrlsCopy[0]);

		$sxNavArray = array();
		// Per tutte le altre tab che contengono una sottobarra
		for($i=0; $i<=sizeof($subUrlsCopy); $i++){
			if(isset($subUrlsCopy[$i])){ // Se esiste una sottobarra
				$sxUrl = array($topUrlsCopy[$i]); // Main tab
				$sxUrl = array_merge($sxUrl, $subUrlsCopy[$i]); // Subs
				$sxNav = new SideListNav($sxUrl, $this->_urls->colors[$i]);
				array_push($sxNavArray, $sxNav);
			}
		}
		return $sxNavArray;
	}


}

?>