<?php
/////////////////////////    LETTURA    ////////////////////////////////////////
// CARD SPIAGGIA UTILIZZATA NELLA LETTURA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
	"id_struttura",
	"lunghezza_spiaggia",
	"larghezza_spiaggia",
	"colore_spiaggia",
	"percent_libera_spiaggia",
	"fondale_spiaggia",
	"pulizia_acqua_spiaggia",
	"pulizia_sabbia_spiaggia",
	"voto_particolarita_spiaggia",
	"voto_accessibilita_spiaggia",
	"facilita_parcheggio_spiaggia",
	"voto_traspubblico_spiaggia",
	"sicurezza_spiaggia",
	"ingresso_spiaggia",
	"affollamento_spiaggia",
	"relax_spiaggia"
);
// campi della card completa
$extra_card_array = array();
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
// bisogna indicare anche se si parte da tabelle adiacenti! come ho fatto per localitˆ
$join_path = array(
"id_struttura" => array("spiaggia"),//tabella adiacente!
);
// IL PRIMO CAMPO SI RIFERISCE ALLA TABELLA PRINCIPALE
// ARRAY PER LA LETTURA
$tbls_array = array("spiaggia");

// DA SETTARE SE RAPPRESENTA L'ESPANSIONE DI UNA TABELLA MADRE.
$mother_table = 'struttura';

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array(	"id_spggventoideale" => "ventoidealespiaggia",
										"id_spggsuolo" => "suolospiaggia",
										"id_spggsport" => "sportspiaggia",
										"id_spggfrequentazioni" => "frequentazionispiaggia");

// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array(
"spiaggia",
"ventoidealespiaggia",
"suolospiaggia",
"sportspiaggia",
"frequentazionispiaggia");

//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
//indica la modifica da fare in tutte le tabelle dell'array iniziale
$del_trigger_array = array(
array(),
0);
?>