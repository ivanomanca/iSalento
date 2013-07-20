<?php
require_once(	$_SERVER['DOCUMENT_ROOT']
					.'Components/Error/Models/ErrorType.php');

class ErrorString {

	public static $Out = array(

	'it' => array(

	// Authentication errors
/*	const LENGTH_BETWEEN = 1;
	const NO_SPACES = 2;
	const CHAR_NOT_PRESENT= 3;
	const ILLEGAL_CHAR_PRESENT = 4;
	const USERNAME_CENSURED = 5;
	const WRONG_USERNAME = 6;
	const WRONG_PASSWORD = 7;
	const USER_NOT_APPROVED = 8;
	const USER_DISABLED = 9;*/
	1 =>	'La lunghezza deve essere compresa tra...',
	2 =>	'Non ci devono essere spazi',
	3 =>	'Deve esserci almeno un carattere alfabetico',
	4 =>	'Non possono esserci i seguenti caratteri: ...',
	5 =>	'Questo username  giˆ esistente.',
	6 =>	'Username e/o password errati.',
	7 =>	'Username e/o password errati.',
	8 =>	"La sua richiesta di iscrizione e' in attesa di accettazione.",
	9 =>	"Ci sono dei problemi con il suo account.
			Contatti al piu' presto lo staff di iSalento.",

	// ObjManager-SimpleEnquirer errors
/*	const OBJ_NOT_CREATED = 20;
	const OBJ_NOT_LOADED = 21;
	const OBJ_NOT_INSERTED = 22;
	const OBJ_NOT_UPDATED = 23;
	const OBJ_NOT_DELETED = 24;

	const OBJ_NOT_LISTED = 30;
	const OBJ_NOT_RETRIEVED = 31;*/
	20 => "Errore di sistema, lo staff di iSalento risolvera' l'inconveniente
			il prima possibile. Scusate il disagio.",

	// System errors
/*	const SESSION_NOT_DESTROYED = 40;*/
	40 => "Errore temporaneo di sistema.
			Lo staff di iSalento provvederˆ a risolverlo quanto prima.
			Scusate il disagio.",

	// Page errors
/*	const PAGE_DENIED = 50;
	const PAGE_NOT_FOUND = 51;*/
	50 => "",
	51 => "Pagina non trovata.",

	// Registration errors
/*	const FORM_NOT_FILLED = 60;
	const WRONG_NAME = 61;
	const WRONG_SURNAME = 62;
	const WRONG_EMAIL = 63;
	const WRONG_USERSTRING = 64;
	const PW1_NOT_EQUALS_PW2 = 65;
	const USERNAME_NOT_AVAILABLE = 66;
	const WRONG_CAPTCHA_CODE = 67;
	const EMAIL_USED_YET = 68;
	const WRONG_PW_STRING = 69;
	const WRONG_ADMIN_PW_STRING = 70;*/
	60 => "Compilare il form in tutti i campi.<br/>",
	61 => "Il nome puo' contenere solo i seguenti caratteri:<br/>abcdefghijklmnopqrstuvwxyz<br/>ABCDEFGHIJKLMNOPQRSTUVWXYZ'-<br/>ed essere lungo al massimo 20.<br/>",
	62 => "Il cognome puo' contenere solo i seguenti caratteri:<br/>abcdefghijklmnopqrstuvwxyz<br/>ABCDEFGHIJKLMNOPQRSTUVWXYZ'-<br/>ed essere lungo al massimo 20.<br/>",
	63 => "L'indirizzo email non e' valido.<br/>",
	64 => "L' username non puo' contenere spazi; deve iniziare con almeno un carattere alfabetico; non contenere caratteri diversi da<br/> abcdefghijklmnopqrstuvwxyz<br/>ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_. ; essere compreso tra i 3 ed i 15 caratteri.<br/>",
	65 => "Le due password inserite non coincidono.<br/>",
	66 => "L'username inserito NON E' DISPONIBILE.<br/>",
	67 => "Il codice dell'immagine e' errato.<br/>",
	68 => "La tua email e' gia' registrata per un account iSalento.<br/>",
	69 => "La password utente deve:
				<br>a) essere lunga almeno 8 caratteri;
				<br>b) non contenere spazi;
				<br>c) essere alfanumerica;<br>",
	70 => "La password admin deve:
				<br>a) essere lunga almeno 8 caratteri;
				<br>b) non contenere spazi;
				<br>c) avere almeno un carattere alfabetico minuscolo;
				<br>d) avere almeno un carattere alfabetico maiuscolo;
				<br>d) avere almeno un carattere numerico;
				<br>d) avere almeno un carattere di punteggiatura tra !%&()=?.,;:+@;
				<br>",
// change password errors
/*	const CHPW_FORM_NOT_FILLED = 71;
	const CHPW_PW1_NOT_EQUALS_PW2 = 72;
	const CHPW_WRONG_PW_STRING = 73;
	const CHPW_WRONG_ADMIN_PW_STRING = 74;
	const CHPW_WRONG_PASSWORD = 75;*/
	71 => "Compilare il form in tutti i campi.<br/>",
	72 => "Le due nuove password inserite non coincidono.<br/>",
	73 => "La password utente deve:
				<br>a) essere lunga almeno 8 caratteri;
				<br>b) non contenere spazi;
				<br>c) avere almeno un carattere alfabetico;<br>",
	74 => "La password admin deve:
				<br>a) essere lunga almeno 8 caratteri;
				<br>b) non contenere spazi;
				<br>c) avere almeno un carattere alfabetico minuscolo;
				<br>d) avere almeno un carattere alfabetico maiuscolo;
				<br>d) avere almeno un carattere numerico;
				<br>d) avere almeno un carattere di punteggiatura tra !%&()=?.,;:+@;
				<br>",
	75 => "La password admin da sostituire e' errata.",

	// Email confirmation errors
/*	const REG_HACK_ATTEMPT = 80;*/

	80 => "ATTENZIONE: La richiesta di registrazione del tuo account e' ancora bloccata, assicurati di aver copiato ed incollato in modo corretto il link nel browser. Se il problema persiste contatta lo staff di iSalento per avere chiarimenti.<br/>"
));
}
?>