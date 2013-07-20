<?php
/**
 *  Una classe che interagisce con il database. Al momento dell'istanza
 *  di un nuovo oggetto Data_access si crea la connessione che viene
 *  memorizzata come parametro dell'oggetto.
 *
 */
class Isp_Db_DataAccess {
	private $db_conf_file = "/Library/Isp/Inc/Db/dbconf.php";
	private $db_exceptions = "/Library/Isp/Db/DataAccess/";
	private $connessione;	//$connessione memorizza una risorsa db
    private $query_eseguite = 0;
	public  $query_result;	//$query_result memorizza una risorsa query
	public static $_instance = null;	// istanza singleton

    //! COSTRUTTORE
    /**
    * Costruisce un nuovo Database Object
    * e memorizza la connessione nelle variabili
    */
    protected function __construct(){
    	// Parametri database
		require_once($_SERVER['DOCUMENT_ROOT'].$this->db_conf_file);
		// Eccezioni
		$this->require_once_all($_SERVER['DOCUMENT_ROOT'].$this->db_exceptions);
		// Id della connessione
		$this->connessione = mysql_connect($db_host, $db_user, $db_password);
		// Se la connessione non è avvenuta
		if($this->connessione === FALSE){
			//die("Database connection error.");
			throw new Isp_Db_DataAccess_ConnException('DB connection error.');
		}
		// Selezione del database
		if(mysql_select_db($db_name, $this->connessione)){
			// selezione avvenuta con successo
		}else{
			//die ("Database selection error.");
			throw new Isp_Db_DataAccess_SelectException('DB selection error.');
		}
    }

    /**
     * Singleton instance
     *
     * @return DataAccess
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
	 * Chiude la connessione
	 *
	 */
	public function disconnetti(){
		mysql_close($this->connessione);
	}

    /**
    * Cattura la risorsa query_result e la memorizza in una variabile locale.
    * @param $sql stringa - La query da eseguire nel db
    * @return boolean
    */
    public function invia_query($sql){
	    // resetto il campo per il risultato
	    $this->query_result = null;
	    // eseguo la query
	    $this->query_result = mysql_query($sql, $this->connessione);

	    if($this->query_result === false){
	    	return false;
	    }else{
	    	if($this->query_result === true){
		    	// se è stato creato un nuovo id
		    	$new_id_created = mysql_insert_id($this->connessione);
				$this->query_result = $new_id_created;
			}
			//----------------------
			//$this->query_eseguite++;
			//echo($sql."<br>");
			//----------------------
			return true;
	    }
    }

    /**
    * Ritorna un array associativo con i risultati della query
    * @return mixed l'array record se presente, false altrimenti
    * @example	Esternamente all'oggetto Data_access:
    * 			$dao = new Data_access();
    * 			$dao->invia_query("SELECT nome FROM tabella");
    * 			while($row = $dao->get_record()){...}
    */
    public function get_record(){
        if ($row = mysql_fetch_array($this->query_result, MYSQL_ASSOC))
            return $row;
        else
            return false;
    }

/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	FUNZIONI DI AUSILIO PER IL GESTORE
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

	/**
	 * Seleziona gli id relativi alla $table filtrati
	 * dall'array di condizioni $where_array.
	 *
	 * @param string $table
	 * @param array $where_array
	 * @return boolean
	 */
	public function get_leaked_id_from_tbl($table, $id_string, $where_array){
		$query = $this->make_select_query(	$table,
												array($id_string),
												$where_array);
		$esito = $this->invia_query($query);
		if($esito === false) return false; else return true;
	}

	/**
	 * Filtra l'array $full_fields_array secondo
	 * i nomi dei campi in $tbl_name e restituisce
	 * l'array pronto per la query.
	 *
	 * @param array $full_fields_array
	 * @param string $tbl_name
	 * @return array
	 */
	public function get_leaked_fields_array_for_tbl(	$full_fields_array,
														$tbl_name){
		$leaked_array = array();
		$tbl_flds_array = $this->get_tbl_fields_name_array_from($tbl_name);
		$leaked_array = array_intersect_key(	$full_fields_array,
												$tbl_flds_array);
	    return $leaked_array;
	}

