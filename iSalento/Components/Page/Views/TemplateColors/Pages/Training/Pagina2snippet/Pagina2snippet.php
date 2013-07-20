<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * This is the simplest page you can design.
 */
class Pagina2snippet extends Isp_View_Page{
								
	/*
	// Struttura Pagina: semplice frase
	public function skeleton(){
		$body['frase'] = "La mia prima frase!";
		$body['z'] = "<br>seconda linea!";
		return $body;
	}
	*/
	
	
	// Uso degli snippet
	public function skeleton(){
	
		
		
		// Carico lo snippet
		Isp_Loader::loadVistaObj("Snippets","TrainingSnip","NomeNumeroArticolo");
		// Instanzio lo snippet
		$snippet = new NomeNumeroArticolo("art. 100", "Mezzapunta");
		 
		$body['articolo1'] = $snippet->out();
		
		
		// Carico lo snippet
		Isp_Loader::loadVistaObj("Snippets","TrainingSnip","NomeNumeroArticolo");
		// Instanzio lo snippet
		$snippet = new NomeNumeroArticolo("art. 100", "Mezzapunta");
		 
		$body['articolo2'] = $snippet->out();
		
		
		
		return $body;
		
	}
	
}
?>
