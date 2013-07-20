<?php
/**
 * It contains all the request environment and
 * is available to all action ctrls because the
 * singleton pattern.
 */
class Isp_Controller_Request{

	 /**
     * Has the action been dispatched?
     * @var boolean
     */
    public $dispatched = false;

    /**
     * Structural params
     * @var string
     */
    public $component; // Component name
  	public $ctrl = null; // Action controller name (if not the default one)
    public $task; // Action ctrl method to call

    /**
     * Any other request param
     */
    public $params = array(); // All params
    public $userParams = null; // Specific params (list filters, etc)

    // Convention for multiple params sent by POST
    public $getSimulatorSymbol = "#GETSIMULATOR";
    public $andSymbol = "#KEY";
    public $equalSymbol = "#VALUE";

    /**
     * Constructor
     *
     * @todo If a $uri is passed, the object will attempt to populate itself using
     * that information.
     */
    public function __construct(/*$uri = null*/)
    {
		// Catch any useful request information
    	$this->getStructuralParams();
    	$this->params = $this->getParams();
    	$this->checkForGetSimulator();
    	$this->userParams = $this->getUserParams();

    }

    /**
     * Catch structural params
     */
	public function getStructuralParams(){
		// Picks the component name
		$this->component = $this->get('component');

		// Action controller (if specified)
		if ($this->has('ctrl')){
			$this->ctrl = $this->get('ctrl');
		}else{
			$this->ctrl = null;
		}

    	// Picks the task name (Action ctrl method to call)
		$this->task = $this->get('task');

	}

    /**
     * Retrieve an array of parameters
     *
     * Retrieves a merged array of parameters, with precedence of userland
     * params, $_GET, $POST (i.e., values in the userland params will take
     * precedence over all others).
     *
     * @return array
     */
    public function getParams()
    {
        $return = $this->params;
        if (isset($_GET) && is_array($_GET)) {
            $return = array_merge($return,$_GET);
        }
        if (isset($_POST) && is_array($_POST)) {
          	$return = array_merge($return,$_POST);
        }

        return $return;
    }
    /**
     * Check for multiple data sent by POST in a GET style.
     * Symbol conventions to emulate GET are in this object's state
     *
     * @return it updates $this->params array ensuring there are no
     * condensend parameters.
     */
    private function checkForGetSimulator(){
    	// Scan all parameters
		foreach ($this->params as $key => $param){
			// If a param key indicates it contains multiple params
			if($key === $this->getSimulatorSymbol){
				// First explode, cut off andSymbol
				$onlyValues = explode($this->andSymbol, $param);
				unset($onlyValues[0]); // Unset first element (empty)
				// Second explode
				foreach ($onlyValues as $single){
					$keyParam = explode($this->equalSymbol, $single);
					// Store into params array
					$this->params[$keyParam[0]] = $keyParam[1];
				}
				// Take off GETsimulation and clean up
				unset($this->params[$key]);
			}
		}
    }

    /**
     * Isolate the userland params. By definition
     * they contain at least one underscore (as all
     * the params in the db tables)
     */
    public function getUserParams(){
     	$userParams = array();
     	// Copy only params which contain "_" in the key
     	foreach ($this->params as $key=>$value) {
			if(substr_count($key,"_")>0){
				// At least one occurence in the key
				$userParams[$key] = $value;
			}
		}

     	return $userParams;
     }

	/**
     * Access values contained in the superglobals as public members
     * Order of precedence: 1. GET, 2. POST, 3. COOKIE, 4. SERVER, 5. ENV
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return $this->_params[$key];
            case isset($_GET[$key]):
                return $_GET[$key];
            case isset($_POST[$key]):
                return $_POST[$key];
            case isset($_COOKIE[$key]):
                return $_COOKIE[$key];
          /*  case ($key == 'REQUEST_URI'):
                return $this->getRequestUri();
            case ($key == 'PATH_INFO'):
                return $this->getPathInfo();*/
            case isset($_SERVER[$key]):
                return $_SERVER[$key];
            case isset($_ENV[$key]):
                return $_ENV[$key];
            default:
                return null;
        }
    }

    /**
     * Alias to __get
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->__get($key);
    }

    /**
     * Check to see if a property is set
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return true;
            case isset($_GET[$key]):
                return true;
            case isset($_POST[$key]):
                return true;
            case isset($_COOKIE[$key]):
                return true;
            case isset($_SERVER[$key]):
                return true;
            case isset($_ENV[$key]):
                return true;
            default:
                return false;
        }
    }

    /**
     * Alias to __isset()
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->__isset($key);
    }

}

/**
 * UTILITIES PER SVILUPPI FUTURI
 */
	// NELLO STATO
 	/**
     * Allowed parameter sources
     * @var array
     */
   	//protected $_paramSources = array('_GET', '_POST');

    /**
     * REQUEST_URI
     * @var string;
     */
    //protected $_requestUri;


    // FUNZIONI


     /**
      * Nel costruttore
      */
     /*
        if (null !== $uri) {
            if (!$uri instanceof Zend_Uri) {
                $uri = Zend_Uri::factory($uri);
            }
            if ($uri->valid()) {
                $path  = $uri->getPath();
                $query = $uri->getQuery();
                if (!empty($query)) {
                    $path .= '?' . $query;
                }

                $this->setRequestUri($path);
            } else {
                require_once 'Zend/Controller/Request/Exception.php';
                throw new Zend_Controller_Request_Exception('Invalid URI provided to constructor');
            }
        } else {
            $this->setRequestUri();
        }*/

     /**
      * Vedi anche get headers nella response di zend!
      */
?>