	/**
	 * Ricava l'array che contiene come chiavi i
	 * nomi della tabella $tbl_name
	 *
	 * @param unknown_type $full_fields_array
	 * @param unknown_type $tbl_name
	 * @return unknown
	 */
	public function get_tbl_fields_name_array_from($tbl_name){
		$tbl_fields_array = array();
		$query = "SHOW FIELDS FROM $tbl_name";
		$esito = $this->invia_query($query);
		if($esito === false){
			return false;
		}
    	else{
			while($row = $this->get_record()){
				$tbl_fields_array[$row["Field"]] = null;
			}
	    	return $tbl_fields_array;
    	}
	}

	public function get_tbl_structure($tbl_name){
		$query = "SHOW FIELDS FROM $tbl_name";
		$esito = $this->invia_query($query);
		if($esito === false){
			return false;
		}
    	else{
    		$i = 0;
			while($row = $this->get_record()){
				$tbl_array[$i] = $row;
				$i++;
			}
	    	return $tbl_array;
    	}
	}

	/**
	 * Restituisce l'array dei campi in comune tra 2 tabelle, solitamente
	 * è un campo solo che è l'id
	 *
	 * @param array $full_fields_array
	 * @param string $tbl_name
	 * @return array
	 */
	public function common_fields($tbl1, $tbl2){
		if (is_string($tbl1) && is_string($tbl2)){
			$leaked_array = array();
			$tbl_fields1 = $this->get_tbl_fields_name_array_from($tbl1);
			$tbl_fields2 = $this->get_tbl_fields_name_array_from($tbl2);
			$leaked_array = array_intersect_key($tbl_fields1, $tbl_fields2);
			if($leaked_array == array()){
				return false;
			}
			else{
				$full_l_a = $leaked_array;
				if(sizeof($leaked_array)>1){
					// + di un campo in comune, conflitto!
					$leaked_array =
						array_flip($this->table_conflict($tbl1, $tbl2, $leaked_array));
				}
		    	return array(array_keys($leaked_array), array_keys($full_l_a));
			}
		}
		return false;
	}

	/**
	 * Restituisce i campi in comune tra due tabelle scrivendoli
	 * nell'array in uscita e legandoli al nome delle tabelle.
	 *
	 * @param string $tbl1
	 * @param string $tbl2
	 * @return array
	 */
	public function get_tbl_connectors_array($tbl1, $tbl2, &$fields_foundf){
		//inizializzo l'array di output
		$connectors_array = array();
		$connectors_arrayf = array();
		//ricavo l'array dei campi comuni
		$common_array = $this->common_fields($tbl1, $tbl2);
		$common_full = $common_array[1];
		$common_leak = $common_array[0];
		//print_r($common_leak);
		//echo("<br><br>");
		if($common_leak === false){
			return false;
		}else{
			if(is_array($common_leak)&&is_array($common_full)){
				//scambio la chiave con il valore
				$comm = array_flip($common_leak);
				$commf = array_flip($common_full);
			}
			//per ogni campo comune associo l'alias della tabella principale
			for($k = 0; $k < sizeof($common_leak); $k++){
				$field_name = $common_leak[$k];
				$connectors_array[$tbl1.".".$field_name] = $tbl2.".".$field_name;
				//setto come valore tabella.campo
				//$comm[$field_name] = $tbl1.".".$field_name;
				//inserisco i campi comuni nell'array esterno
				//$fields_found = array_merge($fields_found, $comm);
			}
			for($k = 0; $k < sizeof($common_full); $k++){
				$field_namef = $common_full[$k];
				//$connectors_arrayf[$tbl1.".".$field_namef] = $tbl2.".".$field_namef;
				//setto come valore tabella.campo
				$commf[$field_namef] = $tbl1.".".$field_namef;
				//inserisco i campi comuni nell'array esterno
				$fields_foundf = array_merge($fields_foundf, $commf);
			}
			//echo("<br>FULL: <br>");
			//print_r($connectors_arrayf);
			//echo("<br>LEAK: <br>");
			//print_r($connectors_array);
			return $connectors_array;
		}
	}

