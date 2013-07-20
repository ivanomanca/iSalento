<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Tfv
 */
class Tfv extends Isp_Db_Beaner_TblObject {
	public $ntt = "Tfv";
	// interni
	public $lingua_sigla_tfv;
	public $id_fotovideo;
	public $nome_tfv;
	public $didascalia_tfv;
	public $data_tfv;
	public $stato_tfv;
	public $username_utente;
	
	public function get_id(){
		return array(	"lingua_sigla_tfv" => $this->lingua_sigla_tea,
						"id_fotovideo" => $this->id_fotovideo);
	}
}
?>