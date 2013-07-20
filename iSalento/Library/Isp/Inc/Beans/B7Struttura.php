<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/Bean.php");
/**
 * Bean struttura
 */
class B7Struttura extends Isp_Db_Beaner_Bean {
	
	public $Struttura;
	public $A7B7Articolo	= "NON CARICATO";
	public $A7Servizio		= "NON CARICATO";
	public $A7B7Fotovideo	= "NON CARICATO";
	public $A7Referente		= "NON CARICATO";
	public $A7Feedback		= "NON CARICATO";
	
	public $related_beans = array(	"A7B7Articolo",
									"A7Servizio",
									"A7B7Fotovideo",
									"A7Referente",
									"A7Feedback");
	
	public function __construct($Lang, $IDs, $from_ntt = "Struttura"){
		// passo la palla alla classe astratta
		parent::__construct("Struttura", $this->related_beans, $Lang, $IDs, $from_ntt);
	}
}
?>