	/**
	 * Dall'array in ingresso che elenca i nomi delle tabelle
	 * dà in uscita un array che descrive i campi in comune
	 * specificando le tabelle tra le quali sono in comune.
	 *
	 * @param array $tables_array
	 * @return array o boolean
	 */
	public function get_multitbl_connectors_array($tables_array, &$fields_found){
		if(is_array($tables_array)){
			//ordino l'array
			$a = 0;
			$t_a = array();
			foreach ($tables_array as $k => $v){
				$t_a[$a] = $v;
				$a++;
			}
			//inizializzo l'array di uscita
			$multi_connectors_array = array();
			$lenght = sizeof($t_a);
			//doppio ciclo di confronto tabelle
			for($i = 0; $i < $lenght; $i++){
				for($j = $i+1; $j < $lenght; $j++){
					//ricavo l'array dei campi in comune tra le 2 tbls
					$conn = $this->get_tbl_connectors_array(	$t_a[$i],
																$t_a[$j],
																$fields_found);
					//se non hanno campi in comune vado al prossimo ciclo
					if($conn === false){
						continue;
					}else{
						//hanno campi in comune, faccio il merge
						$multi_connectors_array =
							array_merge($multi_connectors_array, $conn);
					}
				}
			}// fine doppio ciclo
			return $multi_connectors_array;
		}else{
			//ingressi errati
			return false;
		}
	}

	private function table_conflict($tbl1, $tbl2, $leaked_array){
		foreach ($leaked_array as $fld_name => $value){
			$f = explode("_", $fld_name);
			$tabella = $f[sizeof($f)-1];
			if($tbl1 == $tabella || $tbl2 == $tabella){
				return array($fld_name);
			}
		}
	}

/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
	GENERATORI DI STRINGHE SQL
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
	/**
	 * Costruisce una query di cancellazione
	 * e la ritorna sottoforma di stringa.
	 *
	 * @param string $table
	 * @param numeric $id
	 * @return unknown
	 */
	public function make_delete_query($table, $id_value_array){
		$query = "DELETE FROM ".$table;
		//WHERE
		$query .= " WHERE ";
		foreach($id_value_array as $name => $value){
			if(is_numeric($value)){
				$query .= $name." = ".$value;
			}else{
				// se è una stringa aggiungo gli apici
				$query .= $name." = '".$value."'";
			}
			$query .= " AND ";
		}
		$query = rtrim($query," AND ");
		return $query;
	}

	public function make_select_query(	$table,
										$fields_name_array = null,
										$where_field_array = null,
										$order_by_array = null,
										$start = null,
										$righe = null){
		// SELECT
		//--------------------------------------------------------------
		/**
		 * GMAP distance FILTER
		 */
		$f_array = array();
		$v_array = array();
		$gmapselect = "";
		if(	!is_null($order_by_array) &&
				is_array($order_by_array) &&
				isset($order_by_array['gmapfilter'])){
			$gmap = $order_by_array['gmapfilter'];
			foreach ($gmap as $f => $v){
				array_push($f_array,$f);
				array_push($v_array,$v);
			}
			//unset($order_by_array[2]);
			$gmapselect =	"( 6371 * acos( cos( radians( ".
							$v_array[0] //v_lat:37
							." ) ) * cos( radians( ".
							$f_array[0] //f_lat:latgmap_struttura
							." ) ) * cos( radians( ".
							$f_array[1] //f_lng:lng_struttura
							." ) - radians( ".
							$v_array[1] //v_lng:-122
							." ) ) + sin( radians( ".
							$v_array[0] //v_lat:37
							." ) ) * sin( radians( ".
							$f_array[0] //f_lat:latgmap_struttura
							." ) ) ) ) AS distance";
		}
		//--------------------------------------------------------------

		if(is_null($fields_name_array)){
			// seleziona tutti i campi
			$query = "SELECT *";
			if($gmapselect != ""){
				$query .= ", ".$gmapselect;
			}
			$query .= " FROM $table";
		}
		elseif(is_array($fields_name_array)){
			// seleziona i campi specificati nell'array
			$query ="SELECT ";
			$lenght = sizeof($fields_name_array);
			foreach ($fields_name_array as $field) {
				if($lenght>1){
					$query .= $field;
					$query .= ", ";
					$lenght--;
				}
				else{
					$query .= $field;
					if($gmapselect != ""){
						$query .= ", ".$gmapselect;
					}
					$query .= " FROM ".$table;
				}
			}
		}
		// WHERE
		if(!is_null($where_field_array)&&
			is_array($where_field_array)){
			// Primo valore corrisponde al WHERE
			$query .=	" WHERE ";
			foreach($where_field_array as $field1 => $field2){
				if (is_null($field2) || $field2 == '') {
					$query .= $field1." is "."NULL";
				}else if(is_numeric($field2)){
						$query .= $field1." = ".$field2;
				}else{
					// se è una stringa aggiungo gli apici
					$query .= $field1." = '".$field2."'";
				}
				$query .= " AND ";
			}
			$query = rtrim($query," AND ");
		}
		// ORDER BY
		if(!is_null($order_by_array)&&
			is_array($order_by_array)){
			//---------------------------------------------------
			/**
			 * Gmap distance FILTER
			 */
			if($v_array != array()){
				$query .= " HAVING distance < ".$v_array[2];
				unset($order_by_array['gmapfilter']);
			}
			//---------------------------------------------------
			$query .=	" ORDER BY ".
						key($order_by_array).
						" ".
						current($order_by_array);
		}
		// LIMIT
		if (!is_null($start) && !is_null($righe)) {
			$query .= " LIMIT ".$start.", ".$righe;
		}
		//$query .= ";";
		return $query;
	}

