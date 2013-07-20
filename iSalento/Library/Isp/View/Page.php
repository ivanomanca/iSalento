<?php
/** Isp_Url Object */
require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Url.php");

/**
 * The father of all the pages. It has to be extended.
 * It contains all the features all the views have in common.
 *
 * The state may include dynamic data, related dynamic data
 * (data retrieved using params of other objects in the page
 * state), static content (string).
 *
 * The simplest page should at least contain the skeleton()
 * method.
 */
abstract class Isp_View_Page{

	// Isp_Url_Page info (filled from a ctrl)
	public $page = null;
	public $pageType = null;
	public $paramsArray = array();
	//public $pageLabel = null; // Nome pagina for human reading
	//public $pageDescription = null; // Descrizione pagina for human reading

	// Urls
	public $thisPageUrl; // Url della pagina corrente
	public $breadUrls; // Array di Url breadcrumb
	public $_urls; // urls e colori

	// Uscite
	//public $code = null; // Html code producted in the page
	public $snpArray = array(); // Array degli snippets

	// Parametri di gestione della pagina
	public $currentTab = null; // La pagina dice a quale macrosezione appartinene
	public $privilegioMin = null; // minimo per aprire la pagina
	public $privilegi = null; // User permessi default (minimi)
	public $lang = null;

	// Dictionary
	public $dictionary = array( "it" => array( "chiave" =>"traduzione"),
								"en" => array( "chiave" =>"translation"));
	public $txt = null; // Selected array of dictionary

	// Default Meta cnt
	public $titleMeta = null;
	public $keywordsMeta = null;
	public $descriptionMeta = null;

	// Login/Logout urls
	public $urlLogin = null; // Isp_Url object
	public $urlLogout = null; // Isp_Url object
	public $errorMsg = null;

	/**
	 * Contructor
	 */
	public function __construct(){

	}

	/**
	 * Independent ingredients list. The ingredients are dynamic
	 * data such as beans or objects to be retrieved from action ctrls.
	 *
	 * Overwrite this method if the page needs dynamic data to render the
	 * html.
	 *
	 * !CONVENTION: the dynamic data request list is made of an array that
	 * has the key name like the object to istantiate and value an array
	 * with the input arguments of the 'retrieve' function of Isp_Db_Beaner.
	 * Eg,
	 * $ingredients['oStruttura'] = array("Struttura", array("id_struttura" => 16));
	 *
	 * If params needed are in the request object, just pass the string of the array
	 * to use in the request. Eg,
	 * $ingredients['oStruttura'] = array("Struttura", "userParams"); uses the
	 * $front->request->userParams array.
	 */
	public function getIngredients(){
		return null;
	}

	/**
	 * See getIngredients() method. The only difference is here
	 * you can specify the ingredient using params in the state of
	 * the object. For example using beans already retrieved.
	 *
	 * @todo If there are too many related cycles, a new design
	 * pattern has to be developed to avoid the use of other
	 * relatedIngredients functions.
	 */
	public function getRelatedIngredients(){
		return null;
	}

	/**
	 * The actual skeleton structure uses to build up
	 * the html code of the extended page. Reusable snippets
	 * HTML cab be used, but it is needed to specify the
	 * import directory in includeSnippets().
	 *
	 * !CONVENTION: the same $front->response->body structure
	 * is required, i.e. an array with named segments containing
	 * html code/text to output. Eg,
	 * $body['head'] = new cHead(new Doctype(),
	 * 							new Meta($this->oStruttura->nome_struttura,
	 * 							new LinkRel(new isp_url("/css/folder"));
	 * $body['titolo'] = $this->sTitolo;
	 *
	 * !CONVENTION: the skeleton array needs to be returned.
	 */
	public function skeleton(/*$currentTab = null, $privilegi = null, $txt = null*/){}

	/**
	 * Sviluppa il codice finale in segmenti nominati da
	 * inserire nella risposta. Il body della risposta pu˜
	 * esser manipolato a piacere in modo da cambiare la
	 * composizione della pagina dinamicamente.
	 */
	 public function render(){
	 	// Setta l'url corrente di pagina se definito
	 /*	if(!is_null($this->setThisPageUrl())){
	 		$this->thisPageUrl = $this->setThisPageUrl();
	 		array_push($this->breadUrls, $this->thisPageUrl);
	 	}

	 	// Setta l'url corrente
	 	$this->thisPageUrl = end($this->breadUrls);*/

	 	//$this->txt = $this->dictionary[$this->lang];
	 	// Carica lo skeletro
		$body = $this->skeleton();
		// L'array in formato "response" (array di segmenti html)
		return $this->snippets2Html($body);
	 }

