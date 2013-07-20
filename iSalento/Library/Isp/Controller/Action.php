<?php
/** Isp_Controller_Front */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Front.php";

/** Isp_Controller_Request */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Request.php";

/** Isp_Controller_Response */
require_once $_SERVER['DOCUMENT_ROOT']."Library/Isp/Controller/Response.php";

/**
 * The basic unit of the personalized site code.
 * This abstract class need to be extended and it
 * makes general methods and vars avalilable to the
 * extended action ctrl.
 *
 * !CONVENTION: The task name (method to invoke)
 * cannot have the same name as the class name.
 * Should this happen, the constructor would be
 * called twice.
 */
abstract class Isp_Controller_Action
{
    /**
     * Front controller instance
     * @var Isp_Controller_Front
     */
    public $front;

    /**
     * Class constructor
     */
    public function __construct(){
    	// Make the front ctrl available
    	$this->getFrontController();
    }

    /**
     * Retrieve Front Controller
     *
     * @return Isp_Controller_Front
     */
    public function getFrontController()
    {
        // Used cache version if found
        if (null !== $this->front) {
            return $this->front;
        }

        // Grab singleton instance, if class has been loaded
        if (class_exists('Isp_Controller_Front')) {
            $this->front = Isp_Controller_Front::getInstance();
            return $this->front;
        }

    }

    /**
     * Forward to another controller/action by re-feeding
     * the request object.
     *
     * @todo check that there are no key with the same
     * name when merging params to the request
     * @todo check userParams, try using array merge
     * @param string $task
     * @param string $component
     * @param string $ctrl
     * @param array $params
     */
    public function forward(	$task, $component,
    									$ctrl = null, array $params = null){
		/**
         * 1. Append any params to request
         *
         */
		if (null !== $params) {
			// userParams, cambiare +=
			//$this->front->request->params += $params;
			$this->front->request->params = array_merge(
				$this->front->request->params, $params);

        }

        /**
         * 2. Overwrite structural parameter request
         */
        if (null !== $ctrl) { // If ctrl name is specified
            $this->front->request->ctrl = $ctrl;
        }else{ // Default
        	$this->front->request->ctrl = null;
        }

		// Re-feed request for a new dispatch loop to start
        $this->front->request->component = $component;
        $this->front->request->task = $task;


        /**
         * 3. Notice a new request needs to be dispatched
         */
		$this->front->request->dispatched = false;
    }

    /**
     * Render a skeleton of a page object and append
     * it to the response
     *
     * @param Isp_View_Page $page - page to render
     */
    public function renderView(Isp_View_Page $page){
		// Render e append alla response
		$this->front->response->appendArray($page->render());
    }
}

/**
 * UTILITIES
 */

    /**
     * Render a view
     *
     * Renders a view. By default, views are found in the view script path as
     * <controller>/<action>.phtml. You may change the script suffix by
     * resetting {@link $viewSuffix}. You may omit the controller directory
     * prefix by specifying boolean true for $noController.
     *
     * By default, the rendered contents are appended to the response. You may
     * specify the named body content segment to set by specifying a $name.
     *
     * @see Zend_Controller_Response_Abstract::appendBody()
     * @param  string|null $action Defaults to action registered in request object
     * @param  string|null $name Response object named path segment to use; defaults to null
     * @param  bool $noController  Defaults to false; i.e. use controller name as subdir in which to search for view script
     * @return void
     */
   /* public function render($action = null, $name = null, $noController = false)
    {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            return $this->_helper->viewRenderer->render($action, $name, $noController);
        }

        $view   = $this->initView();
        $script = $this->getViewScript($action, $noController);

        $this->getResponse()->appendBody(
            $view->render($script),
            $name
        );
    }*/

    /**
     * Render a given view script
     *
     * Similar to {@link render()}, this method renders a view script. Unlike render(),
     * however, it does not autodetermine the view script via {@link getViewScript()},
     * but instead renders the script passed to it. Use this if you know the
     * exact view script name and path you wish to use, or if using paths that do not
     * conform to the spec defined with getViewScript().
     *
     * By default, the rendered contents are appended to the response. You may
     * specify the named body content segment to set by specifying a $name.
     *
     * @param  string $script
     * @param  string $name
     * @return void
     */
    /*public function renderScript($script, $name = null)
    {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            return $this->_helper->viewRenderer->renderScript($script, $name);
        }

        $view = $this->initView();
        $this->getResponse()->appendBody(
            $view->render($script),
            $name
        );
    }*/

    /**
     * Construct view script path
     *
     * Used by render() to determine the path to the view script.
     *
     * @param  string $action Defaults to action registered in request object
     * @param  bool $noController  Defaults to false; i.e. use controller name as subdir in which to search for view script
     * @return string
     * @throws Zend_Controller_Exception with bad $action
     */
   /* public function getViewScript($action = null, $noController = null)
    {
        if (!$this->getInvokeArg('noViewRenderer') && $this->_helper->hasHelper('viewRenderer')) {
            $viewRenderer = $this->_helper->getHelper('viewRenderer');
            if (null !== $noController) {
                $viewRenderer->setNoController($noController);
            }
            return $viewRenderer->getViewScript($action);
        }

        $request = $this->getRequest();
        if (null === $action) {
            $action = $request->getActionName();
        } elseif (!is_string($action)) {
            throw new Zend_Controller_Exception('Invalid action specifier for view render');
        }

        if (null === $this->_delimiters) {
            $dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
            $wordDelimiters = $dispatcher->getWordDelimiter();
            $pathDelimiters = $dispatcher->getPathDelimiter();
            $this->_delimiters = array_unique(array_merge($wordDelimiters, (array) $pathDelimiters));
        }

        $action = str_replace($this->_delimiters, '-', $action);
        $script = $action . '.' . $this->viewSuffix;

        if (!$noController) {
            $controller = $request->getControllerName();
            $controller = str_replace($this->_delimiters, '-', $controller);
            $script = $controller . DIRECTORY_SEPARATOR . $script;
        }

        return $script;
    }*/


    /**
     * Call the action specified in the request object, and return a response
     *
     * Not used in the Action Controller implementation, but left for usage in
     * Page Controller implementations. Dispatches a method based on the
     * request.
     *
     * Returns a Zend_Controller_Response_Abstract object, instantiating one
     * prior to execution if none exists in the controller.
     *
     * {@link preDispatch()} is called prior to the action,
     * {@link postDispatch()} is called following it.
     *
     * @param null|Zend_Controller_Request_Abstract $request Optional request
     * object to use
     * @param null|Zend_Controller_Response_Abstract $response Optional response
     * object to use
     * @return Zend_Controller_Response_Abstract
     */
    /*public function run(Zend_Controller_Request_Abstract $request = null, Zend_Controller_Response_Abstract $response = null)
    {
        if (null !== $request) {
            $this->setRequest($request);
        } else {
            $request = $this->getRequest();
        }

        if (null !== $response) {
            $this->setResponse($response);
        }

        $action = $request->getActionName();
        if (empty($action)) {
            $action = 'index';
        }
        $action = $action . 'Action';

        $request->setDispatched(true);
        $this->dispatch($action);

        return $this->getResponse();
    }*/



    /**
     * Redirect to another URL
     *
     * Proxies to {@link Zend_Controller_Action_Helper_Redirector::gotoUrl()}.
     *
     * @param string $url
     * @param array $options Options to be used when redirecting
     * @return void
     */
    /*protected function _redirect($url, array $options = array())
    {
        $this->_helper->redirector->gotoUrl($url, $options);
    }
    */
?>
