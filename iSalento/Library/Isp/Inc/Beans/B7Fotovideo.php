<?php
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/Beaner/Bean.php");
/**
 * Bean foto_video
 */
class B7Fotovideo extends Isp_Db_Beaner_Bean {
	
	public $Fotovideo;
	public $Tfv;
	public $A7Feedback = "NON CARICATO";
	
	public $related_beans = array("A7Feedback");
	
	public function __construct($Lang, $IDs, $from_ntt = "Fotovideo"){
		// passo la palla alla classe astratta
		parent::__construct("Fotovideo", $this->related_beans, $Lang, $IDs, $from_ntt);
		
		// entitˆ Tfv che non viene prodotta nell'abstract
		$this->Tfv = $this->beaner->build(	$this->Lang,
										"Tfv",
										$this->IDs,
										$this->bean_ntt);
	}
}
?>