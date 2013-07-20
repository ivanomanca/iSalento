<?php
// CARD SERVIZIO UTILIZZATA NELLA LETTURA
$last_id_index = 0;
$card_array = array(
"id_servizio",
"nome_servizio",
"descrizione_servizio",
"id_categoria",
"nome_categoria",
"descrizione_servizio"
);
// campi della card completa
$extra_card_array = array();

// ARRAY PER LA LETTURA
$tbls_array = array("servizio","categoria");
// PERCORSI PER LE QUERY INCROCIATE
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_struttura" 	=> array("servizio", "serviziostruttura"),
"id_evento" 	=> array("servizio", "servizioevento"),
"id_attivista" 	=> array("servizio", "attivistaservizio")
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
"servizio",
"servizioevento",
"attivistaservizio",
"serviziostruttura");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();


//Cancellare anche i record dalla tabella "informa"
?>