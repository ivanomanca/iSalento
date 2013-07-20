<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Text Area 
 * 
 * EXAMPLE CODE:
  	Label text
  	<textarea id="" class="" cols="100" rows="20" name="dbName"/>
 */
 
class TextArea extends Isp_View_Snippet{
	public $snippetType = "Form";
	
	/**
	 * Object state
	 */
	public $label;
	public $dbName;
	public $cols; 
	public $rows; 
	public $default; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $id = null;
	public $class = null;
	
	/**
	 * Constructor
	 *
	 * @param string $label - The name to show to user
	 * @param String $dbName - name of the field taken from db
	 * @param int $cols - number of cols
	 * @param int $rows - number of rows
	 * @param string $id - markup id for css
	 * @param string $class - markup class for css
	 */
	public function __construct($label, 
								$dbName, 
								$cols = 100,
								$rows = 20,
								$id = null,
								$class = null,
								$default = null){
									
		// Store into object state
		$this->setState("label",$label);
		$this->setState("dbName",$dbName);
		$this->setState("cols",$cols);
		$this->setState("rows",$rows);
		$this->setState("id",$id);
		$this->setState("class",$class);
		$this->setState("default", $default);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	
	public function render(){
		$code = "";
		$code .= $this->label;
		$code .= "<textarea ";
		if(isset($this->id)){
			$code .= "id=\"".$this->id."\" ";
		}
		if(isset($this->class)){
			$code .= "class=\"".$this->class."\" ";
		}
		$code .= "name=\"".$this->dbName."\" ";
		$code .= "cols=\"".$this->cols."\" ";
		$code .= "rows=\"".$this->rows."\" >";
		$code .= $this->default;
		$code .= "</textarea>";
		
		return $code;
	
	}	
}
?>