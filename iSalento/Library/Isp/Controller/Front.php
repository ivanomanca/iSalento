<?php
/**
 * It manages the entire environment in a singleton pattern.
 * It is the highest abstraction of the site.
 *
 * The request and response objects are registered with the
 * controller, as should be any additional optional arguments.
 * They are available to all of the action ctrl istantiated.
 *
 * A dispatch loop is carried out to dispatch every request
 * made either from the userland environment or from a single
 * action ctrl involved in the "response delivery" loop.
 */
class Isp_Controller_Front{

    // Singleton instance
    public static $_instance = null;

    // Request object istance
    public $request = null;

    // Response object istance
    public $response = null;

    // Default action
    public $defaultComponent = "Page";
    public $defaultTask = "getPage";
    public $defaultPageType = "Extra";
    public $defaultPage = "ExtraHome";

    /**
     * Constructor, initializes request and response.
     * The request holds all the request environment.
     * The response will collect all the html to print.
     */
    protected function __construct()
    {
    	$this->setRequest();
    	$this->setResponse();
    }

    /**
     * Singleton instance
     *
     * @return front
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Set request class/object
     */
    public function setRequest()
    {
    	require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Request.php");
        $this->request = new Isp_Controller_Request();

    }

    /**
     * Set response class/object
     *
     * Set the response object.  The response is a container for action
     * responses and headers. Usage is optional.
     *
     * @todo If a class name is provided, instantiates a response object.
     *
     */
    public function setResponse()
    {
       require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Response.php");
        $this->response = new Isp_Controller_Response();
    }

    /**
     * Makes default action is no sufficient parameters are passed.
     * Default action could be redirectin to home page.
     *
     */
    public function defaultAction(){
    	$this->request->component = $this->defaultComponent;
    	$this->request->task = $this->defaultTask;
    	$this->request->params["pageType"] = $this->defaultPageType;
    	$this->request->params["page"] = $this->defaultPage;

    }

    /**
     * It dispatches the request to the right action ctrl specified
     * in the request. If the request is re-feeded by an action ctrl
     * it enters a loop. At the end of the loop the output from the
     * response is called.
     *
     * All it is needed to dispatch a request are the structural params
     * of the request object.
     *
     */
    public function dispatch(){
    	// Make default action if no sufficient parameters are passed
    	if(!isset($this->request->component) and !isset($this->request->task)){
    		$this->defaultAction();
    	}

    	// Se abilitato, includo il controllo Https
    	if($_SERVER['httpsEnabled']){
    		include(	$_SERVER['DOCUMENT_ROOT']
    					."Library/Isp/Inc/Security/HttpsConf.php");
    	}

    	// While request dispatched flag is false (not dispatched)
    	while(!$this->request->dispatched){ // Dispatch

			// If a ctrl name is not specified use compenet name as default
			if(is_null($this->request->ctrl)){
				$action_ctrl = $this->request->component;
			}else{
				$action_ctrl = $this->request->ctrl;
			}

			//per convenzione
			$action_ctrl= ucfirst($action_ctrl);

			// Method to invoke in the action ctrl
			$task = (string) $this->request->task;

			// Action Ctrl live!
			require_once($_SERVER['DOCUMENT_ROOT']
				."Library/Isp/Controller/Action.php");
			$actionCtrlPath = $_SERVER['DOCUMENT_ROOT']."Components/";

			$actionCtrlPath .= $this->request
											->component."/Controllers/$action_ctrl.php";
			require_once($actionCtrlPath);

			$ctrl = new $action_ctrl();

			// Set request dispatched to stop the loop (if there are no re-feed)
			$this->request->dispatched = true;

			// Invoke the action ctrl method
			$ctrl->$task();

			// Destroy action ctrl after the task has been performed
      		$ctrl = null;
    	}
    	// Out the built html in the response
    	$this->response->outputBody();
    }
}
?>