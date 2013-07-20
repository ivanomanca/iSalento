<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Area
 */
class Area extends Isp_Db_Beaner_TblObject {
	public $ntt = "Area";
	// interni
	public $id_lcltarea;
	public $nome_lcltarea;

	public function get_id(){
		return $this->id_lcltarea;
	}
}
?>