<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Spggventoideale - abbinata a Spiaggia
 */
class Spggventoideale extends Isp_Db_Beaner_TblObject {
	public $ntt = "Spggventoideale";
	// interni
	public $id_spggventoideale;
	public $nome_spggventoideale;

	public function get_id(){
		return $this->id_spggventoideale;
	}
}
?>