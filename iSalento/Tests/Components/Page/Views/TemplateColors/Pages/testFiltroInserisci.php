<?php
/**
 * Parametri di simulazione link per test
 */

$_GET = array ("component" => 'Page',
					"task" => 'getPage',
					"pageType" => 'Filtro',
					"page" => "FiltroInserisci");

// Creo un oggetto temporaneo per simulare il log-in utente con privilegi					
class userPrivilegiTest{
	public $privilegi_utente = 1;
}
// Metto in sessione i privilegi
$_SESSION['user'] = new userPrivilegiTest();


?>