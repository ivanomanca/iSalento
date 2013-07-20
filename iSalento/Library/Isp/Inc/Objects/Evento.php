<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Evento
 */
class Evento extends Isp_Db_Beaner_TblObject {
	public $ntt = "Evento";
	// interni
	public $id_evento;
	public $nome_evento; 
	public $data_evento; 
	public $orario_evento; 
	public $rilevanza_evento; 
	public $data_inserimento_evento; 
	public $sito_evento; 
	public $counter_SMS_evento;
	public $username_utente;
	
	public function get_id(){
		return $this->id_evento;
	}
}
?>