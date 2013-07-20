<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/".$_SERVER['USER']."/Sites/iSalento/";

// Percorsi alle classi
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Loader.php");
$folder = Isp_Loader::getPageFolder("Lista",
									"ListaStruttura",
									array("id_tipostruttura"=>3,
										  "id_categoria"=>2));
?>