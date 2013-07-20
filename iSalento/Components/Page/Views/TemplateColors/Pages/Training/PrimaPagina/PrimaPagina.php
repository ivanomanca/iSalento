<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * This is the simplest page you can design.
 */
class PrimaPagina extends Isp_View_Page{
								
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
		Isp_Loader::loadVistaObj("Snippets","TrainingSnip","PrimoSnippet");
		// Instanzio lo snippet
		$snippet = new PrimoSnippet();
		// 
		$body['frase'] = $snippet->out();
		return $body;
		
	}
	
}
?>
