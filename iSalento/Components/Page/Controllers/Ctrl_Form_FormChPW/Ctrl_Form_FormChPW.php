<?php
/**
 * Controllore specifico di pagina.
 */
class Ctrl_Form_FormChPW extends Isp_Controller_Action_Instantiator{

	public $urlNext = "index.php?component=Authenticate&task=changePW";

	public function init($pag = null){
		// Iserisco il link per la registrazione
		$pag->urlNext = $this->urlNext;
		// Se provengo da un cambio avvenuto
		if(isset($this->front->request->params['ntt']) &&
			isset($this->front->request->params['idNtt']) &&
			$this->front->request->params['ntt'] == 'Utente' &&
			$this->front->request->params['idNtt'] == 'Updated'){
				$pag->changePwOk = true;
		}else $pag->changePwOk = false;
		return $pag;
	}
}

?>