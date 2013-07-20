<?php
/**
 * Classe Beaner
 */
class Isp_Db_Beaner {
	private $bean_path = "/Library/Isp/Inc/Beans/";
	private $objman_path = "/Library/Isp/Db/ObjManager.php";
	private $nttconf = "/Library/Isp/Inc/objmanagerconf.php";
	private $CONF;
	public static $_instance = null;
	public $objman;
	public $Lang;
	public $err;
	//public $gmapdistance;
	public $atdistancefrom;

	/**
	 * Costruttore
	 *
	 */
	public function __construct(){
		require_once($_SERVER['DOCUMENT_ROOT'].$this->bean_path."Conf.php");
		$this->CONF = new Conf();
		require_once($_SERVER['DOCUMENT_ROOT'].$this->objman_path);
		try{
        	$this->objman = Isp_Db_ObjManager::getInstance();
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

   /**
    * Carica la struttura dati bean relativa alla stringa $What di ingresso
    *
    * ISTRUZIONI PER L'USO:
	 * Come impostare gli ingressi della funzione retrieve():
	 *
	 * 1. Nel primo campo ($What) bisogna indicare la stringa
	 * (secondo la convenzione dei beans) che identifica il bean/oggetto
	 * richiesto, quindi se voglio una lista di strutture devo indicare
	 * A7B7Struttura dove "A7" sta "per Array di", "B7" sta per "Beans di" e
	 * Struttura indica che voglio che i beans siano di strutture.
	 * Le entità Articolo e Fotovideo sono viste solo come Bean, mai come
	 * oggetti semplici.
	 *
	 * 2. Nel secondo campo ($params) bisogna specificare l'array dei
	 * parametri filtro che tipicamente viene ricavato dalla view.
	 * L'array deve essere nel formato
	 * array( campo1 => valore1, campo2 => valore2, campo3 => valore3, ....);
	 *
	 * PARAMETRI DI ORDINAMENTO:
	 * Per i parametri di ordinamento si deve usare la convenzione:
	 *
	 * order_cre => campo_di_riferimento, per ordinare crescentemente
	 * order_dec => campo_di_riferimento, per ordinare decrescentemente
	 * order_rnd => "", per ordinare random... mettere la stringa vuota sempre
	 * L'ordinamento è consentito solo sui campi della
	 * tabella principale (per ora).
	 *
	 * FILTRO atdistancefrom da GMAP:
	 * Per filtrare una lista in uscita in base alla distanza degli
	 * oggetti da un punto della mappa gmap prefissato usare la convenzione:
	 *
	 * "atdistancefrom" => array(	'latgmap_struttura' => 37,
 											'lnggmap_struttura' => -122,
 											'rgmap' => 30)

 	 * dove i primi due parametri sono i campi latitudine e longitudine
 	 * del punto in cui centrare il cerchio
 	 * (notare come abbiano _struttura,
 	 * questo perchè le coordinate sono contenute nella tabella struttura).
 	 * Il terzo parametro è il raggio del cerchio in km.
	 *
	 *
	 * IMPORTANTE!!!
	 * Unico vincolo da tenere in conto è che i campi che hanno stesso nome
	 * in tabelle diverse (ad esempio username_utente) bisogna specificare
	 * la tabella alla quale ci si riferisce, altrimenti la funzione di
	 * default prende come tabella quella indicata dal nome stesso
	 * (in questo caso "utente").
	 * Come si specifica? Semplicemente scrivendo il nome del campo e poi il
	 * carattere "-" seguito dal nome della tabella.
	 * Esempio: username_utente-<tabella>
	 *
	 * @param string $What es: A7B7Struttura
	 * @param array $params es: è l'array che contiene i parametri filtro
	 * @return obj/array(objs) o boolean false in caso di errore
    */
	public function retrieve($What, $params = null, $Lang = null){
		if (is_null($Lang)){
			// cerco la lingua nell'ordine sessione, cookie...
			//...da completare.

			// imposto la lingua di default
			$this->Lang = "IT";
		}elseif(is_string($Lang)){
			//imposto la lingua
			$this->Lang = $Lang;
		}else{
			// errore
			return false;
		}
		if (is_string($What) && (is_null($params) || is_array($params))) {
			// scrivo la richiesta
			$code = $this->write_request($What, $params);
			// eseguo la richiesta
			//echo($code);
			eval($code);
			return $o;
		}
	}

	 /**
    * Carica la struttura dati bean relativa alla
    * stringa $What di ingresso
    */
	private function write_request($What_to_find, $params){
	// Se l'ingrediente che mi serve è stato specificato ed è una stringa
	if (isset($What_to_find) && is_string($What_to_find)) {
		// mi dice se è il primo che controllo,
		// mi serve per gli array degli OR
		$first_field = true;
		$W = explode("7", $What_to_find);

		// array in AND (campi tabella principale)
		$AND_array;

		// Se si tratta di una lista filtrata
		if($W[0] == "A"){
			$out_string = 	"$"."o = $"."this->filtered_list_build($"
								."this->Lang, "."$"."What";
			/**
			 * CONTIENE PARAMETRI FILTRO
			 */
			if(is_array($params) && $params ==! array()){

				// FILTRO atdistancefrom
				if (key_exists("atdistancefrom", $params)) {
					// salvo il filtro;
					$this->atdistancefrom = $params['atdistancefrom'];
					unset($params["atdistancefrom"]);
				}

				/**
			 	* PARAMETRI SPECIAL
			 	*/
				/* se è richiesto un ordine
				if (key_exists("gmapdistance", $params)) {
					$out_string .= ", array( \""
										."distance"
										."\" => \"ASC\" )";
					// salvo il filtro;
					$this->gmapdistance = $params['gmapdistance'];
					unset($params["gmapdistance"]);
				}else*/
				if (key_exists("order_cre", $params)) {
					$out_string .= ", array( \""
										.$params["order_cre"]
										."\" => \"ASC\" )";
					unset($params["order_cre"]);
				}elseif (key_exists("order_dec", $params)) {
					$out_string .=	", array( \""
										.$params["order_dec"]
										."\" => \"DESC\" )";
					unset($params["order_dec"]);
				}elseif (key_exists("order_rnd", $params)) {
					$out_string .=	", array( \""
										.$params["order_rnd"]
										."\" => \"RAND()\" )";
					unset($params["order_rnd"]);
				}else{
					$out_string .= ", null";
				}
				//---------------------------------------------------------
				// se sono stati specificati start e righe
				if (key_exists("start", $params)) {
					$out_string .= ", ".$params["start"];
					unset($params["start"]);
				}else{
					$out_string .= ", 0";
				}
				if (key_exists("righe", $params)) {
					$out_string .= ", ".$params["righe"];
					unset($params["righe"]);
				}else{
					$out_string .= ", 100";
				}

				//---------------------------------------------------------
				// Ricavo la tabella di riferimento
				$rif_table = strtolower($W[sizeof($W) - 1]);

				/**
			 	* PARAMETRI AND
			 	*/
				if($params != array()){
					foreach ($params as $name => $value){
						// inizio con l'array dei filters AND
						// se il nome non contiene il carattere - viene
						if (strpos($name, "-") === false) {
							$name_puro = explode("_", $name);
							// se il campo appartiene alla tabella di riferimento
							if($name_puro[sizeof($name_puro) - 1] == $rif_table){
								$AND_array[$name] = $value;
								// siccome l'ho assegnato lo elimino dai parametri
								unset($params[$name]);
							}
						}
						// contiene - quindi va separato e messo nella tabella
						// indicata dopo il -
						else{
							$str_name = explode("-", $name);
							// se il campo appartiene alla tabella di riferimento
							if($str_name[sizeof($str_name) - 1] == $rif_table){
								$AND_array[$str_name[0]] = $value;
								// siccome l'ho assegnato lo elimino dai parametri
								unset($params[$name]);
							}
						}
					}
					// COMPLETO LA STRINGA REQUEST CON GLI AND
					if (isset($AND_array) && !is_null($AND_array)) {
						$out_string .= ", array(";
						foreach ($AND_array as $key => $value){
							$out_string .= " \"".$key."\" => \"".$value."\",";
						}
						$out_string = rtrim($out_string, ",");
						$out_string .= " )";
					}else{
						$out_string .= ", null";
					}

					/**
			 		* PARAMETRI OR
			 		*/
					if ($params != array()) {
						// CALCOLO L'ARRAY DEGLI OR
						$first_field = true;
						$tables_array; // array dei nomi delle tabelle
						foreach ($params as $name => $value){
							// se il nome non contiene il carattere -
							if (strpos($name, "-") === false) {
								$name_puro = explode("_", $name);
								$current_table = $name_puro[sizeof($name_puro) - 1];
								if ($first_field) {
									// il primo nome di tabella che trovo
									$tables_array = array();
									array_push($tables_array, $current_table);
									$first_field = false;
								}
								// se trovo il nome di una nuova tabella
								elseif (	!in_array($current_table,
											$tables_array)){
									array_push($tables_array, $current_table);
								}
							}
							// contiene - quindi va separato e messo nella tabella
							// indicata dopo il -
							else{
								$str_name = explode("-", $name);
								// se il campo appartiene alla tabella di riferimento
								$current_table = $str_name[sizeof($str_name) - 1];
								if ($first_field) {
									// il primo nome di tabella che trovo
									$tables_array = array();
									array_push($tables_array, $current_table);
									$first_field = false;
								}
								// se trovo il nome di una nuova tabella
								elseif (	!in_array($current_table,
											$tables_array)){
									array_push($tables_array, $current_table);
								}
							}
						}
						// COMPLETO LA STRINGA REQUEST CON L'ARRAY TABELLE ESTERNE
						$out_string .= ", array( array( ";
						foreach ($tables_array as $table){
							$out_string .= "\"".$table."\",";
						}
						$out_string = rtrim($out_string, ",");
						$out_string .= " )";

						// CALCOLO GLI ARRAY DEI CAMPI ESTERNI
						foreach ($tables_array as $tabella){
							$first_field = true;
							$field_counter = 0; // contatore dei campi
							// per ogni tabella esterna stampo un array dei suoi campi
							foreach ($params as $name => $value){
								// se il nome non contiene il carattere -
								if (strpos($name, "-") === false) {
									$name_puro = explode("_", $name);
									$current_table = $name_puro[sizeof($name_puro) - 1];
									if($tabella == $current_table){
										// appartiene alla tabella corrente
										if ($first_field) {
											// il primo campo di tabella che trovo
											$out_string .=	", array( \""
																.$name."\" => \""
																.$value."\",";
											$first_field = false;
										}
										else{
											$out_string .=	"\"".$name."\" => \""
																.$value."\",";
										}
									}
								}
								// contiene - quindi va separato e messo nella tabella
								// indicata dopo il -
								else{
									$str_name = explode("-", $name);
									$current_table = $str_name[sizeof($str_name) - 1];
									// se il campo appartiene alla tabella di riferimento
									if($tabella == $current_table){
										$current_table = $str_name[sizeof($str_name) - 1];
										if ($first_field) {
											// il primo nome di tabella che trovo
											$out_string .= ", array( \""
																.$str_name[0]."\" => \""
																.$value."\",";
											$first_field = false;
										}
										// se trovo il nome di una nuova tabella
										else{
											$out_string .= "\"".$str_name[0]
																."\" => \"".$value."\",";
										}
									}
								}
								$field_counter++;
								// se è l'ultima cella tolgo la virgola!
								if ($field_counter == sizeof($params)) {
									$out_string = rtrim($out_string, ",");
									$out_string .= " )";
								}
							}
						}
						// COMPLETO LA STRINGA REQUEST CON L'ARRAY DEI CAMPI ESTERNI
						$out_string = rtrim($out_string, ",");
						$out_string .= ")";
						}
					}
				}
				// Parentesi finale!
				$out_string .= ");";
			}
			/**
			 * BEAN O OGGETTI SEMPLICI
			 */
			else{
				// l'array dei parametri deve contenere le celle per l'id
				if(is_array($params) && $params ==! array()){
					$out_string = 	"$"."o = $"."this->build($"
										."this->Lang, "."$"."What";
					$out_string .= ", array(";
					foreach ($params as $id_value){
						$out_string .= "\"".$id_value."\"";
						$out_string .= ",";
					}
					$out_string = rtrim($out_string, ",");
					$out_string .= ")";
				}
				$out_string .= ");";
			}
			return $out_string;
		}
	}

	 /**
	 * Restituisce l'oggetto obj
	 *
	 * @param string $What
	 * @param array es: array(111) $IDs
	 * @param obj $objman
	 * @param string $ntt
	 * @return obj
	 */
	public function build($Lang, $What, $IDs, $ntt = null){
		$out;
		// includo le classi dei bean
		$this->require_once_all($_SERVER['DOCUMENT_ROOT'].$this->bean_path);
		// recupero l'istanza del Objmanager
		$objman = Isp_Db_ObjManager::getInstance();

	/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * 	OGGETTI SEMPLICI INDIPENDENTI
	 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
		if (strpos($What, "7") === false){
			//I livello semplice
			if (in_array($What, $this->CONF->OnlyBeanNTTS)) {
						if(is_null($ntt)){
							$this->err .= "Fotovideo e Articolo sono visti come Bean";
							// sono viste solo come beans
							return false;
						}
				$out = $objman->load_obj(array($What, $ntt), $IDs);
			}elseif (in_array($What, $this->CONF->SimpleObjNTTS)) {
				$out = $objman->load_obj($What, $IDs);
			}elseif (in_array($What, $this->CONF->SimpleLangNTTS)) {
				$IDs_lang = $IDs;
				//recupero la lingua settata
				array_push($IDs_lang, $Lang);
				$out = $objman->load_obj($What, $IDs_lang);
			}else{
				//non esiste l'entità
				$this->err .="Beaner: Entità ".$What." inesistente";
				return false;
			}
		}else{
	/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * 	OGGETTI COMPOSTI B7OGGETTO
	 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
			$W = explode("7", $What);
			if($W[0] == "B"){
				//I livello Bean
				if(in_array($W[1], $this->CONF->BeanNTTS)) {
					if(!is_null($ntt)){
						// proviene da un'altra entità
						$out = new $What($Lang, $IDs, $ntt);
					}else{
						// non proviene da un'altra entità
						$out = new $What($Lang, $IDs);
					}
				}else{
					//non esiste l'entità
					$this->err .="Beaner: Bean ".$What." inesistente";
					return false;
				}
			}
	/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * 	ARRAY DI OGGETTI SEMPLICI A7OGGETTO
	 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
			elseif ($W[0] == "A"){
				//I livello array
				if(in_array($W[1], $this->CONF->ListedObjNTTS)){
					$out = $objman->get_list_obj(	$W[1],
															$objman->name_value_ids(	$ntt,
																								$IDs));
				}elseif (in_array($W[1], $this->CONF->SimpleLangListNTTS)){
					$IDs_lang = $objman->name_value_ids($ntt, $IDs);
					//recupero la lingua settata --- da generalizzare
					$IDs_lang["lingua_sigla_tea"] = $Lang;
					$out = $objman->get_list_obj("Tea", $IDs_lang);
				}elseif ($W[1] == "B"){
	/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * 	ARRAY DI OGGETTI COMPOSTI A7B7OGGETTO
	 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
					if (in_array($W[2], $this->CONF->SpecialBeanNTTS)){
						//II livello beans
						$tout = $objman->get_list_obj(	array($W[2], $ntt),
													$objman->name_value_ids($ntt, $IDs));

						$out = array();
						foreach ($tout as $obj){
							$IDs = array($obj->get_id());
							$bout = $this->build($Lang, "B7".$W[2], $IDs, $ntt);
							array_push($out, $bout);
						}
					}
				}
			}
	/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	 * 	fine
	 @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
		}
		//if(isset($out)) return $out;
		return $out;
	}

	/**
	 * Ritorna un array di beans
	 *
	 * @param string $Lang
	 * @param obj $gst
	 * @param string $What
	 * @param array("nomecampo" => 12, ...) $filters
	 * @param array(array("campo1" => 2), array("tabella1", tabella2)) $whr_or
	 * @param array $order
	 * @param int $start
	 * @param int $righe
	 * @return obj
	 */
	public function filtered_list_build(	$Lang,
														$What,
														$order = null,
														$start = 0,
														$righe = 100,
														$filters = null,
														$whr_or = null,
														$gmap_filter = null){
		$objman = Isp_Db_ObjManager::getInstance();
		// includo le classi dei bean
		$this->require_once_all($_SERVER['DOCUMENT_ROOT'].$this->bean_path);

		// se esiste il filtro gmap, completo l'array order by
		/*if(isset($this->gmapdistance)){
			$order['gmapfilter'] = $this->gmapdistance;
		}*/

		if (strpos($What, "7") === false){
			$this->err .="Filtered list build usata al posto di build().";
			// non viene chiesta una lista, si usa la funzione build()
			return false;
		}else{
		/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
		* 	ARRAY DI BEANS A7OGGETTO
		@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
			if(!is_null($whr_or) && is_array($whr_or)){
				// ciuccia l'array che contiene le tabelle di join
				$tbls_array = array_shift($whr_or);
				//ricavo
				$whr_or = $objman->get_multi_where_or_array($tbls_array, $whr_or);
			}
			$W = explode("7", $What);
			if ($W[0] == "A"){
				//I livello array
				if(	$W[1] == "B" && in_array($W[2], $this->CONF->BeanNTTS)){
					//fare la funzione
					$id_list = $objman->get_id_list(		$W[2],
																	$filters,
																	$whr_or,
																	$order,
																	$start,
																	$righe);
					// GMAP FILTER FUNCTION
					$id_list = $this->gmap_filter($id_list, $W[2]);

					$out = $this->id_to_bean($Lang, "B7".$W[2], $id_list);
				/**@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
* 	ARRAY DI OGGETTI SEMPLICI			@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
				}elseif(in_array($W[1], $this->CONF->ListedObjNTTS)){
					$id_list = $objman->get_id_list(		$W[1],
															$filters,
															$whr_or,
															$order,
															$start,
															$righe);
					// GMAP FILTER FUNCTION
					$id_list = $this->gmap_filter($id_list, $W[1]);

					$out = $this->id_to_bean($Lang, $W[1], $id_list);
				}else {
					return false;
				}
			}
			return $out;
		}
	}

	/**
	 * Carica un array di bean da una lista di id
	 *
	 * @param string $Lang
	 * @param string $bean_or_ntt_name
	 * @param arrray $id_array
	 * @return bean obj
	 */
	private function id_to_bean(	$Lang,
											$bean_or_ntt_name,
											$id_array,
											$from_ntt = null){
		$objman = Isp_Db_ObjManager::getInstance();
		$beans_array = array();
		if(is_array($id_array)){
			foreach ($id_array as $id_value_arr){
				if(!is_null($from_ntt)){
					$builded_obj = $this->build(	$Lang,
															$bean_or_ntt_name,
															$id_value_arr,
															$from_ntt
														);
				}else{
					$builded_obj = $this->build(	$Lang,
															$bean_or_ntt_name,
															$id_value_arr
														);
				}
				// inserisco il bean prodotto nell'array di uscita
				array_push($beans_array, $builded_obj);
			}
			return $beans_array;
		}
	}

	/**
	 * Fa i filtri di mappa,
	 * tipicamente implementa la convenzione
	 * 'atdistancefrom'
	 *
	 * @param unknown_type $idList
	 */
	private function gmap_filter($idList, $ntt){
		if(isset($this->atdistancefrom)){
			// ricavo idfield e table da $ntt
			//includo le conf del file $ntt.
			require($_SERVER['DOCUMENT_ROOT'].$this->nttconf);
    		//ricavo i campi primari di $ntt.
    		$temp = array_chunk($CONF_id_name_array, $CONF_last_id_index+1);
    		$idFieldNameArray = $temp[0];
    		if(isset($CONF_mother_table)){
    			$tableName = $CONF_mother_table;
    		}else{
				$tableName = $CONF_table_name;
    		}

			$filteredIdList = array();
			$query = $this->objman->dao->make_select_query(
				// table
				$tableName,
				// fields name array
				$idFieldNameArray,
				null,
				// orderby array
				array('distance' => 'ASC',
						'gmapfilter' => $this->atdistancefrom));

			// invio la query
			$esito = $this->objman->dao->invia_query($query);

			if($esito === false){
    			return false;
    		}else{
    			//lista degli id che soddisfano il filtro.
    			$filteredIdList = array();

	    		// salvo gli id in un array
	    		while($row = $this->objman->dao->get_record()){
	    			$id_rec = array();
	    			for($i = 0; $i < sizeof($idFieldNameArray); $i++){
	    				$id_rec[$i] = $row[$idFieldNameArray[$i]];
	    			}
	    			// inserisco il risultato della distanza
	    			if(isset($row['distance'])){
	    					$id_rec['distance'] = $row['distance'];
	    			}
	    			array_push($filteredIdList, $id_rec);
	    		}
			return $filteredIdList;
			}
		}else{return $idList;}
	}

	/**
	 * Fa la require includendo tutti i file della cartella $path
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