	/**
	 * TESTATA
	 *
	 * @param array $fields_name_array
	 * @param array $table_name_array
	 * @param array $where_id
	 * @return string
	 */
	public function make_select_join_andor_query(	$fields_name_array,
													$table_name_array,
													$and_where = null,
													$or_where = null,
													$order_by_array = null,
													$start = null,
													$righe = null) {
		//array dei campi diventati connectors
		$conn = array();
		//creo l'array di where sui campi connectors
		$whr_array = $this->get_multitbl_connectors_array(	$table_name_array,
															$conn);
		$query ="SELECT ";
		// Nomi dei campi connectors comuni con $fields_name_array
		foreach ($fields_name_array as $field) {
			if(key_exists($field, $conn)){
				//il campo è uno dei connettori
				$query .= $conn[$field];
			}else{
				//il campo non è un connettore
				$query .= $field;
			}
			$query .= ", ";
		}
		//--------------------------------------------------------------
		/**
		 * GMAP distance FILTER
		 */
		$f_array = array();
		$v_array = array();
		if(	!is_null($order_by_array) &&
				is_array($order_by_array) &&
				isset($order_by_array['gmapfilter'])){
			$gmap = $order_by_array['gmapfilter'];
			foreach ($gmap as $f => $v){
				array_push($f_array,$f);
				array_push($v_array,$v);
			}
			//unset($order_by_array[2]);
			$query .=	"( 6371 * acos( cos( radians( ".
							$v_array[0] //v_lat:37
							." ) ) * cos( radians( ".
							$f_array[0] //f_lat:latgmap_struttura
							." ) ) * cos( radians( ".
							$f_array[1] //f_lng:lng_struttura
							." ) - radians( ".
							$v_array[1] //v_lng:-122
							." ) ) + sin( radians( ".
							$v_array[0] //v_lat:37
							." ) ) * sin( radians( ".
							$f_array[0] //f_lat:latgmap_struttura
							." ) ) ) ) AS distance";
		}
		//--------------------------------------------------------------
		$query = rtrim($query,", ");

		//FROM
		$query .= " FROM ";
		// Nomi delle tabelle
		foreach ($table_name_array as $tbl_name) {
				$query .= $tbl_name;
				$query .= ", ";
			}
		$query = rtrim($query,", ");
		$query .= " WHERE ";

		//WHERE AND
		foreach($whr_array as $field1 => $field2){
			$query .= $field1." = ".$field2;
			$query .= " AND ";
		}
		if(is_array($and_where) && $and_where !== array()){
			foreach($and_where as $field1 => $field2){
				if (is_null($field2) || $field2 == '') {
					$query .= $field1." is "."NULL";
				}else if(is_numeric($field2)){
						$query .= $field1." = ".$field2;
				}else{
					// se è una stringa aggiungo gli apici
					$query .= $field1." = '".$field2."'";
				}
				$query .= " AND ";
			}
		}
		//WHERE OR
		if(is_array($or_where) && $or_where !== array()){
			foreach ($or_where as $or_wheref){
				if(sizeof($or_where)>1){
					$query .= " ( ";
				}
				for($x = 0; $x < sizeof($or_wheref); $x++){
					$or_wherex = $or_wheref[$x];
					foreach($or_wherex as $field1 => $field2){
						if (is_null($field2) || $field2 == '') {
							$query .= $field1." is "."NULL";
						}else if(is_numeric($field2)){
								$query .= $field1." = ".$field2;
						}else{
							// se è una stringa aggiungo gli apici
							$query .= $field1." = '".$field2."'";
						}
						$query .= " OR ";
					}
				}
				$query = rtrim($query," OR");
				if(sizeof($or_where)>1){
					$query .= " ) ";
				}
				$query .= " AND ";
			}
		}
		$query = rtrim($query," AND ");

		//---------------------------------------------------
		/**
		 * Gmap distance FILTER
		 */
		if($v_array != array()){
			$query .= " HAVING distance < ".$v_array[2];
			unset($order_by_array['gmapfilter']);
		}
		//---------------------------------------------------

		// ORDER BY
		if(!is_null($order_by_array)&&
			is_array($order_by_array)){

			$query .=	" ORDER BY ".
						key($order_by_array).
						" ".
						current($order_by_array);
		}
		// LIMIT
		if (!is_null($start) && !is_null($righe)) {
			$query .= " LIMIT ".$start.", ".$righe;
		}
		return $query;
	}

