<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento";

// Percorsi alle classi
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner.php");

/****************************************************************************
	TEST DI CARICAMENTO BEAN
******************************************************************************/
$bean = array("TEST Beaner VUOTO");
try{
	$Beaner = Isp_Db_Beaner::getInstance();

// PARAMETRI FILTRO
$params = array(	"giorno_notte_struttura" => "giorno",
					"order_cre" => "nome_struttura",
					//"id_localita-struttura" => 156
					//"prova_campo_esterno-localita" => 0,
					//"estivo_invernale_struttura" => "e",
					//"costa_entroterra_localita" => "c",
					//"stato_referente" => 2,
					//"nome_categoria" => "discoteca"
				);

$params = array("id_tipostruttura-struttura" => 1);




// TEST VARI
//$bean = $Beaner->retrieve("A7B7Fotovideo", $params);
//$bean = $Beaner->retrieve("B7Struttura", array(79));
//$bean = $Beaner->retrieve("A7B7Struttura", $params);
//$bean = $Beaner->retrieve("A7B7Localita");
//$bean = $Beaner->retrieve("B7Localita", array('id_localita' => 35));
//$bean = $Beaner->retrieve("A7B7Evento");
//$bean = $Beaner->retrieve("Struttura", array("id_struttura" => 16));
//$bean = $Beaner->retrieve("Struttura", array(15), "IT");
//$bean = $Beaner->retrieve("A7B7Struttura");
//$bean = $Beaner->retrieve("A7B7Articolo");
//$bean = $Beaner->retrieve("A7Attivista");
//$bean = $Beaner->retrieve("A7Feedback");
//$bean = $Beaner->retrieve("A7Struttura", array("order_cre" => "nome_struttura"));
//$bean = $Beaner->retrieve("A7Utente");
//$bean = $Beaner->retrieve("Servizio", array(0));

// Query strane che difficilmente verranno fatte
//$bean = $Beaner->retrieve("A7B7Articolo");
//$bean = $Beaner->retrieve("B7Fotovideo", array("id_fotovideo" => 2004));
//$bean = $Beaner->retrieve("A7B7Fotovideo", array("id_localita-fotovideo" => 99999));

// TESTS VARI
/*$bean = $Beaner->retrieve("A7B7Articolo", array("speciale_articolo" => 1,
												"order_rnd" => "",
												"righe" => 1));*/

$bean = $Beaner->retrieve("A7B7Fotovideo", array("id_articolo-fotovideo" => 95,
												"formato_speciale_fotovideo" => 1,	
												"order_rnd" => "",
												"righe" => 1));


/*
$bean = $Beaner->filtered_list_build(	"IT",
										"A7B7Fotovideo",
										null,
										0,
										100,
										null,
										array(	array( "struttura" ),
												array( "id_tipostruttura" => 1 )));

*/


// Query da non fare ;)
//$bean = $Beaner->retrieve("A7Fotovideo"); //fallita (ha poco senso)!
//$bean = $Beaner->retrieve("A7Articolo"); //fallita (ha poco senso)!
}catch (DbConnException $e) {
	echo('Errore nella connessione al db');
}catch (DbSelectException $e) {
	echo('Errore nella selezione del db');
}
?>
<pre><?php print_r($bean); ?></pre>

















<?php
//Lista localitˆ
/*@@@  Tutte (salento)
*/
/*@@@  Per area (es. Da Otranto a Casalabate)
*/

//Lista strutture;
/*@@@  Filtrate per Localitˆ/categoria/tipo/servizi es. Gallipoli/musica/discoteca/raggae)
*/
//Localitˆ Ð tutte le strutture di gallipoli (gallerie, lidi, chiese, ecc)
//(Localitˆ)/categoria Ð tutte le strutture di musica di Gallipoli
//(Localitˆ)/tipo Ð tutte le strutture di un tipo (es. lidi) di Gallipoli
//(Localitˆ)/servizio Ð tutte le strutture di Gallipoli che fanno latino
//(Localitˆ)/tipo/servizio Ð tutte le discoteche che fanno latino
//Lista eventi,relativi ad un arco di tempo
/*@@@  Filtrati per localitˆ [ie. data+localitˆ. struttura], struttura/categoria/servizi, attivista
*/
//(Localitˆ) Ð Tutti gli eventi delle strutture in quella localitˆ (Programma)
//(Localitˆ)/categoria Ð tutti gli eventi di arte di una localitˆ
//(Localitˆ)/tipo Ð tutti gli eventi delle discoteche
//(Localitˆ)/servizio Ð tutti gli eventi latino di una localitˆ
//(Localitˆ)/tipo/servizio Ð tutti gli eventi delle discoteche che fanno latino
//Struttura Ð Tutti gli eventi di una struttura in particolare
//Struttura/servizio Ð gli eventi di una galleria restrinti solo al servizio ÒfotoÓ
//Attivista Ð tutti gli eventi di un attivista
//Lista attivisti
/*@@@  Filtrati per categoria/servizio/ [struttura+data] / [localitˆ+data] / evento
*/
//Categoria Ð Tutti gli attivisti che si occupano di arte;
//Servizio Ð Tutti gli attivisti che si occupano di fotografia;
//Struttura [+ data] Ð Tutti gli artisti di una discoteca (per un periodo);
//Struttura [+ data]/categoria Ð tutti gli artisti musicali di una discoteca;
//Struttura [+data]/servizio Ð tutti i dj di una discoteca (per un periodo)
//(Localitˆ) [+ data] Ð Tutti gli artisti di Gallipoli nella settimana di ferragosto;
//(Localitˆ) [+ data]/categoria Ð Tutti musicisti che suonano a Gallipoli (Ago)
//(Localitˆ) [+ data]/servizio Ð Tutti i fotografi di Gallipoli (Luglio);
//Evento Ð tutti gli artisti di un evento;
//Lista articoli:
/*@@@  Filtrati per ÒEntitˆ descrittivaÓ/categoria
*/
//Tutti gli articoli che non siano ÒhomeÓ (ordinati per data di inserimento)
//Localitˆ Ð Tutti gli articoli di Gallipoli
//(Localitˆ)/categoria Ð Tutti gli articoli del salento per la categoria arte
/*@@@  Opzionali (non molto utili Ð gli articoli dovrebbero essere  relativi alle loc)
*/
//ÒEntitˆÓ -  tutti gli articoli che girano intorno alla notte della taranta
//(ÒEntitˆÓ)/categoria Ð tutti gli articoli dellÕevento x nella categoria mare

//Lista foto:
//Lista utenti (per admin e statistiche)
?>