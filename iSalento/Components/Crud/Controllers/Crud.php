<?
Isp_Loader::loadClass("Isp_Controller_Action_Instantiator");

/**
 * CRUD actions controller (insert, update, delete)
 * @todo forward in caso di successo
 */
class Crud extends Isp_Controller_Action_Instantiator {
	private $idInserted;
	private $idUpdated;
	private $idDeleted;

	private $idInsertedArray = array();
	private $idUpdatedArray = array();
	private $idDeletedArray = array();

	private $multipleTableSimbol = "**";
	private $MultipleInsertString = "MORE#";

	private $idIns = 'idInserted';
	private $idUpd = 'idUpdated';
	private $idDel = 'idDeleted';

    /**
     * Inserisce dati nel db
     * Ricava gli ingressi dalla request del front
     * params['crudNtt']
     * @todo controllo input!
     * @todo uso della view!
     *
     * @return void (forward)
     */
    public function insert() {

    	// entitˆ da inserire
    	$ntt;
    	$leakedParams = $this->getParamsUnsetRouting();
	if(isset($leakedParams['crudNtt'])) {
		$ntt = $leakedParams['crudNtt'];
    	if(strpos($ntt, $this->multipleTableSimbol) === false) {
    		// ENTITA' UNICA
	      // qui va chiamata la funzione per il controllo input
			$cecked_input = $leakedParams;
			// inserisco nel Db
			$insertOk = $this->insertSingleNtt($ntt, $cecked_input);
			if($insertOk === false){
				// inserimento fallito
			}else{
				// inserimento riuscito
				// recupero l'id dell'entitˆ inserita
				$this->idInserted = $this->instancedObj->id_performed;
				// Next page + id entitˆ inserita
				$fwParams =	$_SESSION['nextOkPage']
								+ array(	'ntt' => $ntt,
											'idNtt' => $this->idInserted);
				// adesso usa la view!
				$this->forward("getPage","Page", null, $fwParams);
			}
    	}else{
	    	// ENTITA' MULTIPLA
	    	$ntt = explode($this->multipleTableSimbol, $ntt);
		   // qui va chiamata la funzione per il controllo input
			$cecked_input_array = $leakedParams;

			// prima entitˆ (principale)
			$first = true;
	 		foreach($ntt as $nttName){
	 			$mult = $this->MultipleInsertString.$nttName;
	 			if (!$first && key_exists($mult, $cecked_input_array)) {
	 				// SERIE DI ISTANZE
					// se non mi trovo nella tabella principale,
	 				// e sono in un inserimento multiplo della stessa entitˆ...
	 				// recupero l'id principale e le metto nel nuovo $ceckedInput
					$cecked_input_mult = $cecked_input_array;
					$inputs_ntt = $cecked_input_array[$mult] + $cecked_input_mult;
	 				for($i = 0; $i < sizeof($cecked_input_array[$mult]); $i++){
	 					$params_ntt = $inputs_ntt[$i];
	 					$cecked_input = $cecked_input_mult + $params_ntt;
	 					$insertOk = $this->insertSingleNtt($nttName, $cecked_input);
						if($insertOk === false){
							// inserimento fallito
						}else{
							// inserimento riuscito
							// recupero l'id dell'entitˆ inserita e lo accodo
							array_push(	$this->idInsertedArray,
											$this->instancedObj->id_performed);
						}
	 				}
	 			}else{
	 				// SINGOLA ENTITA'
		 			$cecked_input = $cecked_input_array;
					// inserisco nel Db
					$insertOk = $this->insertSingleNtt($nttName, $cecked_input);
					if($insertOk === false){
						// inserimento fallito
					}else{
						// inserimento riuscito
						// recupero l'id dell'entitˆ inserita e lo accodo
						array_push(	$this->idInsertedArray,
										$this->instancedObj->id_performed);
						if($first){
							$cecked_input_array = $insertOk;
			    			$first = false;
						}
					}
	 			}
	 		}
			// Next page + id entitˆ inserita (la prima per convenzione)
			$fwParams = $_SESSION['nextOkPage']
							+ array(	'ntt' => $ntt[0],
										'idNtt' => $this->idInsertedArray[0]);
			// adesso usa la view!
			$this->forward("getPage","Page", null, $fwParams);
    	}
    	}else {/* non  stata specificata l'entitˆ da inserire*/}
    }

