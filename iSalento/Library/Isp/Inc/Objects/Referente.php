<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Utente
 */
class Referente	extends Isp_Db_Beaner_TblObject {
	public $ntt = "Referente";
	// interni
	public $id_referente;
	public $ruolo_referente; 
	public $mostra_contatti_al_pubblico_referente;
	public $note_referente;
	public $stato_referente; 
	public $username_utente;

	public function get_id(){
		return $this->id_referente;
	}
}
?>