<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Extra_TestPage extends Isp_Controller_Action_Instantiator{
	
	public function init(){
		echo "Controller specifico di pagina istanziato!";
		$page = $this->front->request->params['instancedPage'];

	}
	
}

?>