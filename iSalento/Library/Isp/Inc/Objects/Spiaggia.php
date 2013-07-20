<?php
if(!class_exists("Isp_Db_Beaner_TblObject")){
	require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/TblObject.php");
}

/**
 * Classe spiaggia
 */
class Spiaggia	extends Isp_Db_Beaner_TblObject{
	public $ntt = "Spiaggia";
	// interni
	public $id_struttura;
	public $lunghezza_spiaggia;
	public $larghezza_spiaggia;
	public $colore_spiaggia;
	public $percent_libera_spiaggia;
	public $fondale_spiaggia;
	public $pulizia_acqua_spiaggia;
	public $pulizia_sabbia_spiaggia;
	public $voto_particolarita_spiaggia;
	public $voto_accessibilita_spiaggia;
	public $facilita_parcheggio_spiaggia;
	public $voto_traspubblico_spiaggia;
	public $sicurezza_spiaggia;
	public $ingresso_spiaggia;
	public $affollamento_spiaggia;
	public $relax_spiaggia;

	public function get_id(){
		return $this->id_struttura;
	}
}
?>