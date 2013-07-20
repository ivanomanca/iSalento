<?php
/****************************************************************************
 		FUNZIONI PER IL CONTROLLO DELL'INPUT
******************************************************************************/
/**
 * Controllo della stringa username registrazione
 *
 * @param String $string2sanitize
 * @return sanitized string
 */
function sanitize($string2sanitize) {
	// configurazione dei controlli ed errori
	require(	$_SERVER['DOCUMENT_ROOT'].
						"Library/Isp/Inc/Security/authConf.php");
	if(!class_exists("ErrorType")){
	require_once(	$_SERVER['DOCUMENT_ROOT']
						.'Components/Error/Models/ErrorType.php');
	}
	return mysql_real_escape_string($string2sanitize);
}


/**
 * Controllo della stringa username registrazione
 *
 * @param String $username
 * @return boolean
 */
function checkUsername($string2Check) {
	// configurazione dei controlli ed errori
	require(	$_SERVER['DOCUMENT_ROOT'].
						"Library/Isp/Inc/Security/authConf.php");
	if(!class_exists("ErrorType")){
	require_once(	$_SERVER['DOCUMENT_ROOT']
						.'Components/Error/Models/ErrorType.php');
	}
	if (isset($CONFusername)) {
		if(!check_lenght_between(	$string2Check,
											$CONFusername["minLength"],
											$CONFusername["maxLength"])){
											return false;
		}
		elseif(	!check_no_spaces($string2Check) ||
					!check_is_not_censured($string2Check) ||
					!check_alfabetic_char_present($string2Check) ||
					!check_contains_legal_char($string2Check)
					){
			return false;
		}
		else return true;
	}
}

/**
 * Controllo della stringa username login
 *
 * @param String $username
 * @return boolean
 */
function checkUsername2Login($string2Check) {
	// configurazione dei controlli ed errori
	require(	$_SERVER['DOCUMENT_ROOT'].
						"Library/Isp/Inc/Security/authConf.php");
	if(!class_exists("ErrorType")){
	require_once(	$_SERVER['DOCUMENT_ROOT']
						.'Components/Error/Models/ErrorType.php');}
	if (isset($CONFusername)) {
		//lunghezzamassima
		$string2Check = stringFilter($string2Check, 100);

		if(!check_lenght_between(	$string2Check,
											$CONFusername["minLength"],
											$CONFusername["maxLength"])){
											return ErrorType::WRONG_USERNAME;
		}
		elseif(!check_no_spaces($string2Check)){
			return ErrorType::NO_SPACES;
		}
		elseif (!check_alfabetic_char_present($string2Check)){
			return ErrorType::CHAR_NOT_PRESENT;
		}
		elseif (!check_contains_legal_char($string2Check)){
			return ErrorType::ILLEGAL_CHAR_PRESENT;
		}
		elseif (!check_is_not_censured($string2Check)){
			return ErrorType::USERNAME_CENSURED;
		}
		else return true;
	}
}


/**
 * Controllo della stringa password
 *
 * @param String $username
 * @return boolean
 */
function checkPassword($string2Check, $username) {
	// configurazione dei controlli ed errori
	require(	$_SERVER['DOCUMENT_ROOT'].
						"Library/Isp/Inc/Security/authConf.php");
	if(!class_exists("ErrorType")){
	require_once(	$_SERVER['DOCUMENT_ROOT']
						.'Components/Error/Models/ErrorType.php');
	}
	if (isset($CONFpassword)) {
		// safe
		$string2Check = stringFilter($string2Check, 100);
		$string2Check = sanitize($string2Check);

		if(!check_lenght_between(	$string2Check,
											$CONFpassword["minLength"],
											$CONFpassword["maxLength"])){
											return false;
		}
		// admin password - strong
		if($username == 'admin'){
			if(// nessuno spazio
				!check_no_spaces($string2Check) ||
				// presente carattere minuscolo
				!check_lowercase_alfabetic_char_present($string2Check) ||
				// presente carattere maiuscolo
				!check_uppercase_alfabetic_char_present($string2Check) ||
				// presente carattere numerico
				!check_numeric_char_present($string2Check) ||
				// presente carattere di punteggiatura
				!check_point_char_present($string2Check)){
				return -1;
			}
		}else{
			// user password - intelligent
			if(!check_no_spaces($string2Check) ||
				// presente carattere alfabetico
				!check_alfabetic_char_present($string2Check) ||
				// presente carattere numerico
				!check_numeric_char_present($string2Check)){
				return false;
			}
		}
		return true;
	}else return false;
}

