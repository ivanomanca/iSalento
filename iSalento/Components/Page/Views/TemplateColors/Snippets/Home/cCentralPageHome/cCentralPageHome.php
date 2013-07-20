<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Navigation","cSideNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");

/**
 * EXAMPLE CODE:
 *  <div id="pagina_centrale_home"> 
   	 	<div id="contenuto_home">
     		 <div id="contenuto_top">
     			<div id="contenuto_top_left"> $snp
     			<div id="contenuto_top_right"> $snp
     		 <div id="contenuto_middle">
      			  <div id="contenuto_middle_left"> $snp
      		 	  <div id="contenuto_middle_right"> $snp
      		 <div id="contenuto_bottom">
       			  <div id="contenuto_bottom_left"> $snp
       			  <div id="contenuto_bottom_right"> $snp
       			  <div id="contenuto_bottom_middle"> $snp
       	</div>
       	LineNav $footer
     </div>		  
       	
 * 
 * 
 */

/**
 * Wrapper for Central Page for HomePage. 
 */
class cCentralPageHome extends Isp_View_Snippet{
	public $snippetType = "Home";
	
	public $cntTopArray = null;
	public $cntMiddleArray = null;
	public $cntBottomArray = null;
	public $footer = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idCentralPageHome = "pagina_centrale_home";
	public $idContent = "contenuto_home";
	// Top 
	public $idCntTop = "contenuto_top";
	public $idTopLeft = "contenuto_top_left";
	public $idTopRight = "contenuto_top_right";
	// Middle
	public $idCntMiddle = "contenuto_middle";
	public $idMiddleLeft = "contenuto_middle_left";
	public $idMiddleRight = "contenuto_middle_right";
	// Bottom
	public $idCntBottom = "contenuto_bottom";
	public $idBottomLeft = "contenuto_bottom_left";
	public $idBottomMiddle = "contenuto_bottom_middle";
	public $idBottomRight  = "contenuto_bottom_right";
	
	/**
	 * Constructor
	 *
	 * @param array $cntTopArray - array(leftSnippet, rightSnippet)
	 * @param array $cntMiddleArray - array(leftSnippet, rightSnippet)
	 * @param array $cntBottomArray - array(leftSnippet, middleSnippet, rightSnippet)
	 * @param LineNav $footer
	 */
	public function __construct($cntTopArray = null,
								$cntMiddleArray = null,
								$cntBottomArray = null,
								LineNav $footer = null){

		// Store into the object state
		$this->setState("cntTopArray",$cntTopArray);
		$this->setState("cntMiddleArray",$cntMiddleArray);
		$this->setState("cntBottomArray",$cntBottomArray);
		$this->setState("footer",$footer);
		
		parent::__contruct();
		
		// Render
		$this->run();
	}

	public function render(){

		// Div Central Page
		$code = $this->openTag($this->idCentralPageHome);
			// Open content div
			$code .= $this->openTag($this->idContent);
				// CNT TOP
				if(isset($this->cntTopArray)){
					$code .= $this->openTag($this->idCntTop);
						// Top left
						$code .= $this->openTag($this->idTopLeft);
							$code .= $this->cntTopArray[0]->code;
						$code .= $this->closeTag();
						// Top right
						$code .= $this->openTag($this->idTopRight);
							if(isset($this->cntTopArray[1]->code))
							$code .= $this->cntTopArray[1]->code;
						$code .= $this->closeTag();
					$code .= $this->closeTag();	
				}
				
				// CNT MIDDLE
				if(isset($this->cntMiddleArray)){
					$code .= $this->openTag($this->idCntMiddle);
						// Middle left
						//$code .= $this->openTag($this->idMiddleLeft);
							$code .= $this->cntMiddleArray[0]->code;
						//$code .= $this->closeTag();
						// Middle right
					//	$code .= $this->openTag($this->idMiddleRight);
							$code .= $this->cntMiddleArray[1]->code;
					//	$code .= $this->closeTag();
					$code .= $this->closeTag();	
				}
				
				// CNT BOTTOM
				if(isset($this->cntBottomArray)){
					$code .= $this->openTag($this->idCntBottom);
						// Bottom left
						$code .= $this->openTag($this->idBottomLeft);
							$code .= $this->cntBottomArray[0]->code;
						$code .= $this->closeTag();
						// Bottom middle
						$code .= $this->openTag($this->idBottomRight);
							$code .= $this->cntBottomArray[2]->code;
						$code .= $this->closeTag();
						// Bottom right
						$code .= $this->openTag($this->idBottomMiddle);
							$code .= $this->cntBottomArray[1]->code;
						$code .= $this->closeTag();
					$code .= $this->closeTag();	
				}
				// Close content div
				$code .= $this->closeTag();
				
				// Footer in line navigation
				if(isset($this->footer)){
					$code .= $this->footer->code;
				}
			
		// Close central page 
		$code .= $this->closeTag();
		return $code;
	}
	
}
?>