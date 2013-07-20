<?php
// CARD STRUTTURA UTILIZZATA NELLA LETTURA
$last_id_index = 0;
$card_array = array(
"id_evento",
"nome_evento",
"data_evento",
"orario_evento",
"rilevanza_evento",
"data_inserimento_evento",
"sito_evento",
"counter_SMS_evento",
"username_utente"
);
// campi della card completa
$extra_card_array = array();
// array dei nomi delle tabelle utili per il recupero dell'oggetto
// e per il suo inserimento. Vanno messe in ordine di dipendenza!
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
// ARRAY PER LA LETTURA
$tbls_array = array("evento");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_servizio" => array("evento", "servizioevento"),
"id_struttura" => array("evento", "servizioevento"),
"id_attivista" => array("evento", "attivistaevento")
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();



// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
"evento",
"servizioevento",
"attivistaevento",
"feedback");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array(
array(	"articolo" => "id_localita",
		"fotovideo" => "id_localita"),
0);
?>