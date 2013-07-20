<?
Isp_Loader::loadClass("Isp_Controller_Action");

/**
 * General error controller (default)
 *
 */
class Error extends Isp_Controller_Action{
	private $lang = null;
	private $errArray = null;
	private $failedReq = null;

	/**
	 * Gestisce gli errori provenienti dal modulo Crud
	 *@todo implementare gli snippets per la visualizzazione degli errori
	 */
	public function crudError(){
		$this->setLang();
		$this->getErrorInfo();

		foreach ($this->errArray as $ObjError){
			if (in_array($ObjError->errType, array(
					ErrorType::OBJ_NOT_CREATED,
					ErrorType::OBJ_NOT_DELETED,
					ErrorType::OBJ_NOT_FOUND,
					ErrorType::OBJ_NOT_INSERTED,
					ErrorType::OBJ_NOT_LISTED,
					ErrorType::OBJ_NOT_LOADED,
					ErrorType::OBJ_NOT_RETRIEVED,
					ErrorType::OBJ_NOT_UPDATED
				))) {
				// log error
				$logString =	"<br />".$ObjError->errType
									."<br />".$ObjError->errCode
									."<br />".$ObjError->errNote
									."<br />";
				//usare qui la funzione per il log su file!
				// release response
				$this->appendError2Response(	ErrorType::OBJ_NOT_CREATED,
														'crudError');
			}else{

			}
		}
	}

	/**
	 * Gestisce gli errori provenienti dal modulo Authentication
	 *@todo implementare gli snippets per la visualizzazione degli errori
	 */
	public function authError(){
		$this->setLang();
		$this->getErrorInfo();

		$ErrorMsgArray = array();
		foreach ($this->errArray as $ObjError){
			array_push($ErrorMsgArray, $ObjError->errType);
		}
		// to--> FormLogin
		if($ErrorMsgArray != array() && $ErrorMsgArray[0] < 10){
			$this->sendErrors2Page(	$ErrorMsgArray,
											array('pageType' => 'Form',
													'page' => 'FormLogin'));
		}
		// to--> FormReg
		elseif(	$ErrorMsgArray != array() &&
					59 < $ErrorMsgArray[0] &&
					$ErrorMsgArray[0] < 71){
			$this->sendErrors2Page(	$ErrorMsgArray,
											array('pageType' => 'Form',
													'page' => 'FormReg'));
		}
		// to--> FormChPW
		elseif(	$ErrorMsgArray != array() &&
					70 < $ErrorMsgArray[0] &&
					$ErrorMsgArray[0] < 80){
			$this->sendErrors2Page(	$ErrorMsgArray,
											array('pageType' => 'Form',
													'page' => 'FormChPW'));
		}
		// to--> RegNotify
		elseif(	$ErrorMsgArray != array() &&
					79 < $ErrorMsgArray[0] &&
					$ErrorMsgArray[0] < 90){
			$this->sendErrors2Page(	$ErrorMsgArray,
											array('pageType' => 'Extra',
													'page' => 'RegNotify'));
		}else{
			// errore destinato ad un altro task tipo page Error.
		}
	}

	/**
	 * Gestisce gli errori di visualizzazione delle pagine
	 *
	 */
	public function pageError(){
		$this->setLang();
		$this->getErrorInfo();

		$ErrorMsgArray = array();
		foreach ($this->errArray as $ObjError){
			array_push($ErrorMsgArray, $ObjError->errType);
		}
		// to--> ExtraHome
		if(	$ErrorMsgArray != array() &&
				49 < $ErrorMsgArray[0] &&
				$ErrorMsgArray[0] < 60){
			$this->sendErrors2Page(	$ErrorMsgArray,
											array('pageType' => 'Extra',
													'page' => 'ExtraHome'));
		}

/*
		$this->setLang();
		$this->getErrorInfo();

		foreach ($this->errArray as $ObjError){
			if($ObjError->errType == ErrorType::PAGE_DENIED) {
				$this->sendErrors2Page(	ErrorType::PAGE_DENIED,
												array('pageType' => 'Extra',
														'page' => 'ExtraHome'));

			}elseif($ObjError->errType == ErrorType::PAGE_NOT_FOUND) {
				$this->sendErrors2Page(	ErrorType::PAGE_NOT_FOUND,
												array('pageType' => 'Extra',
														'page' => 'ExtraHome'));
			}
		}
*/
	}

/******************************************************************************
	UTILITY
******************************************************************************/
	/**
	 * Set the current language
	 *
	 */
	private function setLang(){
		require_once(	$_SERVER['DOCUMENT_ROOT']
					.'Components/Page/Controllers/Page.php');
		// Sets language from session, browser, ecc.
		if(isset($_SESSION['lang'])){
			$this->lang = $_SESSION['lang'];
		}else{ // default
			$this->lang = 'it';
		}
	}
	/**
	 * Gets error info
	 *
	 */
	private function getErrorInfo(){
		require_once(	$_SERVER['DOCUMENT_ROOT']
							.'Components/Error/Models/ErrorString.php');
		// qualsiasi info sull'errore  contenuta all'interno di:
		$this->failedReq = $this->front->request->params['failedReq'];
		$this->errArray = $this->front->request->params['errArray'];
	}
	/**
	 * Sends the error message to a page.
	 *
	 * @param ErrorString $errorMsg
	 * @param array $page
	 */
	private function sendErrors2Page($errorMsgs, $page){
		$this->front->request->params['errorMsg'] = array();
		foreach ($errorMsgs as $errorMsg){
			array_push(	$this->front->request->params['errorMsg'],
							ErrorString::$Out	[$this->lang][$errorMsg]."<br/>");
		}
		$this->forward('getPage', 'Page', null, $page);
	}
	/**
	 * Appends a error message into response object
	 *
	 * @param ErrorString $errorMsg
	 * @param Type $typeError i.e. 'crudError'
	 */
	private function appendError2Response($errorMsg, $typeError){
		$this->front->response->append(
			$typeError,
			ErrorString::$Out	[$this->lang]
									[ErrorType::OBJ_NOT_CREATED]."<br />");

	}

	public function test(){
		print_r($_GET);
	}
}
?>
