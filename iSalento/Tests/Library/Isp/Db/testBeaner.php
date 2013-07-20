<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/ivanomanca/Sites/iSalento";

// Percorsi alle classi
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner.php");

/****************************************************************************
	TEST DI CARICAMENTO BEAN
******************************************************************************/
$bean = array("TEST Beaner VUOTO");
try{
	$Beaner = Isp_Db_Beaner::getInstance();

// PARAMETRI FILTRO
$params = array(
					//"giorno_notte_struttura" => "giorno",
					//"order_cre" => "nome_struttura",
					//"order_rnd" => "",
					//"start" => 0,
					//"righe" => 2
					//"id_localita-struttura" => 156
					//"prova_campo_esterno-localita" => 0,
					//"estivo_invernale_struttura" => "e",
					//"costa_entroterra_localita" => "c",
					//"stato_referente" => 2,
					//"nome_categoria" => "discoteca"
					//"id_categoria-tipostruttura" => 2
				);

$params = array("atdistancefrom" => array('latgmap_struttura' => 37,
 														'lnggmap_struttura' => -122,
 														'rgmap' => 30));
// TEST VARI
//$bean = $Beaner->retrieve("A7B7Articolo");
//$bean = $Beaner->retrieve("A7Fotovideo");
//$bean = $Beaner->retrieve("A7B7Fotovideo");
//$bean = $Beaner->retrieve("B7Struttura", array(79));
//$bean = $Beaner->retrieve("A7B7Spiaggia", array("lunghezza_spiaggia" => 200));
//$bean = $Beaner->retrieve("A7B7Spiaggia", $params);
$bean = $Beaner->retrieve("A7B7Localita");
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
//$bean = $Beaner->retrieve("A7B7Fotovideo", array("id_localita-fotovideo" => //99999));


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

}catch (DbConnException $e) {
	echo('Errore nella connessione al db');
}catch (DbSelectException $e) {
	echo('Errore nella selezione del db');
}
?>
<pre><?php print_r($bean); ?></pre>

















<?php
//Lista localit�
/*@@@  Tutte (salento)
*/
/*@@@  Per area (es. Da Otranto a Casalabate)
*/

//Lista strutture;
/*@@@  Filtrate per Localit�/categoria/tipo/servizi es. Gallipoli/musica/discoteca/raggae)
*/
//Localit� � tutte le strutture di gallipoli (gallerie, lidi, chiese, ecc)
//(Localit�)/categoria � tutte le strutture di musica di Gallipoli
//(Localit�)/tipo � tutte le strutture di un tipo (es. lidi) di Gallipoli
//(Localit�)/servizio � tutte le strutture di Gallipoli che fanno latino
//(Localit�)/tipo/servizio � tutte le discoteche che fanno latino
//Lista eventi,relativi ad un arco di tempo
/*@@@  Filtrati per localit� [ie. data+localit�. struttura], struttura/categoria/servizi, attivista
*/
//(Localit�) � Tutti gli eventi delle strutture in quella localit� (Programma)
//(Localit�)/categoria � tutti gli eventi di arte di una localit�
//(Localit�)/tipo � tutti gli eventi delle discoteche
//(Localit�)/servizio � tutti gli eventi latino di una localit�
//(Localit�)/tipo/servizio � tutti gli eventi delle discoteche che fanno latino
//Struttura � Tutti gli eventi di una struttura in particolare
//Struttura/servizio � gli eventi di una galleria restrinti solo al servizio �foto�
//Attivista � tutti gli eventi di un attivista
//Lista attivisti
/*@@@  Filtrati per categoria/servizio/ [struttura+data] / [localit�+data] / evento
*/
//Categoria � Tutti gli attivisti che si occupano di arte;
//Servizio � Tutti gli attivisti che si occupano di fotografia;
//Struttura [+ data] � Tutti gli artisti di una discoteca (per un periodo);
//Struttura [+ data]/categoria � tutti gli artisti musicali di una discoteca;
//Struttura [+data]/servizio � tutti i dj di una discoteca (per un periodo)
//(Localit�) [+ data] � Tutti gli artisti di Gallipoli nella settimana di ferragosto;
//(Localit�) [+ data]/categoria � Tutti musicisti che suonano a Gallipoli (Ago)
//(Localit�) [+ data]/servizio � Tutti i fotografi di Gallipoli (Luglio);
//Evento � tutti gli artisti di un evento;
//Lista articoli:
/*@@@  Filtrati per �Entit� descrittiva�/categoria
*/
//Tutti gli articoli che non siano �home� (ordinati per data di inserimento)
//Localit� � Tutti gli articoli di Gallipoli
//(Localit�)/categoria � Tutti gli articoli del salento per la categoria arte
/*@@@  Opzionali (non molto utili � gli articoli dovrebbero essere  relativi alle loc)
*/
//�Entit�� -  tutti gli articoli che girano intorno alla notte della taranta
//(�Entit��)/categoria � tutti gli articoli dell�evento x nella categoria mare

//Lista foto:
//Lista utenti (per admin e statistiche)
?>