	 public function setThisPageUrl(){
	 	return null;
	 }
	 /**
	  * Accoda la stringa html prodotta dallo snippet alla stringa
	  * stack. Attenzione! Eventuali CSS non vengono considerati.
	  *
	  * @param Isp_View_Snippet $snippet
	  * @return lo stack aggiornato con l'html dello snippet
	  */
	/* public function push(Isp_View_Snippet $snippet){
	 	$this->code .= $snippet->code;
	 } */

	 /**
	  * Accoda lo snippet all'array degli snippets. Utile soprattutto
	  * per fare il rendering nel template.
	  * Sostituisce la funzione "push" in quanto permette di considerare
	  * anche eventuali CSS degli snippets.
	  *
	  * @param Isp_View_Snippet | string | array $code - a snippet or string html code
	  * or array of Isp_View_Snippet
	  * @return null
	  */
	 public function add($code){
	 	// Array of Isp_View_Snippets
	 	if(is_array($code) && ($code[0] instanceof Isp_View_Snippet)){
	 		//$this->snpArray = $this->snpArray + $code;
	 		$this->snpArray = array_merge($this->snpArray, $code);
	 	}else{
	 		array_push($this->snpArray, $code);
	 	}
	 }

	 /**
	  * Converte un array di oggetti snippet in html
	  * mantenendo lo stesso name segment
	  *
	  * @param array $snippetsList array di oggetti snippets
	  * @param string $fuseStringSeparator - fuse snippets array in a single code string.
	  * Fused snippets can be separated by this string code (eg. "<br>")
	  * @return array di name segments in html
	  */
	 public function snippets2Html($snippetList,
	 								$fuseStringSeparator = null){
	 	if(isset($fuseStringSeparator)){$bodyHtml="";}

	 	foreach ($snippetList as $nameSegment=>$snippet){
			if(is_string($snippet)){ // Copiala giˆ come sta
				$bodyHtml[$nameSegment] = $snippet;

			}elseif($snippet instanceof Isp_View_Snippet ){
				if(isset($fuseStringSeparator)){
					$bodyHtml .= $fuseStringSeparator.$snippet->out();
				}else{
					// Stampa la stringa dall'oggetto snippet
		 			$bodyHtml[$nameSegment] = $snippet->out();
				}
			}
		}
		return $bodyHtml; // da mettere nel body della response
	 }

	 /**
	  * Usa la configurazione di Template di default
	  *
	  * @return unknown
	  */

	 public function useDefaultTemplate($noSideNav = false, $noExtraNav = false){

		Isp_Loader::loadVistaObj("Bones", null, "Template");
		$tpl = new Template(	$this->_urls->colors[$this->currentTab],
									$this->lang);

    	// HEAD
    	if(isset($this->titleMeta)){ // Se sono settati nella pagina
    		$titleMeta = $this->titleMeta;
    	}else{ // Prendi quelli standard dalla configurazione
    		$titleMeta = $this->_urls->titleMeta;
    	}
    	if(isset($this->keywordsMeta)){ // Se sono settati nella pagina
    		$keywordsMeta = $this->keywordsMeta;
    	}else{ // Prendi quelli standard dalla configurazione
    		$keywordsMeta = $this->_urls->keywordsMeta;
    	}
    	if(isset($this->descriptionMeta)){ // Se sono settati nella pagina
    		$descriptionMeta = $this->descriptionMeta;
    	}else{ // Prendi quelli standard dalla configurazione
    		$descriptionMeta = $this->_urls->descriptionMeta;
    	}
		Isp_Loader::loadVistaObj("Snippets","Meta","cHead");
		Isp_Loader::loadVistaObj("Snippets","Meta","Meta");
		$tpl->cHead = new cHead(new Meta(	$titleMeta,
											$keywordsMeta,
											$descriptionMeta));

		Isp_Loader::loadVistaObj("Bones", null, "Header");
		$header = new Header($this->_urls, $this->currentTab);
		$tpl->header = $header->header;

		Isp_Loader::loadVistaObj("Bones", null, "PageNavigation");
		$navigation = new PageNavigation(	$this->_urls,
														$this->breadUrls,
														$this->currentTab,
											array($this->urlLogin, $this->urlLogout),
											$this->errorMsg);

		if(!$noSideNav){
			$tpl->sideNav = $navigation->sideNav;
		}
		if(!$noExtraNav){
			$tpl->extraNav = $navigation->extraNav;
		}
		$tpl->bread = $navigation->bread;
		$tpl->footer = $navigation->footer;

		// Elementi di pagina centrale
		$tpl->snpArray = $this->snpArray;

		$body['wrap'] = $tpl->render();
		return $body;
	}
}