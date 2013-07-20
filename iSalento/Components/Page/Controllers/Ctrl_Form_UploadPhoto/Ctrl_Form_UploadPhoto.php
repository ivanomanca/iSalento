<?php
//require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Form_UploadPhoto extends Isp_Controller_Action_Instantiator{
	public $linkForm = "index.php?component=Media&task=uploadPhoto";
	public $ntt = null; // Nome entitˆ di provenienza
	public $idNtt = null;
								
	public function init($pag=null){
		// Manage Urls
		Isp_Loader::loadClass("Isp_Url");
		$pag->urlForm = new Isp_Url($this->linkForm);
			
		// Priority on photoNtt over ntt (ntt coming from an article)
		if(isset($this->front->request->params['photoNtt']) and 
		   isset($this->front->request->params['photoIdNtt'])){ 
			
			$ntt = $this->front->request->params['photoNtt'];
			$this->ntt = strtolower($ntt); // Avoid capital letters
			$this->idNtt = $this->front->request->params['photoIdNtt'];
			$pag->ntt = $this->ntt;
			$pag->idNtt = $this->idNtt;
			
		   	
		}elseif(isset($this->front->request->params['ntt']) and 
		   isset($this->front->request->params['idNtt'])){ 
			$ntt = $this->front->request->params['ntt'];
			$this->ntt = strtolower($ntt); // Avoid capital letters
			$this->idNtt = $this->front->request->params['idNtt'];
			$pag->ntt = $this->ntt;
			$pag->idNtt = $this->idNtt;
		   	
		 }	
		 
		 // Find out location of passed ntt 
		 if(isset($this->ntt)){
			// Istanzia il SimpleEnquirer 
			if($this->instantiate("Isp_Db_SimpleEnquirer")){
				$enquirer = $this->instancedObj;
				// Ottiene la tabella dell'entita
				$nttTable = $enquirer->getRecord($this->ntt, 
												 array("id_".$this->ntt => $this->idNtt));
				// Se l'entitˆ ha l'id_localita
				if(isset($nttTable['id_localita']))	{
					$pag->idLoc = $nttTable['id_localita'];
				}
			}
			
			
		
		 }
		 
		// Set forwarding pages
		$this->loadForwardPages();
		
		return $pag;

	}
	
	public function loadForwardPages(){
		// Forward pages instructions to merge in the request
		$nextOkPage = array("page" => "UploadPhoto",
						 	"pageType" => "Form");

		// Notify pics upload is referred to an entity				 	
		if(isset($this->ntt)){
			$nextOkPage = $nextOkPage + array(	"ntt" => $this->ntt,
						 						"idNtt" => $this->idNtt);
		}				
		 
		$nextKoPage = array("page" => "...",
							"pageType" => "...");

		$_SESSION["nextOkPage"] = $nextOkPage;				 	
		$_SESSION["nextKoPage"] = $nextKoPage;				 	
		
	}
	
	

}

?>