	/**
	 * TESTATA
	 *
	 * @param array $fields_name_array
	 * @param array $table_name_array
	 * @param array $where_id
	 * @return string
	 */
	public function make_select_join_query(	$fields_name_array,
											$table_name_array,
											$where_id = null,
											$order_by_array = null,
											$start = null,
											$righe = null) {
		//array dei campi diventati connectors
		$conn = array();
		//creo l'array di where sui campi connectors
		$whr_array = $this->get_multitbl_connectors_array(	$table_name_array,
															$conn);
		$query ="SELECT ";
		// Nomi dei campi connectors comuni con $fields_name_array
		foreach ($fields_name_array as $field) {
			if(key_exists($field, $conn)){
				//il campo è uno dei connettori
				$query .= $conn[$field];
			}else{
				//il campo non è un connettore
				$query .= $field;
			}
			$query .= ", ";
		}

		//--------------------------------------------------------------
		/**
		 * GMAP distance FILTER
		 */
		$f_array = array();
		$v_array = array();
		if(	!is_null($order_by_array) &&
				is_array($order_by_array) &&
				isset($order_by_array['gmapfilter'])){
			$gmap = $order_by_array['gmapfilter'];
			foreach ($gmap as $f => $v){
				array_push($f_array,$f);
				array_push($v_array,$v);
			}
			//unset($order_by_array[2]);
			$query .=	"( 6371 * acos( cos( radians( ".
							$v_array[0] //v_lat:37
							." ) ) * cos( radians( ".
							$f_array[0] //f_lat:latgmap_struttura
							." ) ) * cos( radians( ".
							$f_array[1] //f_lng:lng_struttura
							." ) - radians( ".
							$v_array[1] //v_lng:-122
							." ) ) + sin( radians( ".
							$v_array[0] //v_lat:37
							." ) ) * sin( radians( ".
							$f_array[0] //f_lat:latgmap_struttura
							." ) ) ) ) AS distance";
		}
		//--------------------------------------------------------------

		$query = rtrim($query,", ");
		//FROM
		$query .= " FROM ";
		// Nomi delle tabelle
		foreach ($table_name_array as $tbl_name) {
				$query .= $tbl_name;
				$query .= ", ";
			}
		$query = rtrim($query,", ");

		//WHERE
		$query .= " WHERE ";
		foreach($whr_array as $field1 => $field2){
			$query .= $field1." = ".$field2;
			$query .= " AND ";
		}
		foreach($where_id as $field1 => $field2){
			if(is_numeric($field2)){
					$query .= $field1." = ".$field2;
			}else{
				// se è una stringa aggiungo gli apici
				$query .= $field1." = '".$field2."'";
			}
			$query .= " AND ";
		}
		$query = rtrim($query," AND ");

		//---------------------------------------------------
		/**
		 * Gmap distance FILTER
		 */
		if($v_array != array()){
			$query .= " HAVING distance < ".$v_array[2];
			unset($order_by_array['gmapfilter']);
		}
		//---------------------------------------------------

		// ORDER BY
		if(!is_null($order_by_array)&&
			is_array($order_by_array)){

			$query .=	" ORDER BY ".
						key($order_by_array).
						" ".
						current($order_by_array);
		}
		// LIMIT
		if (!is_null($start) && !is_null($righe)) {
			$query .= " LIMIT ".$start.", ".$righe;
		}
		return $query;
	}

