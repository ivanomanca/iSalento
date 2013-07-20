<?php
// CARD FEEDBACK
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_feedback",
"categoria_feedback",
"titolo_feedback",
"commento_feedback",
"data_feedback",
"visibile_feedback",
"note_feedback",
"username_utente",
"id_articolo",
"id_fotovideo",
"id_localita",
"id_struttura",
"id_evento",
"id_attivista",
"lingua_sigla_feedback"
);
// campi della card completa
$extra_card_array = array();
// array dei nomi delle tabelle utili per il recupero dell'oggetto
// e per il suo inserimento. Vanno messe in ordine di dipendenza!
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
$tbls_array = array("feedback");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array();

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();



$del_tbls_array = array("feedback");




//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
// id_entitˆ obbligatorio nella tabella foto_video
$del_trigger_array = array();

// array di where
//$whr_array = array("id_articolo_$entita" => $id_articolo);
?>