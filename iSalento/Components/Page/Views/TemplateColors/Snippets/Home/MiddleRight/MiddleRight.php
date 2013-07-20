<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets", "Html", "Href");

/**
 * Parte centrale a destra con select località
 *	
 * EXAMPLE CODE:
 * 	  <div id="contenuto_middle_right">
 * 
          <form name=""action="">
            <label for="localita">Dove</label>
            <select name="" style="width:200px">
              <option label="" value="4">Gallipoli</option>
              <option label="" value="3">Lecce</option>
              <option label="" value="5">Ruffano</option>
            </select>
            
            <br/>
            <br/>
            
            <label for="nome_utente">Cosa</label>
            <select name="" style="width:200px">
              <option label="" value="4">discoteca</option>
              <option label="" value="3">hotel</option>
              <option label="" value="5">pub</option>
            </select>
            <br/>
            <br/>
            
            <button type="submit" class="green_button">Cerca!</button>
          </form>
          
          <ul>
            <li><a class="cmr_links" href="">Salento e localit√† ... </a>
            	<a class="frecce_blu_dx" href=""></a>
            </li>
            <li><a class="cmr_links" href="">Muoversi sul posto ... </a>
            	<a class="frecce_blu_dx" href=""></a><
            /li>
            <li><a class="cmr_links" href="">Come raggiungerci ... </a>
            	<a class="frecce_blu_dx" href=""></a></li>
          </ul>
          
        </div>
 */
 
class MiddleRight extends Isp_View_Snippet{
	public $snippetType = "Home";
	
	/**
	 * Object state
	 */
	public $directUrlArray = null; 
	public $selectSnpArray = null; 
	public $formActionUrl = null; 

	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idMiddleRight = 'contenuto_middle_right'; 
	public $styleSelect = 'width:200px'; 
	public $classFormButton = "green_button";
	public $classDirectLinks = 'cmr_links'; 
	public $classFrecceDx = 'frecce_blu_dx'; 
	
	/**
	 * Constructor
	 *
	 * @param array of Isp_Url $directUrlArray - link diretti
	 * @param array of Isp_View_Snippet $selectSnpArray - selects
	 * @param Isp_Url $formActionUrl - action button
	 */
	public function __construct($directUrlArray = null,
								$selectSnpArray = null,
								Isp_Url $formActionUrl = null){
		// Store into object state
		$this->setState("directUrlArray", $directUrlArray);
		$this->setState("selectSnpArray", $selectSnpArray);
		$this->setState("formActionUrl", $formActionUrl);

		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Div contenuto middle right
		$code = $this->openTag($this->idMiddleRight);
			// FORM
			// Open form
			$code .= "<form method=\"post\" action=\"".$this->formActionUrl->path."\">";
				// Selects
				foreach ($this->selectSnpArray as $select){
					if(isset($select)){
						$select->style = $this->styleSelect; // Inject style and re-render
						$select->run();
						$code .= $select->code;
					}
					$code .= "<br /><br />"; 
				}
				// Button				 
				$code .= "<button type=\"submit\" class=\"$this->classFormButton\">";
				$code .= $this->formActionUrl->title."</button>";
			// Close form
			$code .= "</form>";
			
			// DIRECT LINKS
            // Open ul
            $code .= $this->openTag(null, null, "ul");
            	// Li
            	foreach ($this->directUrlArray as $url){
            		$href1 = new Href($url, null, $this->classDirectLinks);
            		$url->title =  "";
            		$href2 = new Href($url, null, $this->classFrecceDx);
            		$code .= "<li>";
	            		$code .= $href1->code;
	            		$code .= $href2->code;
	            	$code .= "</li>";
            	}
            // Close ul
            $code .= $this->closeTag("ul");
        // Close first tag
        $code .= $this->closeTag();
			
		return $code;
	}	

}
?>