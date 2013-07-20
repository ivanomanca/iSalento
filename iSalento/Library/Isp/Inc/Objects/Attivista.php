<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Attivista
 */
class Attivista extends Isp_Db_Beaner_TblObject {
	public $ntt = "Attivista";
	
	// interni
	public $id_attivista;
	public $nome_attivista; 
	public $email_attivista; 
	public $tel_attivista; 
	public $sito_attivista; 
	public $dati_visibili_attivista; 
	public $data_inserimento_attivista; 
	public $locale_forestiero_attivista;
	public $voti_attivista;
	public $rilevanza_attivista;
	public $username_utente;
	
	public function get_id(){
		return $this->id_attivista;
	}
}
?>