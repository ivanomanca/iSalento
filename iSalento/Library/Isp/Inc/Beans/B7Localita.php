<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/Bean.php");
/**
 * Bean localita
 */
class B7Localita extends Isp_Db_Beaner_Bean {

	public $Localita;
	public $A7Area		= "NON CARICATO";
	public $A7B7Articolo = "NON CARICATO"; //solo un Bean
	public $A7B7Fotovideo = "NON CARICATO";
	public $A7Feedback = "NON CARICATO";

	public $related_beans = array("A7Area",
											"A7B7Articolo",
											"A7B7Fotovideo",
											"A7Feedback");

	public function __construct($Lang, $IDs, $from_ntt = "Localita"){
		// passo la palla alla classe astratta
		parent::__construct("Localita", $this->related_beans, $Lang, $IDs, $from_ntt);
	}
}
?>