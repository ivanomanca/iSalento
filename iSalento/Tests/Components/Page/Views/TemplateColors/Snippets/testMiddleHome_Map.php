<?php
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";
//$_SERVER['DOCUMENT_ROOT'] = "/var/www/iSalento/";
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;

Isp_Loader::loadClass('Isp_Url_Photo');

// Preparo i valori per lo snippet
$urlPhoto = new Isp_Url_Photo(null,null,null,null,"IMMAGINI/cartina_salento+italia3.png");
$coord = array("267,75,322,102","374,166,434,200","190,216,245,240","343,335,419,383");
$titolo = "Cartina, Mappa del Salento";
$url =array("primo url..","secondo url..");
$matrice = array(array($coord[0],$url[0]),array($coord[1],$url[1]));

// Carico e istanzio lo snippet scheda tecnica
Isp_Loader::loadVistaObj("Snippets", "Home", "MiddleHome");
$snippet = new MiddleHome($titolo, $urlPhoto, "#Map", $matrice);


$snippet->out("echo");

?>