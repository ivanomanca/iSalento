<?php
/** Isp_Controller_Front */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Front.php";

/** Isp_Controller_Request */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Request.php";

/** Isp_Controller_Response */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Response.php";

/** Isp_Controller_Action */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Action.php";
			

/**
 * This abstract class adds instantiate method to the 
 * general action controller.
 * 
 * @todo $this->instancedObj = $className::getInstance(); => php 5.3.0; aggiornare!
 */
abstract class Isp_Controller_Action_Instantiator extends Isp_Controller_Action 
{
	protected $instancedObj;
	
    /**
     * Instanzia l'ObjManager (o altre classi da definire) includendo la classe
     * e gestendo le eventuali eccezioni.
     *
     * @param obj $classToInstantiate
     * @return boolean
     */
    protected function instantiate($classToInstantiate){
    	$ObjInstanceCreated = false;
    	
    	if(isset($classToInstantiate)){
	    	// carico la classe da istanziare con il loader
	        Isp_Loader::loadClass($classToInstantiate);
    		
        	// carico la classe dell'oggetto per la gestione dell'errore
			if(!class_exists("Isp_Db_ObjError")){
        		Isp_Loader::loadClass("Isp_Db_ObjError");
			}
			
	    	try{
	    		//$this->instancedObj = Beaner::getInstance();
	    		$codeString = 	"$"."this->instancedObj =  "
	    						.$classToInstantiate."::getInstance();";
				eval($codeString);
				if($this->instancedObj instanceof $classToInstantiate){
						$ObjInstanceCreated = true;
				}
	        }
	        catch (Exception $e) {
	    		// connessione al db fallita
	    		$ObjInstanceCreated = false;
				$this->forward(	'crudError',
								'Error',
								'Error',
								array(	'failedReq' => $this->front->request,
										'errArray' => array(
										new Isp_Db_ObjError($e->getMessage()))));
	        }
	    }
		//ritorno il booleano
		return $ObjInstanceCreated;
	}
}
?>    
    