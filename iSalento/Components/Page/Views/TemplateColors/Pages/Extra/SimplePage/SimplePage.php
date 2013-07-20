<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * This is the simplest page you can design.
 *
 */
class SimplePage extends Isp_View_Page{
	// Pagina appartenente alla macrosezione n¡ 2
	public $currentTab = 2;
	
	// Dizionario
	public $dictionary = array( 
								"it" => array( "title" => "Titolo",
											   "description" =>"Una pagina di test..",
											   "frase" => "frase generica"),
					
								"en" => array(	"title" => "Title",
												"description" => "A test page..")		
								);
	
	/*
	// Dynamic data
	public $beanStruttura;
	public $beanLocalita; // Related to Struttura
								
	public function getIngredients(){
		
		$ingredients['beanStruttura'] = array("B7Struttura", "userParams");		
		return $ingredients;
	}
	
	
	public function getRelatedIngredients(){
		
		if(isset($this->beanStruttura->Struttura->id_localita)){
			$related['beanLocalita'] = array("B7Localita", $this->beanStruttura->Struttura->id_localita);
		}
		
		return $related;
	}
	*/
								
	// Page structure
	public function skeleton(){
		
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['title'], $this->txt['description']));
		
		// Stampa una stringa
		$this->add($this->txt['frase']);
		
		// RUN IN TEMPLATE
		return $this->useDefaultTemplate();
		
	}
}
?>
