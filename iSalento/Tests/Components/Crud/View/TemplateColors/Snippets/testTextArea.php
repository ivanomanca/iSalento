<?php

//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";

require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;


Isp_Loader::loadClass('Isp_Url');
//Isp_Loader::loadClass('Isp_Url_Photo');
//Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
Isp_Loader::loadVistaObj("Snippets","Form","TextArea","Crud");

/**
 * cHead
 */
$inputText = new TextArea("test","bosh");
$inputText->out("echo");
?>