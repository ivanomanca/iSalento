<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento";

// Percorsi alle cartelle dei moduli
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Objmanager.php");
try{
	$g = Isp_Db_ObjManager::getInstance();
	}catch (DbConnException $e) {
		//rethrow it
        //throw $e;
    }catch (DbSelectException $e) {
        //rethrow it
        //throw $e;
    }
$arr = array("TEST Objmanager VUOTO");

/* TEST CARICAMENTO OGGETTO STRUTTURA @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

//$arr = $g->load_obj("Struttura", array(16));

/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/* TEST AGGIORNAMENTO SINGOLA TABELLA @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/*
$f_a = array(
	"id_struttura" => 79,
	"nome_struttura" => "Coccolocco",
	"giorno_notte_struttura" => "giorno",
	"indirizzo_zona_struttura" => "via nonloso 22, Ugento",
	//"google_map_struttura" => "cocolocogmap",
	"estivo_invernale_struttura" => "estivo",
	"sito_struttura" => "www.cocoloco.org",
	"giorni_apertura_struttura" => "giorniapertura",
	"orari_apertura_struttura" => "orarioapertura",
	"stato_struttura" => "approvato",
	"accetta_attivista_struttura" => "y",
	"policy_attivista_struttura" => "noninserite",
	"note_struttura" => "notedelcocoloco",
	"username_utente" => "dan",
	"id_localita" => 158,
	"id_tipostruttura" => 1,
	"id_servizio" => array(8, 9, 10)
	);

$arr = $g->update_obj_to_db("Struttura", $f_a);

*/
/* TEST INSERIMENTO SINGOLA TABELLA @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
$f_a = array(
	"nome_struttura" => "cocos",
	"giorno_notte_struttura" => "giorno",
	"indirizzo_zona_struttura" => "via nonloso 22, Ugento",
	//"google_map_struttura" => "cocolocogmap",
	"estivo_invernale_struttura" => "estivo",
	"sito_struttura" => "www.cocoloco.org",
	"giorni_apertura_struttura" => "giorniapertura",
	"orari_apertura_struttura" => "orari",
	"stato_struttura" => "approvato",
	"accetta_attivista_struttura" => "y",
	"policy_attivista_struttura" => "noninserite",
	"note_struttura" => "notedelcocoloco",
	"username_utente" => "dan",
	"id_localita" => 158,
	"id_tipostruttura" => 1,
	"id_servizio" => array(1, 2, 3, 4, 5, 6)
	);

$arr = $g->insert_obj_to_db("Struttura", $f_a);
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/* TEST CANCELLAZIONE TABELLE MULTIPLE DIPENDENTI @@@@@@@@@@@@@@@@@@*/
//$arr = $g->delete_object_from_db("Localita", array(113));
//$arr = $g->delete_object_from_db("Struttura", array(40));
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

/* TEST MANIPOLAZIONE OGGETTI @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
//$f_a = array(	"id_localita" => 105,
//				"nome_localita" => "Ivanoland",
//				"costa_entroterra" => "c",
//				"rilevanza_localita" => 2,
//				"google_map_localita" => "mappagoo");

//$arr = $g->create_obj("Localita", $f_a);
//$arr = $g->load_obj(array("Articolo", "Struttura"), array(15));
//$arr = $g->get_list_obj(array("Articolo","Struttura"), array("id_struttura" => 16));
//$arr = $g->get_list_obj(array("Fotovideo","Struttura"), array("id_struttura" => 16));
//$arr = $g->get_list_obj("Servizio", array("id_struttura" => 16));
//$arr = $g->get_list_obj("Tea", array("id_articolo" => 15));
//echo($g->err);
//$arr = $g->get_list_obj("Struttura", array(	"stato_struttura" => "b",
//											"estivo_invernale" => "i"),0, 5);
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

/* TEST UPDATE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*
$f_a = array(	"id_localita" => 12,
				"nome_localita" => "Otranto",
				"costa_entroterra" => "c",
				"rilevanza_localita" => 2,
				"google_map_localita" => "mappaotrantoitalia");

$arr = $g->update_obj_to_db("Localita", $f_a);
*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/* TEST UPDATE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*
$f_a = array(	"id_espansione" => 0,
				"id_articolo" => 0,
				"lingua_sigla_tea" => "it",
				"titolo_tea" => "parco naturale di portoselvaggio",
				"abstract_tea" => "un riassuntino...",
				"stato_tea" => "x",
				"descrizione_tea" => " bellisssimoooo",
				"autore_tea" => "ivo",
				"a_colpo_d_occhio_tea" => "x",
				"username" => "bao");

$arr = $g->update_obj_to_db("Tea", $f_a);
*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
?>
<pre><?php print_r($arr); ?></pre>
