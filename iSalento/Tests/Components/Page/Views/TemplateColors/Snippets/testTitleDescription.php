<?php

//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;


Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
$snippet = new TitleDescription( "titolo test", "descrizione test");

$snippet->out("echo");

?>