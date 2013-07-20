<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Href snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 * List separator, provides the top line to 
 * separate list items.
 *	
 * EXAMPLE CODE:
 * <div class="separatore">
	  <?if(isset($leftLink)){?>
			<div class="left">
		      <h3><?= $leftLink->title?></h3>
		    </div>	
	  <?}if(isset($rightLink)){?>
		    <span class="right">
			  <a href="<?= $rightLink->path ?>"><?= $rightLink->title?></a>
			</span> 
	  <?}?>
    </div>
 */
 
class Separator extends Isp_View_Snippet{
	public $snippetType = "List";
	
	/**
	 * Object state
	 */
	public $leftUrl = null; 
	public $rightUrl = null; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classSeparator = "separatore";
	public $classLeft = "left";
	public $classRight = "right";
	
	/**
	 * Constructor
	 *
	 * @param Isp_Url | string $leftUrl - set null to hide
	 * @param Isp_Url | string $rightUrl - set null to hide
	 */
	public function __construct($leftUrl=null, $rightUrl=null){
		// Store into object state
		$this->leftUrl = $leftUrl;
		$this->rightUrl = $rightUrl;
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
  
		// Div separator
		$code = $this->openTag(null,$this->classSeparator);
		// Add left option
		if(isset($this->leftUrl)){
			$code .= $this->openTag(null,$this->classLeft);
			if($this->leftUrl instanceof Isp_Url){
				$href = new Href($this->leftUrl);
				$left = $href->code;
			}else{
				$left = $this->leftUrl;
			}
			$code .= "<h3>".$left."</h3>";
			$code .= $this->closeTag();
		}
		// Add right option
		if(isset($this->rightUrl)){
			$code .= $this->openTag(null,$this->classRight,"span");
			if($this->rightUrl instanceof Isp_Url){
				$href = new Href($this->rightUrl);
				$right = $href->code;
			}else{
				$right = $this->rightUrl;
			}
			$code .= $right;
			$code .= $this->closeTag("span");
		}
		$code .= $this->closeTag();
		
		return $code;
	}	
	
}
?>