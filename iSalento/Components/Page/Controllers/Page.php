<?
Isp_Loader::loadClass("Isp_Controller_Action_Instantiator");

/**
 * Page router and defauld page controller: spot the
 * appropriate and most specific available page and
 * corrensponding ctrl. Then route to it.
 * If no specific controller is found, the default one is
 * instantiated.
 */
class Page extends Isp_Controller_Action_Instantiator {
	// Oggetto pagina
	public $page = null;
	// Info di pagina per costruire l'Isp_Url_Page
	public $pageType = null;
	public $pageName = null;
	public $completePageName = null; // Nome di pagina + parametri
	public $paramsArray = array();
//public $pageLabel = null; // Nome pagina for human reading
//public $pageDescription = null; // Descrizione pagina for human reading

	// Impostazioni
	private $langDefault = "it";
	private $privilegiDefault = 5;
	public $linkLogin = "index.php?component=Authenticate&task=login";
	public $linkLogout = "index.php?component=Authenticate&task=logout";

	/**
	 * @todo Aggiungere controllo setPage se non trova la pagina
	 * conforward a modulo errore.
	 *
	 */
	public function getPage(){
		// includo la classe per l'errore
		if(!class_exists("Isp_Db_ObjError")){
			require(	$_SERVER['DOCUMENT_ROOT'].
						"Library/Isp/Db/ObjError.php");
		}
		// Istanzia l'oggetto pagina pi appropriato
		$this->setPage();
		// setta permessi e lingua
		$this->setPermissionAndLang();

		// se la pagina richiede un privilegio minimo
		// ed eventualmente  posseduto dall'utente
		if (	is_null($this->page->privilegioMin) ||
				(isset($this->page->privilegioMin) &&
				$this->page->privilegioMin >= $this->page->privilegi)) {
			// Dynamic Data
			$this->setDynamicData();
			// Fa il fill di tutti i parametri necessari
			$this->configurePage();
			// Se presente un controllore di pagina specifico (ingressi pagina)
			$this->findPageCtrl();

			$this->finalizeConfig();
			// Render html code
			$this->renderView($this->page);
		}else{
			// pagina negata all'utente
			$this->forward('pageError',
								'Error',
								'Error',
								array('failedReq' => $this->front->request,
										'errArray' => array(
										new Isp_Db_ObjError(ErrorType::PAGE_DENIED))));
		}

	}

