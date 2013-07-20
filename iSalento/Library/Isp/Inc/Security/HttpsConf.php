<?php
// HTTPS required
//////////////////////////		Secure Login	///////////////////////////////////
if (	// pagina del form dati
		((isset($this->request->params['pageType']) &&
		isset($this->request->params['page']) &&
		$this->request->params['pageType'] == "Form" &&
		$this->request->params['page'] == "FormLogin") ||
		// pagina di processing
		(isset($this->request->params['component']) &&
		isset($this->request->params['task']) &&
		$this->request->params['component'] == "Authenticate" &&
		$this->request->params['task'] == "login")) && !isset($_SESSION['user'])) {

	if($_SERVER['SERVER_PORT'] != 443 && !isset($_SESSION['user'])) {
		// redirect alla connessione https!
		header(	"location: https://"
		 			.$_SERVER['HTTP_HOST']
		 			."/index.php?component=Page&"
		 			."task=getPage&pageType=Form&page=FormLogin");
		exit;
	}
}
////////////////////////	Secure Registration	////////////////////////////////
else if(		// pagina del form dati
				(isset($this->request->params['pageType']) &&
				isset($this->request->params['page']) &&
				$this->request->params['pageType'] == "Form" &&
				$this->request->params['page'] == "FormReg") ||
				// pagina di processing
				(isset($this->request->params['component']) &&
				isset($this->request->params['task']) &&
				$this->request->params['component'] == "Authenticate" &&
				$this->request->params['task'] == "register")) {

	if($_SERVER['SERVER_PORT'] != 443) {
		// redirect alla connessione https!
		header(	"location: https://"
		 			.$_SERVER['HTTP_HOST']
		 			."/index.php?component=Page&"
		 			."task=getPage&pageType=Form&page=FormReg");
		exit;
	}
}
////////////////////////	Secure Chage PW	////////////////////////////////
else if(		// pagina del form dati
				(isset($this->request->params['pageType']) &&
				isset($this->request->params['page']) &&
				$this->request->params['pageType'] == "Form" &&
				$this->request->params['page'] == "FormChPW") ||
				// pagina di processing
				(isset($this->request->params['component']) &&
				isset($this->request->params['task']) &&
				$this->request->params['component'] == "Authenticate" &&
				$this->request->params['task'] == "changePW")) {

	if($_SERVER['SERVER_PORT'] != 443) {
		// redirect alla connessione https!
		header(	"location: https://"
		 			.$_SERVER['HTTP_HOST']
		 			."/index.php?component=Page&"
		 			."task=getPage&pageType=Form&page=FormChPW");
		exit;
	}
}
// HTTPS not required
else if ($_SERVER['SERVER_PORT'] == 443) {
	// redirect alla connessione http!
	header(	"location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	exit;
}
?>