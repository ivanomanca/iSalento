<?php

/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

class ElencoPuntatoTabella extends Isp_View_Snippet{
	
	public $snippetType = "Card";
	
	/**
	 * Object state
	 */
	public $value = array();
	public $numColumn; //numero di colonne in cui si vuole dividere l'elenco
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classCellUl        = "cell_ul";
	public $classCellUlRight   = "cell_ul_right";
	public $classCellUlLeft    = "cell_ul_left";
	
	/**
	 * Contructor
	 *
	 * 
	 */
	  public function __construct($valori, $colonne){
	    
	    $this->setState("value", $valori);                          	
		
	    // se non  settato o erroneamente  un valore nullo 
	    // lo setto con il valore di default = 1
	    if(!isset($colonne) || $colonne == 0)
	    {
	    	$this->numColumn = 1;	
	    }
	    else
	    	$this->setState("numColumn", $colonne);
	    
	  	parent::__contruct();
		
		// Render into father's code variable
		$this->run();                             	
	  }
	  
	  public function render(){
	  			
	  	if(!empty($this->value))
	  	{	
	  		$code = $this->openTag(null, $this->classCellUl, "div");
	  		
			
				//divido il numero di elementi dell'array con il numero di colonne desiderato
				switch ($this->numColumn)
				{
					case 1: //una colonna: li stampo tutti sul lato sinistro
						$code .= $this->openTag(null, $this->classCellUlLeft, "div");
							$code .= $this->openTag(null, null, "ul");	
								//stampo tutti i valori come elenco puntato		
								foreach ($this->value as $item) 
								{
									$code .= $this->openTag(null, null, "li");
									$code .= $item;
									$code .= $this->closeTag(li);
								}
							$code .= $this->closeTag("ul");
						$code .= $this->closeTag("div");
						break;
					default: //in tutti gli altri casi
						
						$code .= $this->openTag(null, $this->classCellUlLeft, "div");
							$code .= $this->openTag(null, null, "ul");
								//stampo la colonna sinistra
								for($i=0; $i<((count($this->value)) / ($this->numColumn)); $i++)
								{
									$code .= $this->openTag(null, null, "li");
										$code .= $this->value[$i];
									$code .= $this->closeTag("li");
								}
							$code .= $this->closeTag("ul");
						$code .= $this->closeTag("div");
						
						$code .= $this->openTag(null,$this->classCellUlRight, "div");
							$code .= $this->openTag(null, null, "ul");
								//stampo la colonna destra
								for($j=$i; $j<(count($this->value)); $j++)
								{
									
									$code .= $this->openTag(null, null, "li");
										$code .= $this->value[$j];
									$code .= $this->closeTag("li");
								}
							$code .= $this->closeTag("ul");
						$code .= $this->closeTag("div");
						break;
				}
															 
			$code .= $this->closeTag("div");
	  	}

	  	return $code;
	  }
	
	
}

?>