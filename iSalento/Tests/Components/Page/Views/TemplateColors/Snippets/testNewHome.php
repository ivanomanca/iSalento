<?php

$_SERVER['DOCUMENT_ROOT'] = "/var/www/iSalento/";
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;

Isp_Loader::loadClass('Isp_Url_Page');
Isp_Loader::loadClass('Isp_Url_Photo');

// Preparo i valori per lo snippet
$urlPhoto = new Isp_Url_Photo(null,null,null,null,"IMMAGINI/big_Salento-Puglia_2.jpg",null);
$urlPage  = new Isp_Url_Page("click kere", "Card", "NewsHome", null, "News");;
$strApprofondisci = "More and more...";
$description		 = "Finalmente il sito che tutti quanti aspettavamo ora è live";

// Carico e istanzio lo snippet scheda tecnica
Isp_Loader::loadVistaObj("Snippets", "Home", "NewsHome");
$snippet = new NewsHome($description,$urlPage,$urlPhoto,$strApprofondisci);


$snippet->out("echo");

?>