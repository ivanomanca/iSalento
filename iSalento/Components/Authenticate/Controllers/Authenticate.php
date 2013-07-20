<?
Isp_Loader::loadClass("Isp_Controller_Action_Instantiator");

/**
 * General Authenticate controller (default)
 */
class Authenticate extends Isp_Controller_Action_Instantiator {
	// appena loggato ritorna sulla pagina in http
	private $loginNextOkPage = array("comp" => "Page",
												"task" => "getPage",
												"page" =>
												array(	"pageType" => "Form",
															"page" => "FormLogin"));
	private $logoutNextOkPage = array("comp" => "Page",
												"task" => "getPage",
												"page" =>
												array(	"pageType" => "Extra",
															"page" => "ExtraHome"));
	private $registerNextOkPage = array("comp" => "Page",
												"task" => "getPage",
												"page" =>
												array(	"pageType" => "Form",
															"page" => "FormReg"));
	private $beanUtente;

	// stringhe parametri utente
	private $userDisabled = 'disattivo';
	private $userNotApproved = 'richiesta';
	private $userActive = 'attivo';

	/**
	 * Login task
	 *
	 */
	public function login(){
		// includo le funzioni di controllo
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Components/Authenticate/".
							"Controllers/Authenticate/Func.php");
		// includo la configurazione dei controlli
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Inc/Security/authConf.php");
		// includo la classe per l'errore
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Db/ObjError.php");