    /**
     * Aggiorna dati nel db
     * Ricava gli ingressi dalla request del front
     *
     * @return void (forward)
     */
    public function update() {
		// entitˆ da aggiornare
		$leakedParams = $this->getParamsUnsetRouting();
    	$ntt = $leakedParams['crudNtt'];
    	if(strpos($ntt, $this->multipleTableSimbol) === false) {
    		// ENTITA' UNICA
	      // qui va chiamata la funzione per il controllo input
			$cecked_input = $leakedParams;
			// aggiorno nel Db
			$updateOk = $this->updateSingleNtt($ntt, $cecked_input);
			if($updateOk === false){
				// aggiornamento fallito
			}else{
				// aggiornamento riuscito
				// Next page + notifica avvenuto aggiornamento
				$fwParams =	$_SESSION['nextOkPage']
								+ array(	'ntt' => $ntt,
											'idNtt' => 'Updated');
				// adesso usa la view!
				$this->forward("getPage","Page", null, $fwParams);
			}
    	}else{
	    	// ENTITA' MULTIPLA
	    	$ntt = explode($this->multipleTableSimbol, $ntt);
		   // qui va chiamata la funzione per il controllo input
			$cecked_input_array = $leakedParams;
			// prima entitˆ (principale)
			$first = true;
	 		foreach($ntt as $nttName){
	 			$mult = $this->MultipleInsertString.$nttName;
	 			if (!$first && key_exists($mult, $cecked_input_array)) {
	 				// SERIE DI ISTANZE
					// se non mi trovo nella tabella principale,
	 				// e sono in un aggiornamento multiplo della stessa entitˆ...
	 				// recupero l'id principale e le metto nel nuovo $ceckedInput
					$cecked_input_mult = $cecked_input_array;
					$inputs_ntt = $cecked_input_array[$mult] + $cecked_input_mult;
	 				for($i = 0; $i < sizeof($cecked_input_array[$mult]); $i++){
	 					$params_ntt = $inputs_ntt[$i];
	 					$cecked_input = $cecked_input_mult + $params_ntt;
	 					// aggiorno
	 					$updateOk = $this->updateSingleNtt($nttName, $cecked_input);
						if($updateOk === false){
							// aggiornamento fallito
						}else{
							// aggiornamento riuscito
							// recupero l'id dell'entitˆ aggiornata e lo accodo
							array_push(	$this->idUpdatedArray, 'Updated');
						}
	 				}
	 			}else{
	 				// SINGOLA ENTITA'
		 			$cecked_input = $cecked_input_array;
					// aggiorno nel Db
					$updateOk = $this->updateSingleNtt($nttName, $cecked_input);
					if($updateOk === false){
						// aggiornamento fallito
					}else{
						// aggiornamento riuscito
						// recupero l'id dell'entitˆ aggiornata e lo accodo
						array_push(	$this->idUpdatedArray, 'Updated');
						if($first){
							$cecked_input_array = $updateOk;
			    			$first = false;
						}
					}
	 			}
	 		}
			// Next page + id entitˆ inserita (la prima per convenzione)
			$fwParams = $_SESSION['nextOkPage']
							+ array(	'ntt' => $ntt[0],
										'idNtt' => $this->idUpdated[0]);
			// adesso usa la view!
			$this->forward("getPage","Page", null, $fwParams);
    	}
    }

