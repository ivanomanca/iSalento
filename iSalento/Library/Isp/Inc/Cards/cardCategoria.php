<?php
// CARD CATEGORIA UTILIZZATA NELLA LETTURA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_categoria",
"nome_categoria"
);
// campi della card completa
$extra_card_array = array();
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
// ARRAY PER LA LETTURA
$tbls_array = array("categoria");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_struttura" => array("categoria","tipostruttura"),
"id_referente" => array("categoria","tipostruttura", "referentestruttura")
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();

// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
);
//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
//indica la modifica da fare in tutte le tabelle dell'array iniziale
$del_trigger_array = array(
);
?>