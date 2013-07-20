<?php
/////////////////////////    LETTURA    ////////////////////////////////////////
// CARD STRUTTURA UTILIZZATA NELLA LETTURA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_struttura",
"nome_struttura",
"giorno_notte_struttura",
"indirizzo_zona_struttura",
"latgmap_struttura",
"lnggmap_struttura",
"estivo_invernale_struttura",
"sito_struttura",
"giorni_apertura_struttura",
"orari_apertura_struttura",
"stato_struttura",
"data_inserimento_struttura",
"accetta_attivista_struttura",
"policy_attivista_struttura",
"note_struttura",
"username_utente",
"id_localita",
"id_tipostruttura",
"nome_localita",
"nome_tipostruttura",
"descrizione_tipostruttura"
);
// campi della card completa
$extra_card_array = array();
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
// bisogna indicare anche se si parte da tabelle adiacenti! come ho fatto per localitˆ
$join_path = array(
"id_localita" => array("struttura"),//tabella adiacente!
"id_articolo" => array("struttura"),//tabella adiacente!
"id_tipostruttura" => array("struttura"), // tabella adiacente!
"id_referente" => array("struttura","referentestruttura"),
"id_categoria" => array("struttura","tipostruttura")
);
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
// ARRAY PER LA LETTURA
$tbls_array = array("struttura", "tipostruttura", "localita");



/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array("id_servizio" => "serviziostruttura");

// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
"struttura",
"referentestruttura",
"serviziostruttura",
"feedback");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
//indica la modifica da fare in tutte le tabelle dell'array iniziale
$del_trigger_array = array(
array(	"articolo" => "id_localita",
		"fotovideo" => "id_localita"),
0);
//Cancellare anche i record dalla tabella "informa"

?>