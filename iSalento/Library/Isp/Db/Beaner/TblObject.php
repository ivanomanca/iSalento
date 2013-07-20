<?php
/**
 * Classe padre degli oggetti tabella
 * 
 */
class Isp_Db_Beaner_TblObject {
	public $ntt;
	
	/**
	 * Crea un nuovo oggetto
	 *
	 * @param array $fields_array
	 * @return TblObject
	 */
	public function __construct($fields_array){
		$this->set_fields($fields_array);
	}
	
	/**
	 * Setta i campi card
	 * @param array $fields_array
	 */
	public function set_fields($fields_array){
		$keys_array = array_keys($fields_array);
		foreach ($keys_array as $field){
			if(array_key_exists($field, $this)){
				$this->$field = $fields_array[$field];
			}
		}
	}
	
	/**
	 * Ritorna un array contenente le chiavi e i valori
	 * dei campi diversi da null
	 *
	 * @return $bean_array
	 */
	public function get_bean_array(){
		$bean_array = array();
		foreach ($fields_filter as $key){
			if(isset($this[$key])){
				$bean_array[$key] = $this[$key];
			}
		}
		return $bean_array;
	}
	
	public function get_ntt(){
		return $this->ntt;
	}
}
?>