	/**
	 * Calcola il percorso dell'oggetto pagina da istanziare sulla base
	 * della pagina e dei parametri passati nella risorsa link/post.
	 * Include la pagina e la istanzia mettendola nello stato dell'oggetto.
	 *
	 * CONVENZIONI:
	 * ¥	L'ordine dei parametri sul nome della pagina segue quello degli
	 * 		stessi parametri nella risorsa link (quindi in $_GET).
	 * 		Es. Lista_articolo_categoria_localita corrisponde a
	 * 		file.php?categoria=1&localita=2 e non file.php?localita=2&categoria=1
	 * ¥	La risorsa link per il metodo get page  sempre fatta come:
	 * 		file.php?component=x&task=y&page=z&pageType&parametri
	 *
	 * @return false se la pagina non  stata trovata, include e istanzia la pagina
	 * ponendola in sessione in caso contrario.
	 */
	 public function setPage(){

	 	// Base page name requested
		$pageName = $this->front->request->params['page'];
		// Converte in maiuscolo la prima lettera (convenzione)
		$pageName = ucfirst($pageName);
		// Copio il nome statico
		$originalPageName = $pageName;

		// Page type
		$pageType = $this->front->request->params['pageType'];
		$pageType = ucfirst($pageType);

	 	/**
	 	 * Esegue la verifica dell'esistenza pagina + specifica
	 	 */
		$filePath = Isp_Loader::buildVistaPath("Pages", $pageType, $pageName,
															"Page", "TemplateColors",
															$pageName );
		$constantPageName = $pageName.".php";
		//$baseFolder = rtrim($filePath, $pageName."/".$constantPageName);
		$baseFolder = Isp_Loader::buildVistaPath("Pages", $pageType);
		//if(file_exists($baseFolder.$constantPageName)){
		if(file_exists($filePath)){
			$truePath = $filePath;
			$trueName = $pageName;
		}else{
			$this->forward('pageError', 'Error', 'Error',
								array('failedReq' => $this->front->request,
										'errArray' => array(
											new Isp_Db_ObjError(
												ErrorType::PAGE_NOT_FOUND))));
			// Exit
			return false;
		}

	 	if(!empty($this->front->request->userParams)){

	 		// Calcola pagine pi specifiche
			// Aggiunge i parametri al nome base della pagina
		 	foreach ($this->front->request->userParams as $param => $value){
				// Aggiunge il formato "-categoria"
				//$filePath .= "-$param";
				$pageName .= "+$param";

				// Verifica l'esistenza del file
				if(file_exists($baseFolder.$pageName."/".$constantPageName)){
					// Tiene in memoria l'ultimo file certo esistente
					//$truePath = $filePath.".php";
					$trueName = $pageName;
					//$filePath .= "-$value";
					$pageName .= "+$value";

					// Verifica l'esistenza del file
					if(file_exists($baseFolder.$pageName."/".$constantPageName)){
						//$truePath  = $filePath.".php";
						$trueName  = $pageName;
					}
				// Prova con il valore insieme
				} elseif(file_exists($baseFolder.$pageName
											."+$value"."/".$constantPageName)){
					$pageName = $pageName."+$value";
					$trueName  = $pageName;

				}else{// Se non esiste togli il parametro e riprova con il successivo
						$pageName = rtrim($pageName, $param);
						$pageName = rtrim($pageName,"+");
					//$filePath = rtrim($filePath,"$param");
					//$filePath = rtrim($filePath,"-");// bug!!
				}
		 	}//foreach
	 	}
	 	// Istanzia la pagina
	 	Isp_Loader::loadVistaObj(	"Pages", $pageType, $originalPageName,
			 								"Page", "TemplateColors", $trueName);
		//$this->page = new $trueName();
		$this->page = new $originalPageName();

		// Store into object state
		$this->pageType = $pageType;
		$this->pageName = $originalPageName;
		$this->completePageName = $pageName;
		//$this->pageType = $this->front->request->params['pageType'];
		//$this->pageName = $this->front->request->params['page'];
		$this->paramsArray = $this->front->request->userParams;

	}
	/**
	 * Esegue il settaggio di alcune variabili di stato della pagina
	 *
	 */
	public function configurePage(){

		//$this->page->thisPageUrl = new Isp_View_Page();

		// Configurazione (urls e colori)
		//Isp_Loader::loadVistaObj("Bones", null, "NavigationUrls");
		require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Models/NavigationUrls.php");
		$_urls = new NavigationUrls($this->page->lang, $this->page->privilegi);
		$this->page->_urls = $_urls;

		// Breadcrumbs
		$this->page->breadUrls = $this->computeBreadUrls($_urls);
		// Setta l'url corrente (! le schede fanno l'overwrite!)
	 	$this->page->thisPageUrl = end($this->page->breadUrls);

	}
	/**
	 * setta lingua e permessi
	 *
	 */
	public function setPermissionAndLang(){
		// Sets user privileges
		if(isset($_SESSION['user']->privilegi_utente)){
			$this->page->privilegi = $_SESSION['user']->privilegi_utente;
		}else{ // default
			$this->page->privilegi = $this->privilegiDefault;
		}
		// Sets language from session, browser, ecc.
		if(isset($_SESSION['lang'])){
			$this->page->lang = $_SESSION['lang'];
		}else{ // default
			$this->page->lang = $this->langDefault;
		}

		// Inform the page too!
		$this->page->pageType = $this->pageType;
		$this->page->page = $this->pageName;
		$this->page->paramsArray = $this->paramsArray;
		if(isset($this->front->request->params['errorMsg'])){
			$this->page->errorMsg = $this->front->request->params['errorMsg'];
		}

		// Dictionary
		$this->page->txt = $this->page->dictionary[$this->page->lang];
	}