    /**
	 * Costruisce una query di inserimento
	 * e la ritorna sottoforma di stringa.
	 *
	 * @param string $table
	 * @param array() $fields_array l'array contenente come chiavi
	 * il nome del campo e come valori i corrispettivi valori
	 * @return string
	 */
	public function make_insert_query($table, $fields_array){
		$query ="INSERT INTO ".$table." SET ";
		$lenght = sizeof($fields_array);
		foreach ($fields_array as $field => $field_value) {


			if($lenght>1){
				$query .= $field;
				if(is_numeric($field_value)){
					$query .= " = ".$field_value;
				}else if(is_null($field_value) || $field_value == ''){
					$query .= " = "."NULL";
				}else{
					$query .= " = '".$field_value."'";
				}
				$query .= ", ";
				$lenght--;
			}
			else{
				$query .= $field;
				if(is_numeric($field_value)){
					$query .= " = ".$field_value;
				}else if(is_null($field_value) || $field_value == ''){
					$query .= " = "."NULL";
				}else{
					$query .= " = '".$field_value."'";
				}
				$query .= ";";
			}


			/*
			if($lenght>1){
				$query .= $field;
				if(is_null($field_value) || $field_value == ''){
					$query .= " = "."NULL";
				}else if(is_int($field_value)){
					$query .= " = ".$field_value;
				}else{
					$query .= " = '".$field_value."'";
				}
				$query .= ", ";
				$lenght--;
			}
			else{
				$query .= $field;
				if(is_null($field_value) || $field_value == ''){
					$query .= " = "."NULL";
				}else if(is_numeric($field_value)){
					$query .= " = ".$field_value;
				}else{
					$query .= " = '".$field_value."'";
				}
				$query .= ";";
			}
			*/


		}
		return $query;
	}

	/**
	 * Costruisce una query di aggiornamento
	 * e la ritorna sottoforma di stringa.
	 *
	 * @param $string $table
	 * @param string $id
	 * @param array $fields_array
	 * @param string $where_alternativo il nome della tabella alternativa
	 * @return string
	 */
	public function make_update_query(	$table,
										$id_value_array,
										$fields_array){
		$query ="UPDATE ".$table." SET ";
		$lenght = sizeof($fields_array);
		foreach ($fields_array as $field => $field_value) {
			if($lenght>1){
				$query .= $field;
				if (is_null($field_value) || $field_value == '') {
					$query .= " = "."NULL";
				}else if(is_numeric($field_value)){
					$query .= " = ".$field_value;
				}else{
					$query .= " = '".$field_value."'";
				}
				$query .= ", ";
				$lenght--;
			}
			else{
				$query .= $field;
				if (is_null($field_value) || $field_value == '') {
					$query .= " = "."NULL";
				}else if(is_numeric($field_value)){
					$query .= " = ".$field_value;
				}else{
					$query .= " = '".$field_value."'";
				}

				//WHERE
				$query .= " WHERE ";
				foreach($id_value_array as $name => $value){
					if (is_null($value) || $value == '') {
						$query .= " is "."NULL";
					}else if(is_numeric($value)){
						$query .= $name." = ".$value;
					}else{
						// se è una stringa aggiungo gli apici
						$query .= $name." = '".$value."'";
					}
					$query .= " AND ";
				}
				$query = rtrim($query," AND ");
			}
		}
		return $query;
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