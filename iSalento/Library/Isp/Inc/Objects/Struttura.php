<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe struttura
 */
class Struttura	extends Isp_Db_Beaner_TblObject{
	public $ntt = "Struttura";
	// interni
	public $id_struttura;
	public $nome_struttura;
	public $giorno_notte_struttura;
	public $indirizzo_zona_struttura;
	public $latgmap_struttura;
	public $lnggmap_struttura;
	public $estivo_invernale_struttura;
	public $sito_struttura;
	public $giorni_apertura_struttura;
	public $orari_apertura_struttura;
	public $stato_struttura;
	public $data_inserimento_struttura;
	public $accetta_attivista_struttura;
	public $policy_attivista_struttura;
	public $note_struttura;
	public $username_utente;
	public $id_localita;
	public $id_tipostruttura;
	// esterni
	public $nome_tipostruttura;
	public $nome_localita;
	// campi utili
	public $gmapdistance;

	public function get_id(){
		return $this->id_struttura;
	}
}
?>