<?php
/**
 * Test for Snippet abstraction class
 */
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento/";
// Loader
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;

Isp_Loader::loadClass("Isp_View_Snippet");
Isp_Loader::loadClass("Isp_Url_Photo");
Isp_Loader::loadClass("Isp_Url");
// Percorsi alle classi
//require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Url.php");
//require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/View/Snippet.php");

$snp = new Isp_View_Snippet();
$url = new Isp_Url("css/path","TITOLO");
$urlPhoto = new Isp_Url_Photo(1,"small","baia Gallipoli","baia alt");

$hrefUrl = $snp->href($url,"className");
$hrefPhoto = $snp->href($urlPhoto);

?>