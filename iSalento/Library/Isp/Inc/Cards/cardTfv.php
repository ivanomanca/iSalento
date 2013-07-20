<?php
// CARD TFV
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 1;
$card_array = array(
"id_fotovideo",
"lingua_sigla_tfv",
"nome_tfv",
"didascalia_tfv",
"data_tfv",
"stato_tfv",
"username_utente");
// campi della card completa
$extra_card_array = array();
// ARRAY PER LA LETTURA
$tbls_array = array("tfv");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array();

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array("tfv");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();
?>