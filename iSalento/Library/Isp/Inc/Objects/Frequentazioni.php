<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Spggfrequentazioni - abbinata a Spiaggia
 */
class Spggfrequentazioni extends Isp_Db_Beaner_TblObject {
	public $ntt = "Spggfrequentazioni";
	// interni
	public $id_spggfrequentazioni;
	public $nome_spggfrequentazioni;

	public function get_id(){
		return $this->id_spggfrequentazioni;
	}
}
?>