<?php
// SOLUZIONE ALLE ENTITA' FOTOVIDEO E ARTICOLO
// CHE HANNO IL PROBLEMA DELLA PROVENIENZA
$entita = "same";
if(is_array($ntt)){
	$entita = strtolower($ntt[1]);
	$ntt = $ntt[0];
}

// VARS
// percorso alla cartella delle configurazioni
$CONF_cp = $_SERVER['DOCUMENT_ROOT']."/Library/Isp/Inc/Cards/";
// includo la configurazione delle card e degli oggetti
//require_once($CONF_cp."confObjects.php");
require($CONF_cp."card".$ntt.".php");

$CONF_last_id_index = $last_id_index;		// indice dell'ultimo campo chiave
$CONF_table_name = $tbls_array[0];			// nome tabella principale entitˆ
$CONF_rel_table_name = $related_tbls_array;// nomi tabelle correlate
$CONF_id_name_array = $card_array;			// campi della card
$CONF_extra_name_array = $extra_card_array; // campi della extra_card
$CONF_tbls_array = $tbls_array;				// tabelle coinvolte in lettura
$CONF_del_tbls = $del_tbls_array;			// tabelle coinvolte nell'eliminazione
$CONF_del_trigger = $del_trigger_array;	// modifiche da apportare ad altre tabelle
$CONF_join_path_array = $join_path;			// percorsi da seguire per le query
if(isset($mother_table)){
	$CONF_mother_table = $mother_table;		// nome della eventuale tabella madre
}
?>