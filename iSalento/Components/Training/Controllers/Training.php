<?
Isp_Loader::loadClass("Isp_Controller_Action_Instantiator");


// Si pu˜ estendere solo 'Isp_Controller_Action' se non si deve accedere al db
class Training extends Isp_Controller_Action_Instantiator {
	public $stato = "train mode";
	
	// Contiene un p˜ tutto
	public function exampleMethod(){
			
	}
	
	//************* INGRESSI **************//
	// Accesso ai dati di richiesta
	public function usaRequest(){
		$datoDallaView = $this->front->request->params['dato'];
		return $datoDallaView;
	}
	
	
	//************* USA MODELS **************//
	public function usaLibreria(){
		// ES. Carica l'oggetto URL
		Isp_Loader::loadClass("Isp_Url_Image");
		$url = new Isp_Url("sito/pagina.htm");
		return $url;
	}
	
	// Interazioni col db
	public function usaDb(){
		// Istanzia il beaner (per ottenere tabelle e beans)
		if($this->instantiate("Isp_Db_Beaner")){
	        $beaner = $this->instancedObj;
        	$out = $beaner->retrieve("Localita", array('id_localita' => 16));
		}	
		
		 // Istanzio l'Objmanager (per scrivere tabelle nel db)
        if($this->instantiate("Isp_Db_ObjManager")){
			$objMananager = $this->instancedObj;
	        // Effettuo l'inserimento da Objmanager (ha anche altre funzioni)
	        $out = $objMananager->insert_obj_to_db("Localita", array("id_localita"=>30));
        }
        
		// Istanzia il SimpleEnquirer (per semplici liste tipo select)
		if($this->instantiate("Isp_Db_SimpleEnquirer")){
			$enquirer = $this->instancedObj;
			$out = $enquirer->getList("localita");
		}
	}
	
	
	//************* USCITE **************//
	public function usaForward(){
		// Forward all'errore
		$this->forward(	'errorTraining',
						'Error',
						'Error',
						array('failedReq' => $this->front->request,
							  'txtMessage'=>'forward da Training'));
		
		
		// Forward ad una pagina
		$this->forward(	'getPage',
						'Page',
						'Page',
						array('page' => 'ExtraHome',
							  'pageType'=>'Extra'));
	}
	
	public function usaPaginaModulo(){
		Isp_Loader::loadVistaObj("Pages", "Esempi", "TrainingPage", "Training");
		$pag = new TrainingPage();        
        $this->renderView($pag);
	}
		
	

}
?>
