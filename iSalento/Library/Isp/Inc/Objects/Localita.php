<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe localita
 */
class Localita	extends Isp_Db_Beaner_TblObject {
	
	public $ntt = "Localita";
	public $id_localita;
	public $nome_localita;
	public $costa_entroterra_localita;
	public $rilevanza_localita;
	public $google_map_localita;
		
	public function get_id(){
		return $this->id_localita;
	}
}
?>