		// recupero dati utente da form
		if(!isset($this->front->request->params['username_utente']) ||
			!isset($this->front->request->params['crypted_password_utente']) ||
			empty($this->front->request->params['username_utente']) ||
			empty($this->front->request->params['crypted_password_utente'])){
			// la richiesta proviene da una pagina in cui non  presente il form!
			// forward errore dell'utente non registrato
		   $this->forwardError(ErrorType::WRONG_PASSWORD);
		}else{
			$user = $this->front->request->params['username_utente'];
			$pass = $this->front->request->params['crypted_password_utente'];

			// controllo input proibito di user
			if(checkUsername($user)){

				// Istanzia il beaner
				if($this->instantiate("Isp_Db_Beaner")){
			        $Beaner = $this->instancedObj;
		        	// Ricavo il bean: interrogo il Db
		        	$filterArray = array("username_utente" => $user,
		        								/*"righe" => 1*/);
		        	$this->beanUtente = $Beaner->retrieve("Utente", $filterArray);

		        	// verifica registrazione utente
		        	if(!is_null($this->beanUtente)){
		        		// hash the password with retrieved salt
		        		$hashedpassword = createHash(	$pass,
		        			substr($this->beanUtente->crypted_password_utente, 0, 40));

		        		// verifica stato utente
		        		if($this->beanUtente->stato_utente == $this->userDisabled){
		        			// utente disabilitato, forward errore
		        			$this->forwardError(ErrorType::USER_DISABLED);
		        		}elseif($this	->beanUtente
		        							->stato_utente == $this->userNotApproved){
		        			// utente in attesa di accettazione, forward errore
		        			$this->forwardError(ErrorType::USER_NOT_APPROVED);
		        		}else
		        		// verifica della password
		        		if (	$this->beanUtente->stato_utente == $this->userActive &&
		        				$this->beanUtente
		        					->crypted_password_utente == $hashedpassword) {
		        			// pw corretta, salvo l'oggetto utente in sessione.
		        			$_SESSION['user'] = $this->beanUtente;

		        			// adesso usa la view in http!
							$this->forward($this->loginNextOkPage["task"],
												$this->loginNextOkPage["comp"],
												null,
												$this->loginNextOkPage["page"]);

		        		}else {
		        			// pw errata, forward errore
		        			$this->forwardError(ErrorType::WRONG_PASSWORD);
		        		}
		        	}else{
		        		// forward errore dell'utente non registrato
		        		$this->forwardError(ErrorType::WRONG_PASSWORD);
		        	}
		    	}else {
		    		if(!session_destroy()){
						//forward to Error!
						$this->forwardError(ErrorType::SESSION_NOT_DESTROYED);
					};
					$_SESSION['user'] = null;
		    	}
			}else {
				// username non conforme ai controlli
				$this->forwardError(ErrorType::WRONG_PASSWORD);
			}
		}
	}

	/**
	 * Logout task
	 *
	 */
	public function logout(){
		$this->forward($this->logoutNextOkPage["task"],
							$this->logoutNextOkPage["comp"],
							null,
							$this->logoutNextOkPage["page"]);

		if(!session_destroy()){
			//forward to Error!
			$this->forwardError(ErrorType::SESSION_NOT_DESTROYED);
		};
		// mi tocca fare cos“ perch non distrugge!
		$_SESSION['user'] = null;
	}

	/**
	 * Register task
	 *
	 */
	public function register(){
		// includo le funzioni di controllo
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Components/Authenticate/".
							"Controllers/Authenticate/Func.php");
		// includo la configurazione dei controlli
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Inc/Security/authConf.php");
		// includo la classe per l'errore
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Db/ObjError.php");

		$errorsArray = array();
		$nome = null; $cogn = null; $email = null; $user = null;
		$pw1 = null; $pw2 = null; $code = null; $img = null;
		$validationOk = true;

		/* nome_utente
		if(isset($this->front->request->params['nome_utente']) &&
			!empty($this->front->request->params['nome_utente'])){
			$nome = $this->front->request->params['nome_utente'];
			if(sanitizeTxtString($nome) === false){
				$validationOk = false;
				array_push($errorsArray, ErrorType::WRONG_NAME);
			}else{$_SESSION['regValidFields']['nome_utente'] = $nome;}
		}else{array_push($errorsArray, ErrorType::FORM_NOT_FILLED);}*/

		/* cognome_utente
		if(isset($this->front->request->params['cognome_utente']) &&
			!empty($this->front->request->params['cognome_utente'])){
			$cogn = $this->front->request->params['cognome_utente'];
			if(sanitizeTxtString($cogn) === false){
				$validationOk = false;
				array_push($errorsArray, ErrorType::WRONG_SURNAME);
			}else{$_SESSION['regValidFields']['cognome_utente'] = $cogn;}
		}else{array_push($errorsArray, ErrorType::FORM_NOT_FILLED);}*/

		// username_utente
		if(isset($this->front->request->params['username_utente']) &&
			!empty($this->front->request->params['username_utente'])){
			$user = $this->front->request->params['username_utente'];
			if(checkUsername($user) === false){
				$validationOk = false;
				array_push($errorsArray, ErrorType::WRONG_USERSTRING);
			}else{
				// verifico la disponibilitˆ
				require_once($_SERVER['DOCUMENT_ROOT']
				."/Library/Isp/Db/SimpleEnquirer.php");
				try{$g = Isp_Db_SimpleEnquirer::getInstance();}
				catch (DbConnException $e) {}
				catch (DbSelectException $e) {}
				if(is_null($g->getRecord(	"utente",
													array("username_utente" => $user)))){
					$_SESSION['regValidFields']['username_utente'] = $user;
				}else{array_push($errorsArray, ErrorType::USERNAME_NOT_AVAILABLE);}
			}
		}else{array_push($errorsArray, ErrorType::FORM_NOT_FILLED);}

		// email_utente
		if(isset($this->front->request->params['email_utente']) &&
			!empty($this->front->request->params['email_utente'])){
			$email = $this->front->request->params['email_utente']; $skip = false;
			if(checkEmail($email) === false){
				$validationOk = false;
				$skip = true; array_push($errorsArray, ErrorType::WRONG_EMAIL);
			}// Se dˆ problemi questo if che segue si pu˜ togliere
			/*if($_SERVER['SERVER_NAME'] != 'localhost' && !$skip){
				// controllo esistenza dominio
				list($userName, $mailDomain) = split("@", $email);
				if(checkdnsrr($mailDomain, "MX") === false){
					$skip = true; array_push($errorsArray, ErrorType::WRONG_EMAIL);
				}
			}*/
			if(!$skip){
				// verifico che la mail non sia giˆ registrata.
				require_once(	$_SERVER['DOCUMENT_ROOT']
									."/Library/Isp/Db/SimpleEnquirer.php");
				try{$g = Isp_Db_SimpleEnquirer::getInstance();}
				catch (DbConnException $e) {}
				catch (DbSelectException $e) {}
				if(is_null($g->getRecord(	"utente",
													array("email_utente" => $email)))){
					$_SESSION['regValidFields']['email_utente'] = $email;
				}else{array_push($errorsArray, ErrorType::EMAIL_USED_YET);}
			}
		}else{array_push($errorsArray, ErrorType::FORM_NOT_FILLED);}

		// pw1/pw2
		if(isset($this->front->request->params['pw1']) &&
			!empty($this->front->request->params['pw1']) &&
			isset($this->front->request->params['pw2']) &&
			!empty($this->front->request->params['pw2'])){
			$pw1 = $this->front->request->params['pw1'];
			$pw2 = $this->front->request->params['pw2'];
			if(checkPassword($pw1, $user) === false){
				$validationOk = false;
				array_push($errorsArray, ErrorType::WRONG_PW_STRING);
			}
			if(checkPassword($pw1, $user) === -1){
				$validationOk = false;
				array_push($errorsArray, ErrorType::WRONG_ADMIN_PW_STRING);
			}
			if($pw1 != $pw2){
				$validationOk = false;
				array_push($errorsArray, ErrorType::PW1_NOT_EQUALS_PW2);
			}else{/*non salvo mai le password! */}
		}else{array_push($errorsArray, ErrorType::FORM_NOT_FILLED);}

		// captcha
		//if(fopen("http://www.opencaptcha.com/", "r")){
			if(isset($this->front->request->params['code']) &&
				!empty($this->front->request->params['code']) &&
				isset($this->front->request->params['img']) &&
				!empty($this->front->request->params['img'])){
				$code = $this->front->request->params['code'];
				$img = $this->front->request->params['img'];
				if(!(file_get_contents(	"http://www.opencaptcha.com/validate.php?ans="
												.$code."&img=".$img) =='pass')) {
					$validationOk = false;
					array_push($errorsArray, ErrorType::WRONG_CAPTCHA_CODE);
				}else{/*non salvo il codice captcha*/}
			}else{array_push($errorsArray, ErrorType::FORM_NOT_FILLED);}
		//}

		if ($errorsArray != array()) {
			$this->forwardError(array_unique($errorsArray));
		}

		if($validationOk){
			if(isset($_SESSION['regValidFields'])){
				unset($_SESSION['regValidFields']);
			}

			// calcolo fingerprint
			$fpUser = sha1($user.rand(0,9999999999999));
			// invio la mail di conferma
			//@todo gestire l'uscita booleana!
			$this->sendVerifyEmail($user, $email, $user."@".$fpUser);

			$params = array(	"crudNtt" => 'Utente',
									//'nome_utente' => ucfirst($nome),
									//'cognome_utente' => ucfirst($cogn),
									'email_utente' => $email,
									'username_utente' => $user,
									'crypted_password_utente' => createHash($pw1),
									'privilegi_utente' => Permission::STAFF,
									'stato_utente' => 'richiesta',
									'dati_visibili_utente' => 'yes',
									'fp_utente' => $fpUser);

			// controlli ok, via alla registrazione.
			$_SESSION["nextOkPage"] = array(	"page" => "FormReg",
														"pageType" => "Form");
			$this->forward('insert', 'Crud', null, $params);
		}
	}

	/**
	 * ActiveUser task
	 *
	 */
	public function activeUser(){
		// includo le funzioni di controllo
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Db/ObjError.php");

		$errorsArray = array();
		$email = null;
		$validationOk = true;

		// email_utente
		if(isset($this->front->request->params['email']) &&
			!empty($this->front->request->params['email'])){
			$email = $this->front->request->params['email'];

			// verifico che la mail esista nel db.
			require_once(	$_SERVER['DOCUMENT_ROOT']
								."/Library/Isp/Db/SimpleEnquirer.php");
			try{$g = Isp_Db_SimpleEnquirer::getInstance();}
			catch (DbConnException $e) {}
			catch (DbSelectException $e) {}
			$obj = $g->getRecord("utente", array("email_utente" => $email));
			if(!is_null($obj)){
				$user = $obj['username_utente'];
				$params = array(	"crudNtt" => 'Utente',
										'username_utente' => $user,
										'stato_utente' => 'attivo');

				$_SESSION["nextOkPage"] = array(	"page" => "ListaUtente",
															"pageType" => "Lista");

				// da cambiare, dovrebbe essere il contrario
				// ovvero, invio la mail dopo che ho scritto nel db.
				if($this->sendActivationEmail($user, $email)){
					$this->forward('update', 'Crud', null, $params);
				}

			}else{array_push($errorsArray, ErrorType::OBJ_NOT_UPDATED);}

		}else if ($errorsArray != array()) {
			$this->forwardError($errorsArray);
		}
	}
	/**
	 * DisactiveUser task
	 *
	 */
	public function disactiveUser(){
		// includo le funzioni di controllo
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Db/ObjError.php");

		$errorsArray = array();
		$email = null;
		$validationOk = true;

		// email_utente
		if(isset($this->front->request->params['email']) &&
			!empty($this->front->request->params['email'])){
			$email = $this->front->request->params['email'];

			// verifico che la mail esista nel db.
			require_once(	$_SERVER['DOCUMENT_ROOT']
								."/Library/Isp/Db/SimpleEnquirer.php");
			try{$g = Isp_Db_SimpleEnquirer::getInstance();}
			catch (DbConnException $e) {}
			catch (DbSelectException $e) {}
			$obj = $g->getRecord("utente", array("email_utente" => $email));
			if(!is_null($obj)){
				$user = $obj['username_utente'];
				$params = array(	"crudNtt" => 'Utente',
										'username_utente' => $user,
										'stato_utente' => 'disattivo');

				$_SESSION["nextOkPage"] = array(	"page" => "ListaUtente",
															"pageType" => "Lista");

				// da cambiare, dovrebbe essere il contrario
				// ovvero, invio la mail dopo che ho scritto nel db.
				//if($this->sendActivationEmail($user, $email)){
					$this->forward('update', 'Crud', null, $params);
				//}

			}else{array_push($errorsArray, ErrorType::OBJ_NOT_UPDATED);}

		}else if ($errorsArray != array()) {
			$this->forwardError($errorsArray);
		}
	}

	/**
	 * emailConfirm task
	 *
	 */
	public function emailConfirm(){
		// includo le funzioni di controllo
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Components/Authenticate/".
							"Controllers/Authenticate/Func.php");
		// includo la configurazione dei controlli
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Inc/Security/authConf.php");
		// includo la classe per l'errore
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Db/ObjError.php");
		$errorsArray = array();
		$email = null; $user = null; $fpUser = null;
		$validationOk = true;

		// recupero fpUser
		if(isset($this->front->request->params['fp']) &&
			!empty($this->front->request->params['fp'])){
			$fpUser = $this->front->request->params['fp'];

			//list($username, $fpCode) = split("@", $fpUser);
			$splittedArray = split("@", $fpUser);
			if(sizeof($splittedArray) == 2){
				// prelevo i valori
				$user = $splittedArray[0];
				$fpUser = $splittedArray[1];
			}else{
				/* ingressi errati */
				$validationOk = false;
				array_push($errorsArray, ErrorType::REG_HACK_ATTEMPT);
			}
			if($validationOk){
				// verifico l'appartenenza della email all'user
				require_once(	$_SERVER['DOCUMENT_ROOT']
									."/Library/Isp/Db/SimpleEnquirer.php");
				try{$g = Isp_Db_SimpleEnquirer::getInstance();}
				catch (DbConnException $e) {}
				catch (DbSelectException $e) {}
				// ricavo l'oggetto user
				$utObj = $g->getRecord("utente", array("username_utente" => $user));
				if(is_null($utObj)){
					$validationOk = false;
					array_push($errorsArray, ErrorType::REG_HACK_ATTEMPT);
				}else{
					$fpFound = $utObj['fp_utente'];
					if($fpFound != $fpUser){
						$validationOk = false;
						array_push($errorsArray, ErrorType::REG_HACK_ATTEMPT);
					}else{
						// email confermata!
						//$validationOk = true;
						$params = array(	"crudNtt" => 'Utente',
												"username_utente" => $user,
												"emailconfirmed_utente" => 1);
						// forward del'update
						$this->forward('update', 'Crud', null, $params);

						// setto la pagina di notifica
						$_SESSION["nextOkPage"] = array(	"page" => "RegNotify",
																	"pageType" => "Extra");
					}
				}
			}
			// unifico gli errori
			if ($errorsArray != array()) {
				$this->forwardError(array_unique($errorsArray));
				// setto la pagina di notifica
				$_SESSION["nextOkPage"] = array(	"page" => "RegNotify",
															"pageType" => "Extra");
			}
			// invio la risposta alla pagina
		}
	}
	/**
	 * change password task
	 *
	 */
	public function changePW(){
		// includo le funzioni di controllo
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Components/Authenticate/".
							"Controllers/Authenticate/Func.php");
		// includo la configurazione dei controlli
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Inc/Security/authConf.php");
		// includo la classe per l'errore
		require(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Isp/Db/ObjError.php");

		$errorsArray = array();
		$email = null; $user = null; $pw1 = null; $pw2 = null;
		$validationOk = true;


		if(isset($_SESSION['user'])){
			// recupero username_utente da sessione
			$user = $_SESSION['user']->username_utente;
			// recupero email_utente da sessione
			//$email = $_SESSION['user']->email_utente;

			// recupero dati utente da form
			if(!isset($this->front->request->params['pw']) ||
				empty($this->front->request->params['pw'])){
				// la richiesta proviene da una pagina in cui non  presente il form!
				// forward errore dell'utente non registrato
				$validationOk = false;
			   $this->forwardError(ErrorType::CHPW_WRONG_PASSWORD);
			}else{
				$pass = $this->front->request->params['pw'];
				// Istanzia il beaner
				if($this->instantiate("Isp_Db_Beaner")){
			      $Beaner = $this->instancedObj;
		        	// Ricavo il bean: interrogo il Db
		        	$filterArray = array("username_utente" => $user,
		        								/*"righe" => 1*/);
		        	$this->beanUtente = $Beaner->retrieve("Utente", $filterArray);

	        		// hash the password with retrieved salt
	        		$hashedpassword = createHash(	$pass,
	        			substr($this->beanUtente->crypted_password_utente, 0, 40));

	        		// verifica della password
	        		if ($this->beanUtente->stato_utente == $this->userActive &&
	        			$this->beanUtente->crypted_password_utente == $hashedpassword){

	        			// pw1/pw2
						if(isset($this->front->request->params['pw1']) &&
							!empty($this->front->request->params['pw1']) &&
							isset($this->front->request->params['pw2']) &&
							!empty($this->front->request->params['pw2'])){

							$pw1 = $this->front->request->params['pw1'];
							$pw2 = $this->front->request->params['pw2'];
							$check = checkPassword($pw1, $user);
							// password utente
							if($check === false){
								$validationOk = false;
								array_push($errorsArray, ErrorType::CHPW_WRONG_PW_STRING);
							}
							// password admin
							if($check === -1){
								$validationOk = false;
								array_push($errorsArray,
								ErrorType::CHPW_WRONG_ADMIN_PW_STRING);
							}
							if($pw1 != $pw2){
								$validationOk = false;
								array_push($errorsArray, ErrorType::CHPW_PW1_NOT_EQUALS_PW2);
							}
						}else{
							$validationOk = false;
							array_push($errorsArray, ErrorType::CHPW_FORM_NOT_FILLED);
						}
        			}else{
        				// pw errata, forward errore
        				$validationOk = false;
        				$this->forwardError(ErrorType::CHPW_WRONG_PASSWORD);
        			}
				}else{
        			// pw errata, forward errore
        			$validationOk = false;
        			//$this->forwardError(ErrorType::OBJ_NOT_RETRIEVED);
      		}
			}

			if ($errorsArray != array()) {
				$this->forwardError(array_unique($errorsArray));
			}

			if($validationOk){
				$params = array(	"crudNtt" => 'Utente',
										'username_utente' => $user,
										'crypted_password_utente' => createHash($pw1));

				// controlli ok, via alla registrazione.
				$_SESSION["nextOkPage"] = array(	"page" => "FormChPW",
															"pageType" => "Form");
				$this->forward('update', 'Crud', null, $params);
			}
		}else{
			// L'UTENTE NON E' LOGGATO!
			echo("Porca pupazza, loggati!");
			//$this->forwardError(array(ErrorType::PAGE_DENIED));
		}
	}

	/**
	 * Forward al modulo Error
	 *
	 * @param void $errorString
	 */
	private function forwardError($errorType){
		if(is_array($errorType)){
			$array = array();
			foreach ($errorType as $error){
				array_push($array, new Isp_Db_ObjError($error));
			}
			// forward array errori
	  		$this->forward('authError',
								'Error',
								'Error',
								array('failedReq' => $this->front->request,
										'errArray' => $array));
		}else{
			// forward errore singolo
	  		$this->forward('authError',
								'Error',
								'Error',
								array('failedReq' => $this->front->request,
										'errArray' => array(
											new Isp_Db_ObjError($errorType))));
		}
  		// distruggo la sessione
		session_destroy();
	}

	/**
	 * Send an email to...
	 *
	 */
	private function sendVerifyEmail($username, $destinationAddress, $fpCode){
		// setto l'orario
		date_default_timezone_set('America/Toronto');

		//includo la classe mailer
		require_once(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Mailer/class.phpmailer.php");
		// istanzio il mailer
		$mail	= new PHPMailer();
		// includo il testo della mail
		require_once(	$_SERVER['DOCUMENT_ROOT'].
							"Components/Authenticate/Models/contents.php");
		// compongo il testo
		$body = 	$PART1.$username.$PART2.$_SERVER['SERVER_NAME']
					.$PART3.$fpCode.$PART4;
		//$body             = eregi_replace("[\]",'',$body);

		// forzo l'uso del server SMTP esterno
		$mail->IsSMTP();
		// abilito la stampa delle info di debug
		//$mail->SMTPDebug  = 2;
		// imposto l'autenticazione per l'invio
		$mail->SMTPAuth   = true;
		// imposto il protocollo di autenticazione
		$mail->SMTPSecure = "ssl";
		// imposto il server smtp di gmail
		$mail->Host       = "smtp.gmail.com";
		// imposto la porta del server smtp di gmail
		$mail->Port       = 465;
		// imposto l'indirizzo del mittente (Gmail username)
		$mail->Username   = "isalento.it@gmail.com";
		// imposto la password del mittente (Gmail password)
		$mail->Password   = "pa55word";
		// imposto l'indirizzo dell mittente che appare nella mail.
		$mail->SetFrom('isalento.it@gmail.com', 'iSalento Staff');
		// imposto l'indirizzo di risposta
		//$mail->AddReplyTo('isalento.it@gmail.com', 'iSalento Staff');
		// scrivo l'oggetto della mail
		$mail->Subject    = "Conferma registrazione account iSalento";
		// scrivo il body alternativo per chi non visualizza l'ht
		$mail->AltBody    = 	"Per leggere il messaggio, ".
									"usa un client di posta compatibile con l'Html!";
		// inserisco il file di testo del body
		$mail->MsgHTML($body);
		// imposto il destinatario
		$mail->AddAddress($destinationAddress, "");
		// verifico l'avvenuto invio della email
		if(!$mail->Send()) {
			return false;
			//echo "ERRORE DI INVIO: " . $mail->ErrorInfo;
		}else{return true;}
	}

	/**
	 * Send an email to...
	 *
	 */
	private function sendActivationEmail($username, $destinationAddress){
		// setto l'orario
		date_default_timezone_set('America/Toronto');

		//includo la classe mailer
		require_once(	$_SERVER['DOCUMENT_ROOT'].
							"Library/Mailer/class.phpmailer.php");
		// istanzio il mailer
		$mail	= new PHPMailer();
		// includo il testo della mail
		require_once(	$_SERVER['DOCUMENT_ROOT'].
							"Components/Authenticate/Models/activation.php");
		// compongo il testo
		$body = 	$PART1.$username.$PART2.$_SERVER['SERVER_NAME'].$PART3.$PART4;
		//$body             = eregi_replace("[\]",'',$body);

		// forzo l'uso del server SMTP esterno
		$mail->IsSMTP();
		// abilito la stampa delle info di debug
		//$mail->SMTPDebug  = 2;
		// imposto l'autenticazione per l'invio
		$mail->SMTPAuth   = true;
		// imposto il protocollo di autenticazione
		$mail->SMTPSecure = "ssl";
		// imposto il server smtp di gmail
		$mail->Host       = "smtp.gmail.com";
		// imposto la porta del server smtp di gmail
		$mail->Port       = 465;
		// imposto l'indirizzo del mittente (Gmail username)
		$mail->Username   = "isalento.it@gmail.com";
		// imposto la password del mittente (Gmail password)
		$mail->Password   = "pa55word";
		// imposto l'indirizzo dell mittente che appare nella mail.
		$mail->SetFrom('isalento.it@gmail.com', 'iSalento Staff');
		// imposto l'indirizzo di risposta
		//$mail->AddReplyTo('isalento.it@gmail.com', 'iSalento Staff');
		// scrivo l'oggetto della mail
		$mail->Subject    = "Attivazione account iSalento";
		// scrivo il body alternativo per chi non visualizza l'ht
		$mail->AltBody    = 	"Per leggere il messaggio, ".
									"usa un client di posta compatibile con l'Html!";
		// inserisco il file di testo del body
		$mail->MsgHTML($body);
		// imposto il destinatario
		$mail->AddAddress($destinationAddress, "");
		// verifico l'avvenuto invio della email
		if(!$mail->Send()) {
			return false;
			//echo "ERRORE DI INVIO: " . $mail->ErrorInfo;
		}else{return true;}
	}
}


?>
