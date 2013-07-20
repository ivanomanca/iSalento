<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Tea
 */
class Tea extends Isp_Db_Beaner_TblObject {
	public $ntt = "Tea";
	// interni
	public $id_tea;
	public $lingua_sigla_tea;
	public $id_articolo;
	public $titolo_tea; 
	public $abstract_tea; 
	public $data_tea; 
	public $stato_tea;
	public $descrizione_tea;
	public $autore_tea;
	public $a_colpo_d_occhio_tea;
	public $username_utente;
	
	public function get_id(){
		return array(	"id_tea" => $this->id_tea,
						"lingua_sigla_tea" => $this->lingua_sigla_tea,
						"id_articolo" => $this->id_articolo);
	}
}
?>