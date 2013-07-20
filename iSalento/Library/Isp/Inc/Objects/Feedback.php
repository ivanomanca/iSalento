<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Feedback
 */
class Feedback extends Isp_Db_Beaner_TblObject {
	public $ntt = "Feedback";
	// interni
	public $id_feedback;
	public $categoria_feedback;
	public $titolo_feedback;
	public $commento_feedback;
	public $data_feedback;
	public $visibile_feedback;
	public $note_feedback;
	public $username_utente;
	public $id_articolo;
	public $id_fotovideo;
	public $id_localita;
	public $id_struttura;
	public $id_evento;
	public $id_attivista;
	
	public function get_id(){
		return $this->id_feedback;
	}
}
?>