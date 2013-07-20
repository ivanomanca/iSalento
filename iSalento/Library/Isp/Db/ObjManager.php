<?php
/**
 * Classe Objmanager
 *@todo completare l'insert_obj_to_db di campi array per le tebelline correlate,
 * adesso lo fa per un solo campo "id_eccecc".
 */
class Isp_Db_ObjManager {
	 /**
     * Singleton instance
     */
    public static $_instance = null;	// istanza singleton
	public $dao;						// oggetto dao
	private $conf = "/Library/Isp/Inc/objmanagerconf.php";
	private $dao_path = "/Library/Isp/Db/DataAccess.php";
	private $obj_path = "/Library/Isp/Inc/Objects/";
	private $err_path = "/Library/Isp/Db/ObjError.php";
	//private $err_path = "/Library/Isp/Db/ObjError.php";
	public $id_performed; // id coivolto in un insert, update, delete
	public $note;	// notifiche: non sono errori!
	public $errorsArray = array(); // array di oggetti ObjError

	/**
    * Costruisce un nuovo oggetto Objmanager
    * @param object $dao istanza della classe Data_access
    */
    protected function __construct() {
    	require_once($_SERVER['DOCUMENT_ROOT'].$this->dao_path);
    	try{
        	$this->dao = Isp_Db_DataAccess::getInstance();
    	}catch (Isp_Db_DataAccess_ConnException $e) {
    		//rethrow it
            throw $e;
      }catch (Isp_Db_DataAccess_SelectException $e) {
            //rethrow it
            throw $e;
      }
    }

   /**
     * Singleton instance
     *
     * @return Objmanager
     */
    public static function getInstance()	{
       if (null === self::$_instance) {
        	try{
            	self::$_instance = new self();
        	}
        	// catturo e rilancio
		    catch (Isp_Db_DataAccess_ConnException $e) {
				//rethrow it
			    throw $e;
			}catch (Isp_Db_DataAccess_SelectException $e) {
				//rethrow it
			    throw $e;
			}
        }
        return self::$_instance;
    }


