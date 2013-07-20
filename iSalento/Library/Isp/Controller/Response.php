<?php
/**
 * Counterpart of the request object. It will collect all 
 * the response related information from action ctrls. 
 * 
 * The main information collected is the HTML to print. 
 * It is stored in a $body array in named chuncks.
 */
class Isp_Controller_Response{
	// Set output format (see out() method below)
	public $outHtmlMode = "echo";
		
	// Chunks of named segments containing HTML
    public $body = array();

 	/**
 	 * Costructor
 	 *
 	 * @param string $outHtmlMode - output format 
 	 * ('echo', 'code', 'file', 'pdf', ecc.)
 	 */
    public function __construct($outHtmlMode=null){
    	// Forces output format to change
    	if(isset($outHtmlMode)){
    		$this->outHtmlMode = $outHtmlMode;
    	}
    }
    
    /**
     * Output a string variable in a specified format
     *
     * @param string $code - output format
     * ('echo', 'code', 'file', 'pdf', ecc.)
     */
	public function out($code){
		switch ($this->outHtmlMode){
			case  "echo":
			 	echo($code);
			case "code":
				return $code;
			case "file":
				// stampa su file
			case "pdf":
				// stampa su pdf
			case "mail":
				// stampa su email..
			default:
                return null;
		}
	}
	
    /**
     * Output all the named segments collected in the 
     * $body array.
     */
    public function outputBody()
    {
        foreach ($this->body as $content) {
            $this->out($content);
        }
    }
    
     /**
     * Append a named body segment to the body content array.
     *
     * @todo Manage if segment name already exists.
     * 
     * @param string $name
     * @param string $content
     */
    
    public function append($name, $content){   
        /*if (isset($this->body[$name])) {
            unset($this->body[$name]);
        }*/
        $this->body[$name] = (string) $content;
    }
    
    /**
     * Append an array to the mody.
     * 
     * !CONVENTION: It is better to have the appended array 
     * in the same format of the body array, that is 
     * with the name of the segment in the key. This makes 
     * easier to manage the output skeleton in a case of 
     * "run time" output composition (Compositor pattern)
     *
     * @param array $array - array to append
     * @todo add an input string to specify the array key 
     * position to start appending in the array stack.
     */
    public function appendArray($array){
    	$this->body = array_merge($this->body, $array);
    }
  
    /**
     * Clear body array
     *
     * With no arguments, clears the entire body array. Given a $name, clears
     * just that named segment; if no segment matching $name exists, returns
     * false to indicate an error.
     *
     * @param  string $name Named segment to clear
     * @return boolean
     */
    public function clearBody($name = null)
    {
        if (null !== $name) {
            $name = (string) $name;
            if (isset($this->body[$name])) {
                unset($this->body[$name]);
                return true;
            }

            return false;
        }

        $this->body = array();
        return true;
    }
}

/**
 * UTILITIES PER SVILUPPI FUTURI
 */
 /**
     * Prepend a named body segment to the body content array
     *
     * If segment already exists, replaces with $content and places at top of
     * array.
     *
     * @param string $name
     * @param string $content
     * @return void
     */
    /*
    public function prepend($name, $content)
    {
        if (!is_string($name)) {
            require_once 'Zend/Controller/Response/Exception.php';
            throw new Zend_Controller_Response_Exception('Invalid body segment key ("' . gettype($name) . '")');
        }

        if (isset($this->body[$name])) {
            unset($this->body[$name]);
        }

        $new = array($name => (string) $content);
        $this->body = $new + $this->body;

        return $this;
    }
*/
    /**
     * Insert a named segment into the body content array
     *
     * @param  string $name
     * @param  string $content
     * @param  string $parent
     * @param  boolean $before Whether to insert the new segment before or
     * after the parent. Defaults to false (after)
     * @return Zend_Controller_Response_Abstract
     */
    /*
    public function insert($name, $content, $parent = null, $before = false)
    {
        if (!is_string($name)) {
            require_once 'Zend/Controller/Response/Exception.php';
            throw new Zend_Controller_Response_Exception('Invalid body segment key ("' . gettype($name) . '")');
        }

        if ((null !== $parent) && !is_string($parent)) {
            require_once 'Zend/Controller/Response/Exception.php';
            throw new Zend_Controller_Response_Exception('Invalid body segment parent key ("' . gettype($parent) . '")');
        }

        if (isset($this->body[$name])) {
            unset($this->body[$name]);
        }

        if ((null === $parent) || !isset($this->body[$parent])) {
            return $this->append($name, $content);
        }

        $ins  = array($name => (string) $content);
        $keys = array_keys($this->body);
        $loc  = array_search($parent, $keys);
        if (!$before) {
            // Increment location if not inserting before
            ++$loc;
        }

        if (0 === $loc) {
            // If location of key is 0, we're prepending
            $this->body = $ins + $this->body;
        } elseif ($loc >= (count($this->body))) {
            // If location of key is maximal, we're appending
            $this->body = $this->body + $ins;
        } else {
            // Otherwise, insert at location specified
            $pre  = array_slice($this->body, 0, $loc);
            $post = array_slice($this->body, $loc);
            $this->body = $pre + $ins + $post;
        }

        return $this;
    }
    */
?>