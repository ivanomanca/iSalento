<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Select abstraction. It is an array of groups of options.
 * To don't use groups simply use an array of options without 
 * using the array key.
 *	
 * EXAMPLE CODE:
 * <label> Text </label> 
  <select name="choice" style="width:200">
    <option selected="selected" label="none" value="none"> none </option>
    <optgroup label="Group 1">
        <option label="cg1a" value="val_1a">Selection group 1a </option>
        <option label="cg1b" value="val_1b">Selection group 1b </option>
        <option label="cg1c" value="val_1c">Selection group 1c </option>
    </optgroup>
    <optgroup label="Group 2">
        <option label="cg2a" value="val_2a">Selection group 2a </option>
        <option label="cg2b" value="val_2a">Selection group 2b </option>
    </optgroup>
  </select>
 */
 
class Select extends Isp_View_Snippet{
	public $snippetType = "Html";
	
	/**
	 * Object state
	 */
	public $selectName = null; 
	public $options = null;
	public $optionsCount = 0; // Detect group (=3) or just option items (=2)
	public $label = null;
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classSelectInput = null; // Passed from input
	public $idSelectInput = null; // Passed from input
	public $style = null;
	
	/**
	 * Constructor
	 *
	 * @param string $selectName - Select name.
	 * @param matrix $options - array of option items or array 
	 * of groups of option items. 
	 * The former has the following form: array(optionItems)
	 * The latter has the following form: 
	 * array("groupName1"=>array(optionItems),"groupName2"=>array(optionItems))
	 * To print mixed groups and simple option items don't use the 
	 * associative key used to assign the group name. For example:
	 * array(array(optionItems),"groupName2"=>array(optionItems))
	 * 
	 * An option item is an array containing the following inputs: 
	 * - 1st argument: boolean (to set the option item as selected)
	 * - 2nd argument: string - the label name
	 * - 3rd argument: string - the value
	 * - 4th argument: string - description to show to the user
	 * Eg: 
	 * <option selected="selected" label="lab" value="test">Description</option>
	 * would be: array(true,"lab","test","Description")
	 * 
	 * Complete example: array("groupName"=>array(array(true,"label","value","description")))
	 * 
	 * @param string $classSelectInput - markup class name for select tag
	 * @param string $idSelectInput - markup id name for select tag
	 * @param string $label - text to show the user
	 * @param string $style - markup formatting
	 */
	public function __construct($selectName=null,
								$options, 
								$classSelectInput=null,
								$idSelectInput = null,
								$label = null,
								$style = null){
									
		// Store into object state
		$this->setState("selectName",$selectName);
		$this->setState("options",$options);
		$this->setState("classSelectInput",$classSelectInput);
		$this->setState("idSelectInput",$idSelectInput);
		$this->setState("label",$label);
		$this->setState("style",$style);
		
		parent::__contruct();
		
		// Detect if group or just option items are passed
		while(is_array($options)){
			$options = reset($options);
			$this->optionsCount  ++; 
		}// Note $this->options has not changed
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		
		if(isset($this->idSelectInput)){ 	// Prepare id 
			$id = "id=\"$this->idSelectInput\" ";
		}else{
			$id = null;
		}
		if(isset($this->classSelectInput)){ // Prepare class
			$class = "class=\"$this->classSelectInput\" ";
		}else {
			$class = null;
		}
		if(isset($this->style)){ // Prepare style
			$style = "style=\"$this->style\" ";
		}else {
			$style = null;
		}
		
		$code = "";
		// Open label
		if(isset($this->label)){
			$code .= $this->openTag(null, null, "label");
				$code .= $this->label;
			$code .= $this->closeTag("label");
		}
		// Open select tag
		$code .= "<select name=\"$this->selectName\" $id $class $style> ";
		// Print option items and groups
		if($this->optionsCount == 2){ // Simple option items list 
			foreach ($this->options as $item){
				// <option selected="selected" label="none" value="none">none</option>
				$code .= "<option ";
				// Check selected option
				if($item[0]){
					$code .= "selected=\"selected\" ";
				}	
				$code .= "label=\"".$item[1]."\" value=\"".$item[2]."\">".$item[3];
				$code .= "</option>	";						
			}	
		}elseif($this->optionsCount == 3){ // Groups 
			foreach ($this->options as $key=>$group){
				 // If groupName has been defined wrap with group tag
				if(is_string($key)){
					$code .= "<optgroup label=\"$key\">";
				}	
				foreach ($group as $item){
					// <option selected="selected" label="none" value="none">none</option>
					$code .= "<option ";
					// Check selected option
					if($item[0]){
						$code .= "selected=\"selected\" ";
					}	
					$code .= "label=\"".$item[1]."\" value=\"".$item[2]."\">".$item[3];
					$code .= "</option>	";		
				}
				// Close optgroup
				if(is_string($key)){ 
					$code .= "</optgroup>";
				}
			}
		}	
		// Close select
		$code .= $this->closeTag("select");	
		return $code;
	}	
}
?>