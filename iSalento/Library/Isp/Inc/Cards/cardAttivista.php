<?php
// CARD ATTIVISTA UTILIZZATA NELLA LETTURA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_attivista",
"nome_attivista",
"email_attivista",
"tel_attivista",
"sito_attivista",
"dati_visibili_attivista",
"data_inserimento_attivista",
"locale_forestiero_attivista",
"voti_attivista",
"rilevanza_attivista",
"username_utente",
"id_tipoattivista",
"nome_tipoattivista"
);
// campi della card completa
$extra_card_array = array();
// ARRAY PER LA LETTURA
$tbls_array = array("attivista", "tipoattivista");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_servizio" => array("attivista","attivistaservizio"),
"id_evento" => array("attivista", "attivistaevento", "evento", "servizioevento"),
"id_struttura" => array("attivista", "attivistaevento","evento", "servizioevento"),
"id_localita" => array("attivista", "attivistaevento","evento")
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
"attivista",
"attivistaservizio",
"attivistaevento",
"feedback");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array(
array(	"articolo" => "id_localita",
		"fotovideo" => "id_localita"),
0);
?>