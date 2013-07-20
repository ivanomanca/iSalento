<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Spggsport - abbinata a Spiaggia
 */
class Spggsport extends Isp_Db_Beaner_TblObject {
	public $ntt = "Spggsport";
	// interni
	public $id_spggsport;
	public $nome_spggsport;

	public function get_id(){
		return $this->id_spggsport;
	}
}
?>