    /**
     * Elimina dati dal db
     * Ricava gli ingressi dalla request del front
     *
     * @return void (forward)
     */
    public function delete() {
    	// entitˆ da eliminare
    	$leakedParams = $this->getParamsUnsetRouting();
    	$ntt = $leakedParams['crudNtt'];
		// qui va chiamata la funzione per il controllo input
		$cecked_input = $leakedParams;
		// elimino
      $deletedOk = $this->deleteSingleNtt($ntt, $cecked_input);
			if($deletedOk === false) {
				// eliminazione fallita
			} else {
				// eliminazione riuscita
				$this->idDeleted = $this->instancedObj->id_performed;
				// Next page + id entitˆ inserita (la prima per convenzione)
				$fwParams = $_SESSION['nextOkPage']
								+ array(	'ntt' => $ntt,
											'idNtt' => $this->idDeleted);
				// adesso usa la view!
				$this->forward("getPage","Page", null, $fwParams);
			}
    }


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//	UTILITIES functions
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	/**
	 * Inserisce l'entitˆ nel Db
	 * con i parametri all'interno di $cecked_input
	 *
	 * Forwarda e ritorna falso in caso di errore,
	 * e l'id della nuova entitˆ in caso di successo.
	 *
	 * @param String $ntt
	 * @param Array $cecked_input
	 * @return bool/idInserted
	 */
	private function insertSingleNtt($ntt, $cecked_input){
		// istanzio l'Objmanager
	 	if($this->instantiate("Isp_Db_ObjManager")){
	   	// Effettuo l'inserimento da Objmanager
	     	$out = $this->instancedObj->insert_obj_to_db($ntt, $cecked_input);
	     	if($out === false){
	     		$this->forward('crudError', 'Error', 'Error',
									array('failedReq' => $this->front->request,
											'errArray' => $this->instancedObj->errorsArray
											));
	     	}
			return $out;
	 	}
	}

	/**
	 * Aggiorna l'entitˆ nel Db
	 * con i parametri all'interno di $cecked_input
	 *
	 * Forwarda e ritorna falso in caso di errore,
	 * e l'id della entitˆ aggiornata in caso di successo.
	 *
	 * @param String $ntt
	 * @param Array $cecked_input
	 * @return bool/idUpdated
	 */
	private function updateSingleNtt($ntt, $cecked_input){
		// istanzio l'Objmanager
	 	if($this->instantiate("Isp_Db_ObjManager")){
	   	// Effettuo l'aggiornamento da Objmanager
	     	$out = $this->instancedObj->update_obj_to_db($ntt, $cecked_input);
	     	if($out === false){
	     		$this->forward('crudError', 'Error', 'Error',
									array('failedReq' => $this->front->request,
											'errArray' => $this->instancedObj->errorsArray
											));
	     	}
			return $out;
	 	}
	}

	/**
	 * Elimina l'entitˆ nel Db
	 * con i parametri all'interno di $cecked_input
	 *
	 * Forwarda e ritorna falso in caso di errore,
	 * e l'id della entitˆ eliminata in caso di successo.
	 *
	 * @param String $ntt
	 * @param Array $cecked_input
	 * @return bool/idUpdated
	 */
	private function deleteSingleNtt($ntt, $cecked_input){
		// istanzio l'Objmanager
	 	if($this->instantiate("Isp_Db_ObjManager")){
	   	// Effettuo l'eliminazione da Objmanager
	     	$out = $this->instancedObj->delete_object_from_db($ntt, $cecked_input);
	     	if($out === false){
	     		$this->forward('crudError', 'Error', 'Error',
									array('failedReq' => $this->front->request,
											'errArray' => $this->instancedObj->errorsArray
											));
	     	}
			return $out;
	 	}
	}

	/**
	 * Ritorna l'array dei parametri filtrato dai parametri di routing
	 *
	 * @return array
	 */
	private function getParamsUnsetRouting(){
		// recupero parametri puliti da routing
    	$leakedParams = $this->front->request->params;
    	if(isset($leakedParams['component']))
    		unset($leakedParams['component']);
    	if(isset($leakedParams['ctrl']))
    		unset($leakedParams['ctrl']);
    	if(isset($leakedParams['task']))
    		unset($leakedParams['task']);
    	// ...
    	if(isset($leakedParams['debug_fastfile']))
    		unset($leakedParams['debug_fastfile']);
    	if(isset($leakedParams['debug_host']))
    		unset($leakedParams['debug_host']);
    	if(isset($leakedParams['debug_port']))
    		unset($leakedParams['debug_port']);
    	if(isset($leakedParams['start_debug']))
    		unset($leakedParams['start_debug']);

    	return $leakedParams;
	}
}
?>