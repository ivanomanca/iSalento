<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/Bean.php");

/**
 * Bean spiaggia
 */
class B7Spiaggia extends Isp_Db_Beaner_Bean {

	public $Spiaggia;
	public $Struttura;
	// molti a molti
	public $A7Spggventoideale	= "NON CARICATO";
	public $A7Spggsuolo			= "NON CARICATO";
	public $A7Spggsport			= "NON CARICATO";
	public $A7Spggfrequentazioni= "NON CARICATO";
	// correlati
	public $A7B7Articolo		= "NON CARICATO";
	public $A7Servizio		= "NON CARICATO";
	public $A7B7Fotovideo	= "NON CARICATO";
	public $A7Referente		= "NON CARICATO";
	public $A7Feedback		= "NON CARICATO";

	public $related_beans = array("Spiaggia",
											"A7Spggventoideale",
											"A7Spggsuolo",
											"A7Spggsport",
											"A7Spggfrequentazioni",
											"A7B7Articolo",
											"A7Servizio",
											"A7B7Fotovideo",
											"A7Referente",
											"A7Feedback");

	public function __construct($Lang, $IDs, $from_ntt = "Struttura"){
		// passo la palla alla classe astratta
		parent::__construct("Struttura", $this->related_beans,
		$Lang, $IDs, $from_ntt);
	}
}
?>