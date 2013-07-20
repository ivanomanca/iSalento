<?php
// CARD FEEDBACK
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_tipostruttura",
"nome_tipostruttura",
"descrizione_tipostruttura",
"id_categoria"
);
// campi della card completa
$extra_card_array = array();
// array dei nomi delle tabelle utili per il recupero dell'oggetto
// e per il suo inserimento. Vanno messe in ordine di dipendenza!
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
$tbls_array = array("tipostruttura");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array();

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();

$del_tbls_array = array();

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
// id_entitˆ obbligatorio nella tabella foto_video
$del_trigger_array = array();
?>