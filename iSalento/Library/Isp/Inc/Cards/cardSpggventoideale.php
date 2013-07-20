<?php
// CARD SERVIZIO UTILIZZATA NELLA LETTURA
$last_id_index = 0;
$card_array = array(
"id_spggventoideale",
"nome_spggventoideale",
);
// campi della card completa
$extra_card_array = array();

// ARRAY PER LA LETTURA
$tbls_array = array("spggventoideale");
// PERCORSI PER LE QUERY INCROCIATE
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_struttura" => array("spggventoideale", "ventoidealespiaggia"));

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
"spggventoideale",
"ventoidealespiaggia");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();

?>