<?php
// CARD UTENTE UTILIZZATA NELLA LETTURA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"id_referente",
"ruolo_referente",
"mostra_contatti_al_pubblico_referente",
"note_referente",
"stato_referente",
"username_utente",
);
// campi della card completa
$extra_card_array = array();
// ARRAY PER LA LETTURA
$tbls_array = array("referente");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_struttura" 	=> array("referente", "referentestruttura"),
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();


// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array("referente", "referentestruttura");
//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();
?>