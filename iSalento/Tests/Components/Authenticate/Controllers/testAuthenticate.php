<?php
/**
 * Parametri di simulazione link per test
 */

/* Activation test*/
$_POST = array (	"component" => 'authenticate',
						"task" => 'activeUser',
						"email" => 'ivano.isp@gmail.com');

/* Registration TEST*/
/*
$_POST = array ("component" => 'Authenticate',
				    "task" => 'register',
				    "nome_utente" => 'gianni',
				    "cognome_utente" => 'pinotto',
				    "email_utente" => 'ivanosalento@gmail.com',
				    "username_utente" => 'sangutiloe',
				    "pw1" => '1q2w3e4r',
				    "pw2" => '1q2w3e4r',
				    "img" => '10-70-230.jpgx',
				    "code" => 'asdf',
				    "next" => 'avanti',
);
*/

/* Login TEST
$_POST = array (	"component" => 'authenticate',
						"task" => 'login',
						"username_utente" => 'ivo',
						"crypted_password_utente" => 'pass');

*/
/* Logout TEST
$_SESSION['user'] = new Utente(array(	'username_utente' => 'ivo',
													'privilegi_utente' => 1));
$_POST = array(	"component" => "Page",
						"task" => "getPage",
						"pageType" =>"Form",
						"page" => "InsertStruttura",
						"errorMsg" => "");*/


/*$_POST = array (	"component" => 'authenticate',
						"task" => 'logout');*/


/*$_POST = array(	"component" => "Page",
						"task" => "getPage",
						"pageType" =>"Filtro",
						"page" => "FiltroInserisci",
						"errorMsg" => "eeeee");
*/
?>