/**
 * Validatore email
 *
 * @param string $string2Check
 * @return string/boolean
 */
function checkEmail($string2Check){
$pattern="/^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/";
     if(!preg_match($pattern, $string2Check)){
         return false;
     }else return true;
}

/**************************************************************************
 	FILTRI
**************************************************************************/
/**
 * Verifica se nella stringa in ingresso 
 * presente almeno un carattere del pattern
 *
 * @param string $string
 * @param string $pattern
 * @return boolean
 */
function present($string, $pattern){
	$size = strlen($string);
	for($i = 0; $i < $size; $i++){
		//echo $i;
		$out = strspn($string, $pattern, $i);
		if($out > 0)return true;
	}
	return false;
}



/**
* Filtro che mette in sicurezza la stringa per le query,
* eventualmente la tronca in base alla lunghezza max
*
* @param unknown_type $stringa
* @param unknown_type $lunghezzamax
* @return unknown
*/
function stringFilter($stringa, $lunghezzamax = 0) {
	if (!get_magic_quotes_gpc()) {
		$stringa = addslashes($stringa);
	}
	$t_string = mysql_escape_string($stringa);
	if ($lunghezzamax > 0) {
	    $t_string = substr($t_string, 0, $lunghezzamax);
	}
	return $t_string;
}

/**
* Controlla che la stringa non contenga spazi
*
* @param string $stringa
* @return boolean
*/
function check_no_spaces($stringa) {
	if (strrpos($stringa,' ') > 0) {
	    return false;
	}
	return true;
}

