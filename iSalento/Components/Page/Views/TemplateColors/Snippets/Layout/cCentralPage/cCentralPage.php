<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Navigation","cSideNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");

/**
 * EXAMPLE CODE:
 * <div id="pagina_centrale">
 * 		$sideNav (left)
 * 		$sideNav (extra)
 * 		<div id="pagina_centrale_senza_navigazioni" class="sxNav, dxNav">
 * 			$breadcrumb (in line navigation)
 * 			<div id="contenuto">
 * 				$content snippets
 * 			</div>
 * 		</div>
 * 		$footer (in line navigation)
 * 	</div>
 */

/**
 * Wrapper for Central Page. 
 */
class cCentralPage extends Isp_View_Snippet{
	public $snippetType = "Layout";
	
	public $content = null;
	public $leftNav = null;
	public $extraNav = null;
	public $breadCrumb = null;
	public $footer = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idCentralPage = "pagina_centrale";
	public $idCentralPageNoNav = "pagina_centrale_senza_navigazioni";
	public $idContent = "contenuto";
	public $classSxNav = "sxNav";
	public $classDxNav = "dxNav";
	
	/**
	 * Constructor
	 *
	 * @param string|Isp_View_Snippet $content - Content to print
	 * @param cSideNav $leftNav - left navigation
	 * @param cSideNav $extraNav
	 * @param LineNav $breadCrumb
	 * @param LineNav $footer
	 */
	public function __construct($content = null,
								cSideNav $leftNav = null,
								cSideNav $extraNav = null,
								LineNav $breadCrumb = null,
								LineNav $footer = null){

		// Store into the object state
		$this->setState("content",$content);
		$this->setState("leftNav",$leftNav);
		$this->setState("extraNav",$extraNav);
		$this->setState("breadCrumb",$breadCrumb);
		$this->setState("footer",$footer);
		
		parent::__contruct();
		
		// Render
		$this->run();
	}

	public function render(){

		// Div Central Page
		$code = $this->openTag($this->idCentralPage);
			
			$classSideNav = null; // Markup for sideNav margins
			// Left Side Navigation
			if(isset($this->leftNav)){
				$code .= $this->leftNav->code;
				$classSideNav .= $this->classSxNav;
			}	
			// Extra Side Navigation
			if(isset($this->extraNav)){
				$code .= $this->extraNav->code;
				$classSideNav .= " , ".$this->classDxNav;
			}
			// Open central page without side navigation bars
			$code .= $this->openTag($this->idCentralPageNoNav, $classSideNav);
				// Breadcrumb in line navigation
				if(isset($this->breadCrumb)){
					$code .= $this->breadCrumb->code;
				}
				// Div content
				$code .= $this->openTag($this->idContent);
				if(isset($this->content)){
					// If content is a normal html string
					if(is_string($this->content)){
						$code .= $this->content;
					// If snippet	
					}elseif($this->content instanceof Isp_View_Snippet){ 
						$code .= $this->content->code;
					// Array di snippets e codice html in stringa misto
					}elseif(	is_array($this->content) ){
						foreach ($this->content as $element){
							if($element instanceof Isp_View_Snippet){
								$code .= $element->code;
							}else{
								$code .= $element;
							}
						}	
					}/*elseif(	is_array($this->content) && 
								reset($this->content) instanceof Isp_View_Snippet){
						foreach ($this->content as $snippet){
							$code .= $snippet->code;
						}
					}*/
				}
				// Close content
				$code .= $this->closeTag();
			// Close central page without side navigation bars
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