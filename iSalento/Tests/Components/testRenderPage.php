<?php
/**
 * Snippets
 */

// Faccio includere il codice libreria
$ini = ini_set('include_path',ini_get('include_path').PATH_SEPARATOR.'../libreria');
require_once ("isp/loader.php") ;

// Carica la pagina
isp_loader::loadClass('isp_url');
isp_loader::loadVistaObj("pages","extra","home");


$home = new home();
$body = $home->render();
print_r($body);

?>