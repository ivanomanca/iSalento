<?php
// CARD UTENTE UTILIZZATA NELLA LETTURA
// IL PRIMO CAMPO DEVE ESSERE L'ID!, IL SECONDO IL NOME O TITOLO ECC..
$last_id_index = 0;
$card_array = array(
"username_utente",
"crypted_password_utente",
"privilegi_utente",
"stato_utente",
"domanda_recovery_utente",
"data_registrazione_utente",
"nome_utente",
"cognome_utente",
"email_utente",
"emailconfirmed_utente",
"dati_visibili_utente",
"tel_utente",
"msn_utente",
"skype_utente",
"data_nascita_utente",
"provenienza_utente",
"passioni_utente",
"firma_utente",
"sito_utente",
"occupazione_utente"
);
// campi della card completa
$extra_card_array = array();
// ARRAY PER LA LETTURA
$tbls_array = array("utente");
// Se provieni dal campo "key" devi attraversare le tabelle $join_path["key"].
$join_path = array(
"id_serviziostruttura" => array("utente","informa")
);

/////////////////////////    SCRITTURA    //////////////////////////////////////
// ARRAY DELLE TABELLINE CORRELATE PER LA SCRITTURA
$related_tbls_array = array();

// ARRAY PER LA CANCELLAZIONE (NEI RECORD DELLE TABELLE DIPENDENTI)
$del_tbls_array = array();
//ARRAY DEGLI AGGIORNAMENTI DOPO LA CANCELLAZIONE
$del_trigger_array = array();

//Cancellazione non possibile, solo disabilitazione con cambio stato.

?>