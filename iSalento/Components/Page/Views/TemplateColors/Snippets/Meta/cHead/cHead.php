<?php
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Snippet composito. 'c' sta per composito.
 * Questo oggetto assembra pi snippet per configurarsi.
 */

class cHead extends Isp_View_Snippet{
	public $snippetType = "Meta";
	
	// Objects per la composizione
	public $meta = null;
	public $linkRel = null;
	
	
	public function __construct(Meta $meta=null, 
								LinkRel $linkRel=null){		

		// Memorizza lo stato
		$this->meta = $meta;
		$this->linkRel = $linkRel;
		
		parent::__contruct();
		
		//$this->run();
	}
	
	public function render(){
		
		$code = $this->openTag(null,null,"head");	// Open head
		if(isset($this->meta)){									// Meta
			$code .= $this->meta->code; 						
		}
		if(isset($this->linkRel)){								// Css
			$code .= $this->linkRel->code; 						
		}
		$code .= $this->closeTag("head");				// Close head
		return $code;
		
	}
	
}