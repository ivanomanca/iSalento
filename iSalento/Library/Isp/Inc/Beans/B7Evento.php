<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/Bean.php");
/**
 * Bean evento
 */
class B7Evento extends Isp_Db_Beaner_Bean {
	
	public $Evento;
	public $A7B7Articolo = "NON CARICATO";
	public $A7Servizio = "NON CARICATO";
	public $A7B7Fotovideo = "NON CARICATO";
	public $A7Feedback = "NON CARICATO";
	
	public $related_beans = array(	"A7B7Articolo",
									"A7Servizio",
									"A7B7Fotovideo",
									"A7Feedback");
	
	public function __construct($Lang, $IDs, $from_ntt = "Evento"){
		// passo la palla alla classe astratta
		parent::__construct("Evento", $this->related_beans, $Lang, $IDs, $from_ntt);
	}
}
?>