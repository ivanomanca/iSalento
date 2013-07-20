<?php

$_SERVER['DOCUMENT_ROOT'] = "/var/www/iSalento/";
require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;


// Snippet che stampa un elenco puntato
$valori = array("ombrellone", "materassini", "salvataggio", "canoe", "acqua-scooter", "pedalo'", "gommoni");
$colonne = 2;

Isp_Loader::loadVistaObj("Snippets", "Card", "ElencoPuntatoTabella");
$serviziSnippet = new ElencoPuntatoTabella($valori,$colonne);				

// Preparo i valori per lo snippet schedaTecnica
$matrix = array(
				array("Nome", "Cocoloco"),
				array("Tipo", "Spiaggia"),
				array("Posti", 100),
				array("Servizi", $serviziSnippet)	
				);

// Carico e istanzio lo snippet scheda tecnica
Isp_Loader::loadVistaObj("Snippets", "Card", "SchedaTecnica");
$snippet = new SchedaTecnica($matrix);


$snippet->out("echo");

?>