	/**
	  * Compute breadcrumb path.
	  *
	  * @return array containing Isp_Url for breadcrumb
	  */
	private function computeBreadUrls($_urls){

	 	Isp_Loader::loadClass('Isp_Url_Page');
	 	// First element, constant: home page
		$breadUrls = array($_urls->topTabUrlsLower[0]);
		//$pageLabel = $_urls->topTabUrlsLower[0]->title;
		//$pageDescription = $_urls->topTabUrlsLower[0]->description;

		// Second element calculated from currentTab, if not home
		if(!($this->page->currentTab == 0) and
			($this->page->currentTab <= sizeof($_urls->topTabUrlsLower))){

			array_push(	$breadUrls,
							$_urls->topTabUrlsLower[$this->page->currentTab]);
			//$pageLabel = $_urls->topTabUrlsLower[$this->page->currentTab]->title;
			//$pageDescription = $_urls
			//		->topTabUrlsLower[$this->page->currentTab]->description;

		}
		// Third element: liste definite nella mappa
		if(isset($_urls->subUrls[$this->page->currentTab])){
			// If current tab has sub bar
			foreach ($_urls->subUrls[$this->page->currentTab] as $urlPage){
				// Locate
				if($urlPage->pageType == $this->pageType &&
					$urlPage->page == $this->pageName &&
					$urlPage->paramsArray == $this->paramsArray){

						array_push($breadUrls, $urlPage);
						$thirdPresent = true;
					//$pageLabel = $urlPage->title;
					//$pageDescription = $urlPage->description;
				}//else {
					// Prova con i criteri!!
				//}
			}
		}//elseif (/*Retrieve from Session*/) !! To do

		// Patch breadcrumb: elementi non definiti nella configurazione
		// (criteri filtro liste)
		//if(!isset($thirdPresent)){
		//}
		return $breadUrls;
	 }

	 /**
	  * Esegue le operazioni che vanno fatte alla fine di tutto.
	  * Funziona pi che altro per caricare il link di scheda,
	  * definito nella pagina stessa.
	  *
	  */
	 private function finalizeConfig(){
	 	// Setta l'url corrente di pagina se definito
		$currentLevelUrl = $this->page->setThisPageUrl();
	 	if(!is_null($currentLevelUrl)){
	 		$this->page->thisPageUrl = $this->page->setThisPageUrl();
	 		array_push($this->page->breadUrls, $this->page->thisPageUrl);
	 	}
	 	// LOGIN/LOGOUT
		if(!isset($_SESSION['user'])){
			// If not already logged in
			$this->page->urlLogin = new Isp_Url($this->linkLogin, "Login");
		}else{
			$this->page->urlLogout = new Isp_Url($this->linkLogout, "Logout");
		}

	 	// Setta l'url corrente
	 //	$this->page->thisPageUrl = end($this->page->breadUrls);
	 }
	/**
	 * Checks a specific page controller is available for the most
	 * specific available page just calculated.
	 *
	 * @return boolean and forward to the specific controller
	 */
	public function findPageCtrl(){

	 	// Controlla se esiste il controllore di pagina
	 	$ctrlPath = $_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/";
	 	$ctrlName = "Ctrl_".$this->pageType."_".$this->pageName;

	 	$ctrlFolderParams = 	"Ctrl_".$this->pageType
	 								."_".$this->completePageName."/";
	 	$ctrlFolderPage = "Ctrl_".$this->pageType."_".$this->pageName."/";
	 	$ctrlFolderGeneral = "Ctrl_".$this->pageType;
	 	//$ctrlLink = $ctrlPath.$ctrlName.".php";

	 	// Nome Pagina + params
	 	$ctrlLinkParams = $ctrlPath.$ctrlFolderParams.$ctrlName.".php";
	 	// Nome pagina
	 	$ctrlLinkPage = $ctrlPath.$ctrlFolderPage.$ctrlName.".php";
	 	// Solo tipo pagina
	 	$ctrlLinkGeneral =	$ctrlPath.$ctrlFolderGeneral
	 								."/".$ctrlFolderGeneral.".php";

	 	// @todo ottimizza, questa  una funzione esterna!!
	 	// TRova i controllori con i nomi di pagina parametrici
	 	if(!empty($this->front->request->userParams)){
	 		// Viene aggiornato con i parametri ed  la folder
			$pageName = $ctrlName;
			$baseFolder = $ctrlPath;
			// Nome del ctrl nella cartella
			$constantPageName = $ctrlName.".php";
			$trueName = $ctrlFolderParams;
	 		// Calcola pagine pi specifiche
			// Aggiunge i parametri al nome base della pagina
		 	foreach ($this->front->request->userParams as $param => $value){
				// Aggiunge il formato "-categoria"
				//$filePath .= "-$param";
				$pageName .= "+$param";

				// Verifica l'esistenza del file
				if(file_exists($baseFolder.$pageName."/".$constantPageName)){
					// Tiene in memoria l'ultimo file certo esistente
					//$truePath = $filePath.".php";
					$trueName = $pageName;
					//$filePath .= "-$value";
					$pageName .= "+$value";

					// Verifica l'esistenza del file
					if(file_exists($baseFolder.$pageName."/".$constantPageName)){
						//$truePath  = $filePath.".php";
						$trueName  = $pageName;
					}
				// Prova con il valore insieme
				} elseif(file_exists($baseFolder.$pageName
											."+$value"."/".$constantPageName)){
					$pageName = $pageName."+$value";
					$trueName  = $pageName;

				}else{
					// Se non esiste togli il parametro e riprova con il successivo
					$pageName = rtrim($pageName, $param);
					$pageName = rtrim($pageName,"+");
					//$filePath = rtrim($filePath,"$param");
					//$filePath = rtrim($filePath,"-");// bug!!
				}
				$ctrlLinkParams = $baseFolder.$trueName."/".$constantPageName;
		 	}//foreach
	 	}

	 	if(file_exists($ctrlLinkParams)){// Folder con params
	 		require_once($ctrlLinkParams);
	 		$ctrl = new $ctrlName();
	 		// Any specific modification to the page
	 		$this->page = $ctrl->init($this->page);

	 		return true;
	 	}elseif(file_exists($ctrlLinkPage)){
	 		// Folder con solo nome pagina
	 		require_once($ctrlLinkPage);
	 		$ctrl = new $ctrlName();
	 		// Any specific modification to the page
	 		$this->page = $ctrl->init($this->page);

	 	// Try a more general Ctrl
	 	}else{
	 		// Folder con solo tipo pagina
	 		$ctrlName = "Ctrl_".$this->pageType;
		 	//$ctrlLink = $ctrlPath.$ctrlName.".php";
		 	if(file_exists($ctrlLinkGeneral)){
	 			require_once($ctrlLinkGeneral);
	 			$ctrl = new $ctrlName();
	 			// Any specific modification to the page
	 			$this->page = $ctrl->init($this->page);
		 		return true;
		 	}
	 	}

	 	return false; // Se non lo trova

	}

