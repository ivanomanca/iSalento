<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Utente
 */
class Utente extends Isp_Db_Beaner_TblObject {
	public $ntt = "Utente";
	// interni
	public $username_utente;
	public $crypted_password_utente;
	public $privilegi_utente;
	public $stato_utente;
	public $domanda_recovery_utente;
	public $data_registrazione_utente;
	public $nome_utente;
	public $cognome_utente;
	public $email_utente;
	public $emailconfirmed_utente;
	public $dati_visibili_utente;
	public $tel_utente;
	public $msn_utente;
	public $skype_utente;
	public $data_nascita_utente;
	public $provenienza_utente;
	public $passioni_utente;
	public $firma_utente;
	public $sito_utente;
	public $occupazione_utente;

	public function get_id(){
		return $this->username_utente;
	}
}
?>