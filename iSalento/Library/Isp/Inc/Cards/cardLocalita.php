<?php
// CARD LOCALITA'
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_localita",
"nome_localita",
"costa_entroterra_localita",
"rilevanza_localita",
"google_map_localita"
);
// campi della card completa
$extra_card_array = array();
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
// ARRAY PER LA LETTURA
$tbls_array = array("localita");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array();

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array('id_lcltarea' => 'arealocalita');



// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI?)
$del_tbls_array = array("localita", "feedback");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array(
array(	"struttura" => "id_localita",
		"articolo" => "id_localita",
		"fotovideo" => "id_localita"),
0);
?>