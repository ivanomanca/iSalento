<?php
/****************************************************************/
// Linux
$_SERVER['DOCUMENT_ROOT'] = "/var/www/iSalento/";
// Mac
//$coder = $_ENV['USER'];
//$_SERVER['DOCUMENT_ROOT'] = "/Users/".$coder."/Sites/iSalento/";
// On Server
//$_SERVER['DOCUMENT_ROOT'] .= "/";
/****************************************************************/

// Includo la classe Utente per metterla in sessione
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Inc/Objects/Utente.php");
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Inc/Security/PermissionConf.php");
// apro la sessione
session_start();

// in caso di debug parte la configurazione in automatico!
require_once("debug.php");

/**
 * Bootstrap file, the starting point!
 */
// Error reporting
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors','on');

//############	SECURITY SETTINGS ###################
$_SERVER['httpsEnabled'] = false;
// Set include_path in php.ini to /Library
// durata dei cookies sul browser
ini_set('session.cookie_lifetime', 86400);
ini_set('session.gc_maxlifetime', 1440);
//ini_set('session.auto_start', 1);
ini_set('open_basedir', $_SERVER['DOCUMENT_ROOT']);
//$ini = ini_set(	'include_path',
//						ini_get('include_path')
//						.PATH_SEPARATOR
//						.'Library');
//##################################################

/* Front controller */
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;
Isp_Loader::loadClass('Isp_Controller_Front');

// Front istance (singleton)
$front = Isp_Controller_Front::getInstance();

// go!
$front->dispatch();

?>