<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Servizio
 */
class Servizio extends Isp_Db_Beaner_TblObject {
	public $ntt = "Servizio";
	// interni
	public $id_servizio;
	public $nome_servizio;
	public $descrizione_servizio; 
	public $id_categoria; 
	// esterni
	public $nome_categoria;
	
	public function get_id(){
		return $this->id_servizio;
	}
}
?>