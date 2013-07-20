<?php
// CARD SERVIZIO UTILIZZATA NELLA LETTURA
$last_id_index = 0;
$card_array = array(
"id_lcltarea",
"nome_lcltarea");
// campi della card completa
$extra_card_array = array();

// ARRAY PER LA LETTURA
$tbls_array = array("lcltarea");
// PERCORSI PER LE QUERY INCROCIATE
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_localita" 	=> array("lcltarea", "arealocalita"));

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array();

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();


//Cancellare anche i record dalla tabella "informa"
?>