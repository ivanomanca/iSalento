<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista entitˆ messe in anteprima nelle news
 *
 */
class ListaSpeciale extends Isp_View_Page{
	public $currentTab = 0;
	
    // Head info
	public $titleMeta = "Lista Speciale, iSalento - alpha version";
	public $keywordsMeta = "iSalento, Salento, spiagge, mare";
	public $descriptionMeta = "iSalento, versione alpha..mare, spiagge nel Salento";
	
	// Dictionary
	public $dictionary = array( 
			"it" => 
			 array( "titlePage" => "In primo piano",
					"descriptionPage" =>"versione alpha di iSalento",
					"readAll" => "Leggi tutto..",
					"readAllDescription" => "Approfondisci"));
	
	// Object state
	public $urlMatrix = array(); // foto and page array
	public $ombraFotoPx = 100; // Int px della foto
	
	public function skeleton(){
		
		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'], 
											$this->txt['descriptionPage']));
											
		// LISTA
		
		
		$listArray = array();
		foreach ($this->urlMatrix as $urls){

			
		
		// DESCRIZIONE
		$abstract = $urls[2];
		
		// LINK LEGGI TUTTO
		$readAllUrl = new Isp_Url(	$urls[0]->path, 
									$this->txt['readAll'] , 
									$this->txt['readAllDescription']." ".
									$urls[0]->title);
		// *** SNIPPETS *** //
		// Single box
		Isp_Loader::loadVistaObj("Snippets","PageElements","PicTitleAbstract");
		$inBoxItems = new PicTitleAbstract($urls[1], 
											$urls[0], 
											$abstract, 
											$readAllUrl,
											$this->ombraFotoPx);
		Isp_Loader::loadVistaObj("Snippets","List","Separator");
		$listSep = new Separator();
		
			
		// Elemento di lista	
		Isp_Loader::loadVistaObj("Snippets","List","cListItem");					
		$listItem = new cListItem($listSep, $inBoxItems, true);
		array_push($listArray, $listItem);
		
		}
		// List case
		Isp_Loader::loadVistaObj("Snippets","List","cList");
		$this->add( new cList($listArray));
	
		
		
		
		// RUN IN TEMPLATE		
		return $this->useDefaultTemplate();
		
	}
}

?>
