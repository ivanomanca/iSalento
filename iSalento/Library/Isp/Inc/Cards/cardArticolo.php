<?php
// CARD ARTICOLO
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;


// SOLUZIONE AL PROBLEMA DELLE ENTITA' CONDENSATE
if(isset($entita)){
	switch ($entita){
		case "same" || "articolo" :	$card_array = array(
							"id_articolo",
							"rilevanza_articolo",
							"id_categoria",
							"id_localita",
							"id_struttura",
							"id_evento",
							"id_attivista",
							"speciale_articolo",
							"schedahome_entita_articolo"
							);
							// campi della card completa
							$extra_card_array = array();
							// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
							$tbls_array = array(
							"articolo",
							"categoria"
							);
							break;
		default : 			$card_array = array(
							"id_articolo",
							"rilevanza_articolo",
							"id_categoria",
							"id_$entita",
							"nome_categoria",
							"nome_$entita",
							"speciale_articolo",
							"schedahome_entita_articolo"
							);
							// campi della card completa
							$extra_card_array = array();
							// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
							$tbls_array = array(
							"articolo",
							"categoria",
							"$entita"
							);
							break;
	}
}

// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_localita" => array("articolo"),
"id_struttura" => array("articolo"),
"id_attivista" => array("articolo"),
"id_evento" => array("articolo")
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


$del_tbls_array = array(
"articolo",
"tea",
"feedback");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
// id_entitˆ obbligatorio nella tabella foto_video
$del_trigger_array = array(
array(	"fotovideo" => "id_articolo"), null);
?>