<?php
// CARD TEA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 2;
$card_array = array(
"lingua_sigla_tea",
"id_tea",
"id_articolo",
"titolo_tea",
"abstract_tea",
"data_tea",
"stato_tea",
"descrizione_tea",
"autore_tea",
"a_colpo_d_occhio_tea",
"username_utente");
// campi della card completa
$extra_card_array = array();
// ARRAY PER LA LETTURA
$tbls_array = array("tea");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array();

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array("tea");
//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();
?>