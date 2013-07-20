<?php
/**
 * Url oggetti !!! Test vecchio!
 */

// Faccio includere il codice libreria
$ini = ini_set('include_path',ini_get('include_path').PATH_SEPARATOR.'../libreria');
require_once ("isp/loader.php") ;

// Test oggetto immagine
isp_loader::loadClass('isp_url_Image');
$imageUrl = new isp_url_Image("/beam/fashion/","titolo alta moda","alternative description");

// Stampo l'oggetto
print_r($imageUrl);
?>