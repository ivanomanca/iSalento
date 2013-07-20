<?php
/**
 * Classe SimpleEnquirer
 *
 */
class Isp_Db_SimpleEnquirer {
	 /**
     * Singleton instance
     */
    public static $_instance = null;	// istanza singleton
	private $dao;						// oggetto dao
	private $conf = "/Library/Isp/Inc/objmanagerconf.php";
	private $dao_path = "/Library/Isp/Db/DataAccess.php";
	private $obj_path = "/Library/Isp/Inc/Objects/";
	private $err_path = "/Library/Isp/Db/ObjError.php";
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

   /**
    * Restituisce l'oggettino specificato
    *
    * @param string $tableName
    * @param array filter_array
    * @return obj
    */
    public function getRecord($tableName, $filter_array){

		$query = $this->dao->make_select_query($tableName, null, $filter_array);
	    $esito = $this->dao->invia_query($query);
    	if($esito === false){
    		require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::OBJ_NOT_FOUND, $query,
    												"getObj: Query fallita"));
    		return false;
    	}else{
    		$record_array = array();
    		while($row = $this->dao->get_record()){
    			array_push($record_array, $row);
    		}
			if($record_array == array()){
				$this->note .= 	"<br>getList: la query ".$query.
								" NON HA PRODOTTO RISULTATI"."<br>";
				return null;
			}
			if(!isset($record_array[0])){
				return null;
			}else return $record_array[0];
    	}
	}

	/**
	 * Ritorna la lista della tabella specificata
	 *
	 * @param unknown_type $tableName
	 * @param unknown_type $order_by_array
	 * @param unknown_type $start
	 * @param unknown_type $righe
	 * @return unknown
	 */
	public function getList(	$tableName,
    							$order_by_array = null,
								$start = null,
								$righe = null,
								$simpleFilter_array = null){

		$query = $this->dao->make_select_query(	$tableName,
												null,
												$simpleFilter_array,
												$order_by_array,
												$start = null,
												$righe = null);
	    $esito = $this->dao->invia_query($query);
    	if($esito === false){
    		require_once($_SERVER['DOCUMENT_ROOT'].$this->err_path);
    		array_push(	$this->errorsArray,
    					new Isp_Db_ObjError(	ErrorType::LIST_NOT_FOUND, $query,
    									"getList: Query fallita"));
    		return false;
    	}else{
    		$record_array = array();
    		while($row = $this->dao->get_record()){
    			array_push($record_array, $row);
    		}
			if($record_array == array()){
				$this->note .= 	"<br>getList: la query ".$query.
								" NON HA PRODOTTO RISULTATI"."<br>";
				return null;
			}
			return $record_array;
    	}
	}
}
?>