	/**
	 * Risolve e setta eventuali dati dinamici richiesti dalla pagina
	 */
	private function setDynamicData(){
		$ingredients = $this->page->getIngredients();
		// Se ci sono ingredienti da ricavare
		if(!is_null($ingredients)){
       		$this->populatePage($ingredients);
       		// Related
       		$relatedIngredients = $this->page->getRelatedIngredients();
       		if(!is_null($relatedIngredients)){
       			$this->populatePage($relatedIngredients);
       		}
		}
	}

	/**
	 * Esegue il retrieve del beaner e carica gli oggetti nella pagina
	 *
	 * @param array $data, l'array di ingredienti
	 */
	private function populatePage($ingredients){
		foreach ($ingredients as $key => $params) {
			$firstchar = $key[0];
			if (!($firstchar == '*')) {
				// Istanzia il beaner
				if($this->instantiate("Isp_Db_Beaner")){
			        $Beaner = $this->instancedObj;
					// Riempie i beans-oggetti della pagina
			        	if(isset($params[1])){
				        	// Se i parametri non sono un array
				        	if ($params[1]=="userParams"){
				        		// Prendi i dati dalla request
				        		$params[1] = $this->front->request->$params[1];
				        	}
				        	if(!isset($params[2])){
				        		$params[2] = null;
				        	}
			        	}else{
			        		$params[1] = null;
			        		$params[2] = null;
			        	}
			        	// Ricavo il bean: interrogo il Db
			        	$this->page->$key = $Beaner->retrieve(	$params[0],
																        	$params[1],
																        	$params[2]);
				 }

			}else{// usa il simpleenquirer
				$key = ltrim($key, '*');
				if($this->instantiate("Isp_Db_SimpleEnquirer")){
			        $Enquirer = $this->instancedObj;
		        	if(!isset($params[1])){
		        		$params[1] = null;
		        	}
		        	if(!isset($params[2])){
		        		$params[2] = null;
		        	}
		        	if(!isset($params[3])){
		        		$params[3] = null;
		        	}
		        	if(!isset($params[4])){
		        		$params[4] = null;
		        	}
					$this->page->$key = $Enquirer->getList(	$params[0],
															$params[1],
															$params[2],
															$params[3],
															$params[4]);
				}
			}
		}
	}
}
?>
