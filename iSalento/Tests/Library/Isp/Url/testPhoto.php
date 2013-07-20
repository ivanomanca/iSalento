<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";
// Loader
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;

Isp_Loader::loadClass("Isp_Url_Photo");
$url = new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt","../");
?>