/**
* Controlla che la stringa contenga almeno
* un carattere alfabetico.
*
* @param string $stringa
* @return boolean
*/
function check_alfabetic_char_present($stringa) {
	return present(	$stringa,
							"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
}

/**
* Controlla che la stringa contenga almeno
* un carattere alfabetico maiuscolo.
*
* @param string $stringa
* @return boolean
*/
function check_uppercase_alfabetic_char_present($stringa) {
	return present(	$stringa,
							"QWERTYUIOPLKJHGFDSAZXCVBNM");
}

/**
* Controlla che la stringa contenga almeno
* un carattere alfabetico maiuscolo.
*
* @param string $stringa
* @return boolean
*/
function check_lowercase_alfabetic_char_present($stringa) {
	return present(	$stringa,
							"qwertyuioplkjhgfdsazxcvbnm");
}

/**
* Controlla che la stringa contenga almeno
* un carattere alfabetico minuscolo.
*
* @param string $stringa
* @return boolean
*/
function check_numeric_char_present($stringa) {
	return present(	$stringa,
							"0123456789");
}

/**
* Controlla che la stringa contenga almeno
* un carattere di punteggiatura.
*
* @param string $stringa
* @return boolean
*/
function check_point_char_present($stringa) {
	return present(	$stringa,
							"!%&()=?.,;:+@");
}

/**
* Controlla che la stringa non contenga caratteri
* illegali.
*
* @param string $stringa
* @return boolean
*/
function check_contains_legal_char($stringa) {
	if (strspn(	$stringa,
				"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_."
				)!= strlen($stringa)) {
	    return false;
	}
	return true;
}

/**
* Controlla che la lunghezza della stringa
* sia compresa nel range voluto.
*
* @param string $stringa
* @return boolean
*/
function check_lenght_between($stringa, $min_chars = 3, $max_chars = 20) {
	if ((strlen($stringa) < $min_chars) || (strlen($stringa) > $max_chars)) {
	    return false;
	}
	return true;
}

/**
* Controlla che la stringa non sia presente tra
* quelle censurate.
*
* @param string $stringa
* @return boolean
*/
function check_is_not_censured($stringa) {
	if (eregi(	"^((root)|(bin)|(daemon)|(adm)|(lp)|(sync)|(shutdown)"
	        	."|(halt)|(mail)|(news)|(union)"
	        	."|(uucp)|(select)|(grant)|(mysql)|(httpd)|(nobody)|(dummy)"
	        	."|(www)|(cvs)|(shell)|(ftp)|(irc)|(debian)"
	        	."|(ns)|(download))$",
	        	$stringa)) {
		return false;
	}
	return true;
}

/**
 * Crea l'hash della password con il salt variabile in
 * base alla lunghezza della stessa password
 *
 * @param string $inText
 * @param string $saltHash
 * @param string $mode
 * @return string
 */
function createHash($inText, $saltHash=NULL, $mode='sha1'){
        // hash the text
        $textHash = hash($mode, $inText);
        // set where salt will appear in hash
        $saltStart = strlen($inText);
        // if no salt given create random one
        if($saltHash == NULL) {
            $saltHash = hash($mode, uniqid(rand(), true));
        }
        // add salt into text hash at pass length position and hash it
        if($saltStart > 0 && $saltStart < strlen($saltHash)) {
            $textHashStart = substr($textHash,0,$saltStart);
            $textHashEnd = substr($textHash,$saltStart,strlen($saltHash));
            $outHash = hash($mode, $textHashEnd.$saltHash.$textHashStart);
        } elseif($saltStart > (strlen($saltHash)-1)) {
            $outHash = hash($mode, $textHash.$saltHash);
        } else {
            $outHash = hash($mode, $saltHash.$textHash);
        }
        // put salt at front of hash //
        $output = $saltHash.$outHash;
        return $output;
    }

/***********************************************************************
		PATTERNS
***********************************************************************
if (!preg_match('/^[a-zA-Z0-9_]+$/',$this->user )) {
   $this->setError('Username contains invalid characters');
}

if (!preg_match('/^[a-zA-Z0-9_]+$/',$this->pass )) {
   $this->setError('Password contains invalid characters');
}
//email
if(!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/',$_POST['email']))
   die('Invalid email proved, the email must be in valid email format (such as name@domain.tld).');
if(!preg_match('/^[-_ 0-9a-z]$/i',$_POST['name']))
   die('Invalid name proved, the name may only contain a-z, A-Z, 0-9, "-", "_" and spaces.');

//html safe
htmlspecialchars($_GET['name'], ENT_QUOTES);


//! A manipulator
    * //Validates an email address
    * @return void
    function validate() {
        $pattern=
    "/^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/";
        if(!preg_match($pattern,$this->email)){
            $this->setError('Invalid email address');
        }
        if (strlen($this->email)>100){
            $this->setError('Address is too long');
        }
    }
****************************************************************/


/*LIBRERIE DI FILTRAGGIO INPUT IN PHP
$name =   filter_input(INPUT_GET, 'name',   FILTER_VALIDATE_REGEXP, array(
     'options' => array(
        'regexp' => "/[a-z]{3,}/i")));

$age =   filter_input(INPUT_GET, 'age',   FILTER_VALIDATE_INT, array(
     'options' => array(
        'min_range' => 0,
        'max_range' => 80)));

function check_username($username)
{
// Sarebbe opportuno un controllo pi utile
return (strlen($username) > 8);
}

if (!filter_has_var(INPUT_POST, 'submit'))
{
header('Location: form.html');
exit();
}

$definitions = array(
'name' => array(
  'filter' => FILTER_SANITIZE_STRING,
  'flags'  => FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_ENCODE_LOW),

'username' => array(
  'filter' => FILTER_CALLBACK,
  'options' => 'check_username'),

'email' => FILTER_VALIDATE_EMAIL,

'age' => array(
  'filter' => FILTER_VALIDATE_INT,
  'options'=> array('min_range' => 0, 'min_range' => 80)),

'nationalities' => array(
  'filter' => FILTER_SANITIZE_STRING,
  'flags' => FILTER_REQUIRE_ARRAY));

$input = filter_input_array(INPUT_POST, $definitions);

if ($input['age'] === false)
{
echo "L'etˆ deve essere compresa tra 0 ed 80 anni";
}

// controllare gli altri valori ...
*/

/* PASSWORD ADMIN TEST
$_SERVER['DOCUMENT_ROOT'] = "/Users/ivanomanca/Sites/iSalento/";
//$outputCtrl = inputStringControl("ivo", "username2Login");
//$outputCtrl = check_alfabetic_char_present('1q2w3e4r');

$string2Check = 'ASDF5a...!';
$out = check_no_spaces($string2Check);
echo("space: ".$out."\n");
// presente carattere minuscolo
$out = check_lowercase_alfabetic_char_present($string2Check);
echo("lower: ".$out."\n");
// presente carattere maiuscolo
$out = check_uppercase_alfabetic_char_present($string2Check);
echo("upper: ".$out."\n");
// presente carattere numerico
$out = check_numeric_char_present($string2Check);
echo("numeric: ".$out."\n");
// presente carattere di punteggiatura
$out = check_point_char_present($string2Check);
echo("point: ".$out."\n");
*/



/* CreateHash TEST
$_SERVER['DOCUMENT_ROOT'] = "/Users/ivanomanca/Sites/iSalento/";
$out = createHash('PA55word!', null, 'sha1');
$out2 = createHash('PA55word!', substr($out, 0, 40), 'sha1');
echo($out."\n");
echo($out2);
*/

?>

