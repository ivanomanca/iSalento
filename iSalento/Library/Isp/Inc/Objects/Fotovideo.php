<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe Foto_video
 */
class Fotovideo extends Isp_Db_Beaner_TblObject {
	public $ntt = "Fotovideo";
	// interni
	public $id_fotovideo;
	public $data_inserimento_fotovideo;
	public $rilevanza_fotovideo;
	public $frequenza_aggiornamento_fotovideo;
	public $ultimo_aggiornamento_fotovideo;
	public $marker_fotovideo;
	public $stato_fotovideo;
	public $id_categoria;
	public $id_localita; //obbligatorio
	public $id_articolo;
	public $id_struttura;
	public $id_attivista;
	public $id_evento;
	public $home_localita_fotovideo;
	public $formato_speciale_fotovideo;
	public $username_utente;
	public $nome_file_fotovideo;
	// esterni
	public $nome_categoria;
	public $nome_localita;	//tabella localita
	public $nome_articolo;	//tabella articolo
	public $nome_struttura;	//tabella struttura
	public $nome_attivista;	//tabella attivista
	public $nome_evento;	//tabella evento

	public function get_id(){
		return $this->id_fotovideo;
	}
}
?>