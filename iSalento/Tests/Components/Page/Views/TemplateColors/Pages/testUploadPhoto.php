<?php
/**
 * Parametri di simulazione link per test
 */		
$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"pageType" =>'Form',
				"page" =>'UploadPhoto'
				);
				
// imposto forward dopo l'inserimento della struttura
$_SESSION["nextOkPage"] = array("pageType" => "Form", "page" =>'UploadPhoto');
?>