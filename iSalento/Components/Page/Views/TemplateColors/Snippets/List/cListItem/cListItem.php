<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","List","Separator");
Isp_Loader::loadVistaObj("Snippets","Html","Clear");

/**
 * Single list item. It is made of a separator snippet
 * and provides a box layout for the InBoxItems snippet 
 * or any other element to put in the box.
 *	
 * EXAMPLE CODE:
 * 	Separator;
	<div class="box_lista">
		InBoxItems;
		if(isset($_nbsp)){ echo "<div>&nbsp;</div>"; }
		clear("left");
	</div>
 */
 
class cListItem extends Isp_View_Snippet{
	public $snippetType = "List";
	
	/**
	 * Object state
	 */
	public $separator = null; 
	public $inBoxItems = null;
	public $addSpace = false; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classBoxLayout = "box_lista";
	
	/**
	 * Constructor
	 *
	 * @param ListSeparator $separator - List separator snippet
	 * @param Isp_View_Snippet $inBoxItems
	 * @param boolean $addSpace
	 */
	public function __construct(Separator $separator=null, 
								$inBoxItems=null, 
								$addSpace=null){
		// Store into object state
		$this->setState("separator",$separator);
		$this->setState("inBoxItems",$inBoxItems);
		if(isset($addSpace)){
			$this->setState("addSpace",$addSpace);
		}
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Separator
		if(isset($this->separator)){
			$code = $this->separator->code;
		}else{
			$code="";
		}
		
		$code .= $this->openTag(null,$this->classBoxLayout);
			if(isset($this->inBoxItems)){
				$code .= $this->inBoxItems->code;
			}
			if($this->addSpace){
				$code .= "<div>&nbsp;</div>";
			}
			$clear = new Clear("left");
			$code .= $clear->code;	
			$code .= $this->closeTag();
		
		return $code;
	}	

}
?>