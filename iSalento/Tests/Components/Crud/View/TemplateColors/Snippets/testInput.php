<?php

//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";

require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;


Isp_Loader::loadClass('Isp_Url');
//Isp_Loader::loadClass('Isp_Url_Photo');
//Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
Isp_Loader::loadVistaObj("Snippets","Form","Input","Crud");

/**
 * cHead
 */
$inputText = new Input("text","Label txt: ","nome_db", false, null, 30, null, null,"default");
$inputSubmit = new Input("submit",null,"sub", false, "submitta");
$inputText->out("echo");
?>