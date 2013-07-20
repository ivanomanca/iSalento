<?php
/**
 * Parametri di simulazione link per test
 */
/*
// PAGINA FORM
$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"pageType" => 'Form',
				"page" => "FormLogin");

// imposto forward dopo l'inserimento della struttura
$_SESSION["nextOkPage"] = array("page" => "FormLogin", "pageType" => "Form");
*/

/*
// PAGINA DOPO L'INVIO DATI
$_GET = array (	"component" => 'Authenticate',
				"task" => 'login');

$_POST = array ("username_utente" => 'dan',
				"crypted_password_utente" => 'pass');

// imposto forward dopo l'inserimento della struttura
$_SESSION["nextOkPage"] = array("page" => "FormLogin", "pageType" => "Form");
*/



// PAGINA LOGOUT
$_GET = array (	"component" => 'Authenticate',
						"task" => 'login');


// imposto forward dopo l'inserimento della struttura
$_SESSION["nextOkPage"] = array("page" => "FormLogin", "pageType" => "Form");
$_SESSION["user"] = array("nome_utente" => "dan", "privilegi_utente" => "1");
?>