<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/Bean.php");
/**
 * Bean Articolo
 */
class B7Articolo extends Isp_Db_Beaner_Bean {
	
	public $Articolo;
	public $A7Tea;
	public $A7B7Fotovideo	= "NON CARICATO";
	public $A7Feedback		= "NON CARICATO";
	public $related_beans = array(	"A7B7Fotovideo",
									"A7Feedback");
	
	public function __construct($Lang, $IDs, $from_ntt = "Articolo"){
		// passo la palla alla classe astratta
		parent::__construct("Articolo", $this->related_beans, $Lang, $IDs, $from_ntt);
		
		// entitˆ Tea che non viene prodotta nell'abstract
		$this->A7Tea = $this->beaner->build(	$this->Lang,
												"A7Tea",
												$this->IDs,
												$this->bean_ntt);
	}
}
?>