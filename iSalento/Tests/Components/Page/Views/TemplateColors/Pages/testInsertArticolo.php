<?php
/**
 * Parametri di simulazione link per test
 */
// INSERT NTT TEST
			
$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"pageType" => 'Form',
				"page" => "InsertArticolo"/*,
				"ntt"=>"Struttura",
				"idNtt"=>100*/);

// imposto forward dopo l'inserimento dell'articolo
$_SESSION["nextOkPage"] = array("page" => "InsertArticolo", "pageType" => "Form");
				
?>