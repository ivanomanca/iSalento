<?php
if(!class_exists("ErrorType")){
	require_once(	$_SERVER['DOCUMENT_ROOT']
						.'Components/Error/Models/ErrorType.php');
}
/**
 * ObjError
 */
class Isp_Db_ObjError {

	public $errType = 0;	// errore generico di default
	public $errCode;		// stringa sql di errore
	public $errNote;	// commento all'errore

	public function __construct(	$errType = null,
											$errCode = null,
											$errNote = null){
		if($errType !== null){
			$this->errType = $errType;
		}
		$this->errCode = $errCode;
		$this->errNote = $errNote;
	}
}
