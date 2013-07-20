<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Input text 
 * 
 * EXAMPLE CODE:
  	Label txt
  	<input id="" class="" type="text" name="nome" value="val" size="85" />
 */
 
class Input extends Isp_View_Snippet{
	public $snippetType = "Form";
	
	/**
	 * Object state
	 */
	public $type; 
	public $label; 
	public $labelAtEnd; 
	public $dbName; 
	public $value; 
	public $size; 
	public $extraConfArray;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $id = null;
	public $class = null;
	
	/**
	 * Constructor
	 *
	 * @param string $type - input, submit, text, hidden, ecc.
	 * @param string $label - The name to show to user
	 * @param String $dbName - name of the field taken from db
	 * @param Boolean $labelAtEnd - true to print the label after input tag
	 * @param string $value - value of the tag
	 * @param int $size - lenght of input tag
	 * @param string $id - markup id for css
	 * @param string $class - markup class for css
	 * @param array $extraConfArray - array("checked" => "yes", ..), extra config options
	 */
	public function __construct($type,
								$label = null, 
								$dbName, 
								$labelAtEnd = false, 
								$value = null,
								$size = null,
								$id = null,
								$class = null,
								$extraConfArray = null){
									
		// Store into object state
		$this->setState("type",$type);
		$this->setState("label",$label);
		$this->setState("dbName",$dbName);
		$this->setState("labelAtEnd",$labelAtEnd);
		$this->setState("value",$value);
		$this->setState("size",$size);
		$this->setState("id",$id);
		$this->setState("class",$class);
		$this->setState("extraConfArray",$extraConfArray);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	
	public function render(){
		$code = "";
		
		if(!$this->labelAtEnd){
			$code .= $this->label;
		}
		$code .= "<input ";
		if(isset($this->id)){
			$code .= "id=\"".$this->id."\" ";
		}
		if(isset($this->class)){
			$code .= "class=\"".$this->class."\" ";
		}

		$code .= "type=\"".$this->type."\" ";
		
		$code .= "name=\"".$this->dbName."\" ";
		
		if(isset($this->size)){
			$code .= "size=\"".$this->size."\" ";
		}	
		
		if(isset($this->value)){
			$code .= "value=\"".$this->value."\" ";
		}
		
		// Extra params
		if(isset($this->extraConfArray)){
			foreach ($this->extraConfArray as $nameParam => $value){
				$code .= $nameParam." ";
				if(!is_null($value)){
					$code .= "= \"$value\" ";
				}
			}
		}
		
		$code .= "> ";
		$code .= "</input>";
		
		
		if($this->labelAtEnd){
			$code .= $this->label;
		}
		return $code;
	
	}	
}
?>