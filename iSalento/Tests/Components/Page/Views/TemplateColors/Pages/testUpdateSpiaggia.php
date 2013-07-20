<?php
/**
 * Parametri di simulazione link per test
 */
// INSERT NTT TEST
			
$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"pageType" => 'Form',
				"page" => "UpdateSpiaggia",
				"id_struttura" => '5');
				
class userPrivilegiTest{
	public $privilegi_utente = 1;
}

// Metto in sessione i privilegi
$_SESSION['user'] = new userPrivilegiTest();

// imposto forward dopo l'inserimento della struttura
$_SESSION["nextOkPage"] = array("page" => "InsertSpiaggia", "pageType" => "Form");
				
?>