<?php

/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * 	Contiene la scheda tecnica di un'entità
 *    
 * EXAMPLE CODE
	<h2>Modello di SCHEDA TECNICA</h2>
	<table  class="scheda_tecnica" summary="The value for summary is a brief summary of the table’s structure or purpose. No browser renders it on the page.">
	  <tr class="colored_row">
	    <th scope="row">Tipo:</th>
	    <td>Spiaggia</td>
	  </tr>
	  <tr>
	    <th scope="row">Nome:</th>
	    <td>Cocoloco</td>
	  </tr>
	  <tr class="colored_row">
	    <th scope="row">Stagione:</th>
	    <td>Estiva</td>
	  </tr>
	  <tr>
	    <th scope="row">Servizi:</th>
	    <td >
	    	<div class="cell_ul">
		    	<div class="cell_ul_left">
		        	<ul>
		            	<li>Banana surf</li>
		                <li>Noleggio per sport acquatici</li>
		             </ul>
		        </div>
	    	
		        <div class="cell_ul_right">
		        	<ul>
		            	<li> Ombrellone</li>
		                <li> Docce</li>
		            </ul>
		        </div>
	        </div>
	    </td>
	  </tr>
	  <tr class="colored_row">
	    <th scope="row">Info utili</th>
	    <td>Fermata autobus vicina</td>
	  </tr>
	</table>

*/


class SchedaTecnica extends Isp_View_Snippet{
	
	public $snippetType = "Card";
	
	/**
	 * Object state
	 */
	public $matrix         = array();
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classSchedaTecnica = "scheda_tecnica";
	public $classColoredRow    = "colored_row";
	

	/**
	 * Contructor
	 *
	 * 
	 */
	  public function __construct($matrixInterna){
	    
	    $this->setState("matrix", $matrixInterna);                          	

	  	parent::__contruct();
		
		// Render into father's code variable
		$this->run();                             	
	  }
	  
	  public function render(){
	  			
	  	if(!empty($this->matrix))
	  	{
	  		$code = $this->openTag(null, $this->classSchedaTecnica, "table");
	  		
	  		foreach ($this->matrix as $key => $riga)
	  		{	
	  			// Colora alternativamente la riga
	  			if($key % 2 == 0){ // If "pari" color
					$colored = $this->classColoredRow;
				}else{ 
					$colored = null;
				}
	  			$code .= $this->openTag(null, $colored, "tr");
		  			$code .= "<th scope=\"row\">";
		  			 	if ($riga[0] instanceof Isp_View_Snippet ){
		  			 		$this->appendCss($riga[0]->cssList);
		  					$code .= $riga[0]->code;
		  				}else{
		  					$code .= $riga[0];
		  				}
		  			$code .= "</th>";
	  				$code .= $this->openTag(null, null, "td");
	  					if ($riga[1] instanceof Isp_View_Snippet ){
	  						$this->appendCss($riga[1]->cssList);
		  					$code .= $riga[1]->code;
		  				}else{
		  					$code .= $riga[1];
		  				}
	  					 
		  			$code .= $this->closeTag("td");	  			
	 			$code .= $this->closeTag("tr");
	  		}
	  		
	  		$code .= $this->closeTag("table");
	  	}

	  	return $code;
	  }
	
	
}

?>