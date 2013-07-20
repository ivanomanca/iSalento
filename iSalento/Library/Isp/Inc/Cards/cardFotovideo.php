<?php
// CARD Fotovideo
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;

// SOLUZIONE AL PROBLEMA DELLE ENTITA' CONDENSATE
if(isset($entita)){
	switch ($entita){
		case "same" || "fotovideo":	$card_array = array("id_fotovideo",
											"data_inserimento_fotovideo",
											"rilevanza_fotovideo",
											"marker_fotovideo",
											"stato_fotovideo",
											"frequenza_aggiornamento_fotovideo",
											"ultimo_aggiornamento_fotovideo",
											"id_articolo",
											"id_localita",
											"id_struttura",
											"id_attivista",
											"id_evento",
											"home_localita_fotovideo",
											"username_utente",
											"id_categoria",
											"nome_categoria",
											"formato_speciale_fotovideo",
											"nome_file_fotovideo"
											);
							// campi della card completa
							$extra_card_array = array();
							// array dei nomi delle tabelle utili per il recupero dell'oggetto
							// e per il suo inserimento. Vanno messe in ordine di dipendenza!
							// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
							$tbls_array = array("fotovideo",
												"categoria"
												);
							break;

		default : 			$card_array = array("id_fotovideo",
												"data_inserimento_fotovideo",
												"rilevanza_fotovideo",
												"frequenza_aggiornamento_fotovideo",
												"ultimo_aggiornamento_fotovideo",
												"marker_fotovideo",
												"stato_fotovideo",
												"id_$entita",
												"nome_$entita",
												"username_utente",
												"home_localita_fotovideo",
												"id_categoria",
												"nome_categoria",
												"id_articolo",
												"formato_speciale_fotovideo",
												"nome_file_fotovideo"
												);
							// campi della card completa
							$extra_card_array = array();
							// array dei nomi delle tabelle utili per il recupero dell'oggetto
							// e per il suo inserimento. Vanno messe in ordine di dipendenza!
							// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
							$tbls_array = array("fotovideo",
												"categoria",
												"$entita"
												);
							break;
	}
}

// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_articolo" => array("fotovideo"),
"id_localita" => array("fotovideo"),
"id_struttura" => array("fotovideo"),
"id_attivista" => array("fotovideo"),
"id_evento" => array("fotovideo")
);


$del_tbls_array = array(
"fotovideo",
"tfv",
"feedback");

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();



//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
// id_entitˆ obbligatorio nella tabella Fotovideo
$del_trigger_array = array();

// array di where
//$whr_array = array("id_articolo_$entita" => $id_articolo);
?>