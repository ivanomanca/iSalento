<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Spggsuolo - abbinata a Spiaggia
 */
class Spggsuolo extends Isp_Db_Beaner_TblObject {
	public $ntt = "Spggsuolo";
	// interni
	public $id_spggsuolo;
	public $tipo_spggsuolo;

	public function get_id(){
		return $this->id_spggsuolo;
	}
}
?>