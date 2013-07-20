<?php
//require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Form_AddParagrafoArticolo extends Isp_Controller_Action_Instantiator{
	
	public $linkForm = "index.php?component=Crud&task=insert&crudNtt=Tea";
/*	public $ntt = null; // Nome entit� di provenienza
	public $idNtt = null;
	public $photoNtt = null; // Nome entit� di provenienza
	public $photoIdNtt = null;*/
							
	public function init($pag=null){
		// Manage Urls
		Isp_Loader::loadClass("Isp_Url");
		$pag->urlForm = new Isp_Url($this->linkForm);
		
		// If we're coming from an insert, notice the page of it
		// Crud sets ntt and idNtt
		/*$this->$ntt = $this->front->request->params['ntt'];
		
		$pag->idNtt = $this->front->request->params['id_struttura'];
		$pag->ntt = $this->$ntt;
		 
		/*if(isset($this->front->request->params['ntt']) and 
		   isset($this->front->request->params['idNtt'])){ 
			
		   	$ntt = $this->front->request->params['ntt'];
			$this->ntt = strtolower($ntt); // Avoid capital letters
			$this->idNtt = $this->front->request->params['idNtt'];
			$pag->ntt = $this->ntt;
			$pag->idNtt = $this->idNtt;
			
			// Update photo fw info as well - priority on photoNtt over ntt
			$this->photoNtt = $this->ntt;
			$this->photoIdNtt = $this->idNtt;
		}*/
			
		// Set forwards page settings.
		$this->loadForwardPages();
		return $pag;
	}
	
	/**
	 * @todo standardizzare la funzione per non far sbagliare a chi programma!
	 *
	 */
	public function loadForwardPages(){
			
		// Forward pages instructions to merge in the request
		$nextOkPage = array("page" => "ExtraHome",
						 	"pageType" => "Extra"
						 	);
		
		$nextKoPage = array("page" => "...",
							"pageType" => "...");

		$_SESSION["nextOkPage"] = $nextOkPage;				 	
		$_SESSION["nextKoPage"] = $nextKoPage;				 	
		
	}
	

}

?>