    public function create_obj($ntt, $fields_array){
    	if(is_string($ntt) && !is_null($ntt)){
	    	// includo le classi degli oggetti
	    	$this->require_once_all($_SERVER['DOCUMENT_ROOT'].$this->obj_path);
	    	// istanzio l'oggetto
	    	$obj = new $ntt($fields_array);
			return $obj;
    	}else{
    		require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::OBJ_NOT_CREATED, null,
    												"create_obj: Impossibile creare l'oggetto"
    												.$ntt));
			return false;
    	}
    }

    /**
     * Carica in lettura l' oggetto di tipo $ntt con id = $id
     *
     * @param string $ntt
     * @param int $obj_id_array
     * @param boolean $full
     * @return obj or boolean
     */
	public function load_obj($ntt, $obj_id_array, $full = true){
		require($_SERVER['DOCUMENT_ROOT'].$this->conf);
		//controllo validitˆ array id
		$conf_a_id = $CONF_last_id_index+1;
		$input_a_id = sizeof($obj_id_array);
		if(isset($obj_id_array['distance'])){$input_a_id--;}
		if($conf_a_id != $input_a_id){
			require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::OBJ_NOT_LOADED, null,
    												"load_obj: Incongruenza array_id ".
    												$conf_a_id." != ".$input_a_id));
			return false;
		}
		//ciclo sugli id
		$whr_array = array();
		for($i = 0; $i <= $CONF_last_id_index; $i++){
			$whr_array[$CONF_id_name_array[$i]] = $obj_id_array[$i];
		}
		// ricavo tutti i campi
		$query = $this->dao->make_select_join_query($CONF_id_name_array,
													$CONF_tbls_array,
													$whr_array);
		$esito = $this->dao->invia_query($query);
    	if($esito === false){
    		require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::OBJ_NOT_LOADED,
    												$query, "load_obj: Query fallita"));
    		return false;
    	}else{
    		$fields_array = $this->dao->get_record();
    		// se l'entitˆ non  inserita nel db
			if($fields_array == array()){
				$this->note .= 	"<br>load_obj: la query ".$query.
								" NON HA PRODOTTO RISULTATI"."<br>";
				return null;
			}else{
				if(isset($obj_id_array['distance'])){
					$fields_array['gmapdistance'] = $obj_id_array['distance'];
				}
				$obj = $this->create_obj($ntt, $fields_array);
				return $obj;
			}
    	}
    }

   /**
    * Ricava l'array di oggetti che rappresentano
    * la lista richiesta.
    *
    * @param string $ntt
    * @param string $where
    * @param int $start
    * @param int $righe
    * @param string $order_by
    * @return array() di oggetti di tipo $entita
    */
    public function get_list_obj(	$ntt,
	    							$where_array = null,
	    							$order_by_array = null,
									$start = null,
									$righe = null){
		//lista di uscita
		$lista_obj = array();
		//$nttx entitˆ finale, serve per la load_obj alla fine
		$nttx = $ntt;

		$lista_id = $this->get_id_list(	$ntt,
										$where_array,
										null,
										$order_by_array,
										$start,
										$righe);
		foreach($lista_id as $id_value){
			$object = $this->load_obj($nttx, $id_value, true);
			array_push($lista_obj, $object);
		}
		return $lista_obj;
    }

    /**
     * Inserisce un nuovo oggetto $ntt nel db e se si ha successo
     * restituisce il fields array completo del campo contenente
     * il nuovo id generato.
     *
     * @param array $fields_array
     * @return boolean / $fieds_array
     */
    public function insert_obj_to_db($ntt, $fields_array){
    	require($_SERVER['DOCUMENT_ROOT'].$this->conf);
    	// filtro dell'array $fields_array
    	$l_flds_a = $this->dao->get_leaked_fields_array_for_tbl($fields_array,
    																			$CONF_table_name);
    	// costruisco la query
    	$query = $this->dao->make_insert_query($CONF_table_name, $l_flds_a);
    	$res = $this->dao->invia_query($query);
    	// se la query ha successo inserisce nell'array $fields_array
    	// l'id_localita generato.
    	if($res === false){
    		require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::OBJ_NOT_INSERTED, $query,
    												"insert_obj_to_db: Query fallita"));
    		return false;
    	}else{
    		if(!is_null($this->dao->query_result)){
    			if($this->dao->query_result === true){
    				//non  stato generato nessun id automatico
    				//inserimento di entitˆ che non aveva campi id autoincr.
    				//non faccio nulla :P.
    			}else{
    				// se  stata inserita una entitˆ che non genera id_auto
    				// ma l'id  statoinserito manualmente e cmq  utile per
    				// inserire le tabelline correlate (Es: Spiaggia!)
    				if (	is_numeric($this->dao->query_result) &&
    						$this->dao->query_result == 0) {
    					$this->id_performed = $l_flds_a[$CONF_id_name_array[0]];

    				}else {
    					// stato generato un id automatico e lo inserisco in $f_a
    					$fields_array[$CONF_id_name_array[0]] = $this->dao->query_result;
    					$this->id_performed = $this->dao->query_result;
    				}
    			}
				// @todo completare anche per tabelline di + id.
    			// scrivo tabelline correlate
    			if (isset($CONF_rel_table_name) && !is_null($CONF_rel_table_name)) {
	    			foreach($CONF_rel_table_name as $field => $table){
						if(isset($fields_array[$field]) &&
							!is_null($fields_array[$field])){
							// ricavo l'array dei campi da inserire
							$mulIns = $fields_array[$field];
							// copio il fields_array
							$leak_f_a = $fields_array;
							// elimino l'array dei campi $mulIns
							unset($leak_f_a[$field]);
							// produco l'array filtrato
							$leak_f_a = $this->dao
											->get_leaked_fields_array_for_tbl(	$leak_f_a, 																									$table);
							foreach($mulIns as $value){
								$l_f_a = $leak_f_a;
								$l_f_a[$field] = $value;
								// per ogni valore specificato inserisco un record
								// costruisco la query
						    	$query = $this->dao->make_insert_query($table,
						    														$l_f_a);
						    	$res = $this->dao->invia_query($query);
						    	if($res === false){
						    		require_once(	$_SERVER['DOCUMENT_ROOT']
						    							.$this->err_path);
						    		array_push(	$this->errorsArray,
						    			new Isp_Db_ObjError(	ErrorType::OBJ_NOT_INSERTED,
						    										$query,
						    										"insert_obj_to_db: "
						    										."Query fallita"));
						    		return false;
						    	}
							}
						}
	    			}
    			}

    		}
    		return $fields_array;
    	}
    }

    /**
     * Modifica un oggetto $ntt nel db
     *
     * @param array $fields_array
     * @return boolean
     */
    public function update_obj_to_db($ntt, $fields_array){
    	require($_SERVER['DOCUMENT_ROOT'].$this->conf);
    	// filtro dell'array $fields_array
    	$l_flds_a = $this->dao->get_leaked_fields_array_for_tbl(	$fields_array,
    																$CONF_table_name);
    	$id_value_array = array();
    	// tolgo i valori della chiave primaria dal fields array
    	// e li salvo in $id_value_array
    	for($i = 0; $i <= $CONF_last_id_index; $i++){
    		$field_to_extract = $CONF_id_name_array[$i];
    		$id_extracted = $this->array_take($l_flds_a, $field_to_extract);
    		$id_value_array[$field_to_extract] = $id_extracted;
    	}
    	// costruisco la query
    	$query = $this->dao->make_update_query(	$CONF_table_name,
																$id_value_array,
																$l_flds_a);
		//echo($query);
    	$res = $this->dao->invia_query($query);
    	if($res === false){
    		require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::OBJ_NOT_UPDATED, $query,
    												"update_obj_to_db: Query fallita"));
    		return false;
    	}else{

    		// @todo completare anche per tabelline di + id.
    			// scrivo tabelline correlate
    			if (isset($CONF_rel_table_name) && !is_null($CONF_rel_table_name)) {
	    			foreach($CONF_rel_table_name as $field => $table){

						if(isset($fields_array[$field])){
							// elimino i record presenti nel db!
		    				$query = $this->dao->make_delete_query($table,
																				$id_value_array);
				    		if(!$this->dao->invia_query($query)){
				    			require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
				    			array_push(	$this->errorsArray,
				    						new Isp_Db_ObjError(	ErrorType::OBJ_NOT_UPDATED,
				    													$query,
				    													"update_object_from_db: "
				    													."Query fallita"));
				    			return false;
				    		}
							// ricavo l'array dei campi da inserire
							$mulIns = $fields_array[$field];
							// copio il fields_array
							$leak_f_a = $fields_array;
							// elimino l'array dei campi $mulIns
							unset($leak_f_a[$field]);
							// produco l'array filtrato
							$leak_f_a = $this->dao
											->get_leaked_fields_array_for_tbl(	$leak_f_a, 																									$table);
							foreach($mulIns as $value){
								$l_f_a = $leak_f_a;
								$l_f_a[$field] = $value;
								// per ogni valore specificato inserisco un record
								// costruisco la query
						    	$query = $this->dao->make_insert_query($table,
						    														$l_f_a);
						    	$res = $this->dao->invia_query($query);
						    	if($res === false){
						    		require_once(	$_SERVER['DOCUMENT_ROOT']
						    							.$this->err_path);
						    		array_push(	$this->errorsArray,
						    			new Isp_Db_ObjError(	ErrorType::OBJ_NOT_UPDATED,
						    										$query,
						    										"update_obj_to_db: "
						    										."Query fallita"));
						    		return false;
						    	}
							}
						}
	    			}
    			}
    		return $fields_array;
    	}
    }

    /**
     * Cancella l'oggetto (record) dalla $CONF_table_name nel db
     * e tutti i record in altre tabelle che dipendevano
     * dalla sua esistenza
     *
     * @param string $ntt
     * @param int $id
     * @return boolean
     */
    public function delete_object_from_db($ntt, $id_value_array){
    	require($_SERVER['DOCUMENT_ROOT'].$this->conf);
    	// per ogni tabella indicata nel file di configurazione
    	// vengono cancellati tutti i record che hanno $id_value
    	$this->id_performed = $id_value_array[0];
    	foreach ($CONF_del_tbls as $from_tbl){
    		$id_name_value_array = array();
    		for($i = 0; $i <= $CONF_last_id_index; $i++){
    			$id_name_value_array[$CONF_id_name_array[$i]] = $id_value_array[$i];
    		}
			$query = $this->dao->make_delete_query( $from_tbl,
													$id_name_value_array);
    		if(!$this->dao->invia_query($query)){
    			require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    			array_push(	$this->errorsArray,
    						new Isp_Db_ObjError(	ErrorType::OBJ_NOT_DELETED, $query,
    												"delete_object_from_db: Query fallita"));
    			return false;
    		}
		}
		if($this->del_trigger($ntt, $id_name_value_array)) return true;
    }

   /**
    * Propaga le modifiche di una eliminazione
    * nelle altre tabelle interessate secondo $CONF_del_trigger
    *
    * @param string $ntt
    * @param array $old_id_name_value_array
    * @return boolean
    */
    public function del_trigger($ntt, $old_id_name_value_array){
    	require($_SERVER['DOCUMENT_ROOT'].$this->conf);
    	$tbls_and_field = $CONF_del_trigger[0];
    	$new_value = $CONF_del_trigger[1];
    	foreach ($tbls_and_field as $tbl => $field){
    		$new_id_name_value_array = array($field => $new_value);
    		// costruisco la query
    		$query = $this->dao->make_update_query(	$tbl,
													$old_id_name_value_array,
													$new_id_name_value_array);
			//echo($query);
			$res = $this->dao->invia_query($query);
    		if($res === false){
    			require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    			array_push(	$this->errorsArray,
    						new Isp_Db_ObjError(	ErrorType::OBJ_NOT_DELETED, $query,
    											"delete_trigger: Query fallita"));
    			return false;
    		}
    	}
    	return true;
	}

	/**
	 * Ritorna unn array con gli id di $ntt
	 *
	 * @param string $ntt
	 * @param array di where degli and $where_and_array
	 * @param array di where degli or $where_or_array
	 * @param array ordinamento $order_by_array
	 * @param int $start
	 * @param int $righe
	 * @return array
	 */
	public function get_id_list(	$ntt,
			    							$where_and_array = null,
			    							$where_or_array = null,
			    							$order_by_array = null,
											$start = null,
											$righe = null){
		//includo le conf del file $ntt.
		require($_SERVER['DOCUMENT_ROOT'].$this->conf);
    	//ricavo i campi primari di $ntt.
    	$temp = array_chunk($CONF_id_name_array, $CONF_last_id_index+1);
    	$id = $temp[0];

    	//	Se i campi sono contenuti tutti in $CONF_table_name
    	//	faccio una semplice select, altrimenti produco una query di
    	//	select_join usando la configurazione dei join_path.

    	// Verifico quali campi non sono contenuti nella tabella principale
    	$not_found_array = $this->field_not_in_tbl(	$CONF_table_name,
    																$where_and_array);
    	$gen_join_tbls = array();
    	if(sizeof($not_found_array) > 0){
    		//sviluppo $where_and_array in array singoli
    		$single_whr_array = array();
    		foreach ($where_and_array as $f => $v){
    			array_push($single_whr_array, array($f => $v));
    		}
    		//PROCEDURA CALCOLO JOIN PATH PER GLI AND
    		$gen_join_tbls = $this->join_path_compute(	$CONF_join_path_array,
    																	$single_whr_array);
    	}
    	if (!is_null($where_or_array) || sizeof($not_found_array) > 0) {
    		// costruisco la query
    		if (!is_null($where_or_array)) {
    			// array dei campi
    			$whr_or_flds = array();
    			//ricavo l'array delle tabelle di or
    			$whr_or_tbls = array_shift($where_or_array);
    			for ($w = 0; $w < sizeof($where_or_array); $w++){
    				array_push($whr_or_flds, $where_or_array[$w]);
    				//PROCEDURA CALCOLO JOIN PATH ARRAY DI OR
	    			$gen_join_tbls_or = $this->join_path_compute(	$CONF_join_path_array,
	    															$where_or_array[$w]);

	    			//aggiungo le tabelle per gli or all'array per il join
	    			$gen_join_tbls = array_unique(array_merge(	$gen_join_tbls,
	    														$gen_join_tbls_or));
    			}
    			//costruisco con un joinor!
    			$query = $this->dao->make_select_join_andor_query(	$id,
																					$gen_join_tbls,
																					$where_and_array,
																					$whr_or_flds,
																					$order_by_array,
																					$start,
																					$righe);
				//echo $query;
    		}else{
	 			// costruisco con un join semplice
	    		$query = $this->dao->make_select_join_query(	$id,
																			$gen_join_tbls,
																			$where_and_array,
																			$order_by_array,
																			$start,
																			$righe);
    		}
    	}else{
    		//costruisco con una select semplice
    		$query = $this->dao->make_select_query(	$CONF_table_name,
					 												$id,
					 												$where_and_array,
					 												$order_by_array,
					 												$start,
					 												$righe);
    	}
    	$esito = $this->dao->invia_query($query);
		if($esito === false){
			require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
			array_push(	$this->errorsArray,
						new Isp_Db_ObjError(	ErrorType::OBJ_NOT_LISTED, $query,
													"get_list_obj: Query fallita"));
    		return false;
    	}
    	else{
    		//lista degli id che soddisfano il filtro.
    		$lista_id = array();
    		// se query di distanze, array distanze
    		$lista_distanze = array();

    		// salvo gli id in un array
    		while($row = $this->dao->get_record()){
    			$id_rec = array();
    			for($i = 0; $i < sizeof($id); $i++){
    				$id_rec[$i] = $row[$id[$i]];
    				// prelevo la distanza gmap
    				//if(isset($row['distance'])){
    				//	$id_rec['distance'] = $row['distance'];
    				//}
    			}
    			array_push($lista_id, $id_rec);
    		}

    		return $lista_id;
    	}
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $ntts
	 * @param unknown_type $filters_arrays
	 * @return unknown
	 */
	public function get_multi_where_or_array($ntts, $filters_arrays){
		$out_w_f_a = array();
		$new_filt_array = array();
		for($n = 0; $n < sizeof($ntts); $n++){
			foreach ($filters_arrays[$n] as $filter_array => $val){
				$w_o_a = $this->get_single_where_or_array($ntts[$n],
														array($filter_array => $val));
				foreach ($w_o_a as $id_arr){
					array_push($new_filt_array, $id_arr);
				}
				array_push($out_w_f_a, $new_filt_array);
				$new_filt_array = array();
			}
		}
		$whr_or = array($ntts);
		foreach ($out_w_f_a as $n_f_a){
			array_push($whr_or, $n_f_a);
		}
		return $whr_or;
	}

	/**
	 * Data la tabella ntt,
	 *
	 * @param unknown_type $ntt
	 * @param unknown_type $filters_array
	 * @return unknown
	 */
	public function get_single_where_or_array($ntt, $filters_array){
		//includo le conf del file $ntt.
		require($_SERVER['DOCUMENT_ROOT'].$this->conf);
		//ricavo i campi primari di $ntt.
    	$temp = array_chunk($CONF_id_name_array, $CONF_last_id_index+1);
    	//print_r($temp);
    	$id = $temp[0];
    	//costruisco con una select semplice
		$query = $this->dao->make_select_query(	$ntt,
												$id,
												$filters_array,
												null,
												null,
												null);
		$esito = $this->dao->invia_query($query);
		if($esito === false){
			require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
			array_push(	$this->errorsArray,
						new Isp_Db_ObjError(	ErrorType::OBJ_NOT_RETRIEVED, $query,
													"get_where_or_array: Query fallita"));
			return false;
		}else{
			// salvo gli id in un array
			$id_rec = array();
			while($row = $this->dao->get_record()){
				for($i = 0; $i < sizeof($id); $i++){
					array_push($id_rec, array($id[$i] => $row[$id[$i]]));
				}
			}
			return $id_rec;
		}
	}

	/**
	 * Ricava i campi id da nome tabella
	 * e li associa ai loro valori
	 *
	 * @param string $ntt
	 * @param array $IDs
	 * @return array
	 */
	public function name_value_ids($ntt, $IDs){
		//completa l'array in ingresso con il nomi dei campi id come chiave.
		//include($_SERVER['DOCUMENT_ROOT'].$this->card_path."card".$ntt.".php");
		require($_SERVER['DOCUMENT_ROOT'].$this->conf);
		$temp = array();
		for($i = 0; $i <= $CONF_last_id_index; $i++){
			$temp[$CONF_id_name_array[$i]] = $IDs[$i];
		}
		return $temp;
	}

	/**
	 * Restituisce un array contenente i nomi di tutte le tabelle
	 * che devono essere utilizzate nel join per raggiungere
	 * gli id dell'entitˆ partendo dai campi contenuti nell'array
	 * $where_array.
	 *
	 * @param array $join_path_array
	 * @param array $where_array
	 * @return array
	 */
	public function join_path_compute($join_path_array, $where_array){
		$path_tbls_array = array();
		for ($x = 0; $x < sizeof($where_array); $x++){
			$f_arr = $where_array[$x];
			// se non  null il secondo argomento
			if(key_exists(key($f_arr), $join_path_array)){
				$path_tbls_array = array_merge(	$path_tbls_array,
												$join_path_array[key($f_arr)]);
			}
		}
		return array_unique($path_tbls_array);
	}

	/**
	 * TESTATA
	 *
	 * @param unknown_type $tbl
	 * @param unknown_type $where_array
	 * @return unknown
	 */
	public function field_not_in_tbl($tbl, $where_array){
		$not_found_array = array();
		//se l'array dei  inizializzato
		if (!is_null($where_array)){
			$f_n_array = $this->dao->get_tbl_fields_name_array_from($tbl);
			foreach ($where_array as $whr_field => $whr_value){
				//cerca il nome del campo tra i campi della $tbl
				$field_found = key_exists($whr_field , $f_n_array);
				if(!$field_found){
					array_push($not_found_array, $whr_field);
				}
			}
		}
		return $not_found_array;
	}

	/**
	 * Restituisce il valore dell'elemento corrispondente a
	 * $key_value eliminando il record dall'array.
	 *
	 * @param puntatore ad array $array
	 * @param mixed $key_value
	 */
	public function array_take(&$array, $key_value){
		if(is_array($array) && key_exists($key_value, $array)){
			$value = $array[$key_value];
			unset($array[$key_value]);
			return $value;
		}else{
			return false;
		}
	}

	/**
	 * Fa la require_once includendo tutti i file della cartella $path
	 *
	 * @param string $path
	 */
	private function require_once_all($path){
		foreach (glob($path."*.php") as $filename) {
		   require_once($filename);
		}
	}
}
?>