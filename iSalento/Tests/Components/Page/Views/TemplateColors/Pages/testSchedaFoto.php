<?php
/**
 * Parametri di simulazione link per test
 */
// INSERT NTT TEST
/* OLD			
$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"pageType" => 'Scheda',
				"page" => "SchedaFoto",
				"id_fotovideo" => 2026,
				"listaTitle"=>"Mare",
				"listaPageName"=>"ListaFoto",
				"idunderscoretipostruttura-struttura" => 1);
*/	

// Chiedi la lista delle foto id_tipostruttura-struttura = 1 e poi
// seleziona la foto con id 2026
$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"pageType" => 'Scheda',
				"page" => "SchedaFoto",
				"id_tipostruttura-struttura" => 1,
				"idFotovideo" => 2026,
				"listaTitle"=>"Mare",
				"listaPageName"=>"ListaFoto",
				"idunderscoretipostruttura-struttura" => 1);
				
?>