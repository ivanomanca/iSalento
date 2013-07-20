<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * This is the simplest page you can design.
 */
class Pagina2snippetDizionario extends Isp_View_Page{
	//Pagina appartenente alla macrosezione n°2
	public $currentTab = 2; 
	
	// Head info - i meta contenuti
	public $titleMeta = "Scheda iSalento - alpha version";
	public $keywordsMeta = "iSalento, salento, spiagge, mare, vacanze";
	public $descriptionMeta = "Pagina di training su come creare e gestire snippet e pagine";
	
	//DIZIONARIO
	public $dictionary = array(
								"it" => array( "title" => "Pagina 2 snippet con Dizionario",
												"description" => "Pagina di training usando lo snippet TitleDescription e NomeNumeroArticolo inseriti all'interno del template e usando il dizionario",
												"frase" =>  "frase generica"),
												
								"en" => array( "title" => "Title",
												"description" => "A test page...")
	
								);
	
	
								
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
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		// Instanzio lo snippet
		$this->add(new TitleDescription($this->txt['title'], $this->txt['description']));
		// 
		
		//Stampa una stringa
		$this->add($this->txt['frase']);
		
		
		// Carico lo snippet
		Isp_Loader::loadVistaObj("Snippets","TrainingSnip","NomeNumeroArticolo");
		// Instanzio lo snippet
		$this->add(new NomeNumeroArticolo("art. 100", "Mezzapunta"));
		// 
		
		
		return $this->useDefaultTemplate();
		
		/*return $body;*/
		
	}
	
}
?>
