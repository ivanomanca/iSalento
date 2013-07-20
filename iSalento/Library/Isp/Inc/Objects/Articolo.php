<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}
/**
 * Classe Articolo
 */
class Articolo extends Isp_Db_Beaner_TblObject {
	public $ntt = "Articolo";
	//interni
	public $id_articolo;
	public $rilevanza_articolo;
	public $id_categoria;
	public $id_localita;
	public $id_struttura;
	public $id_evento;
	public $id_attivista;
	public $speciale_articolo;
	public $schedahome_entita_articolo;
	//esterni
	public $nome_categoria;
	
	public function get_id(){
		return $this->id_articolo;
	}
}
?>