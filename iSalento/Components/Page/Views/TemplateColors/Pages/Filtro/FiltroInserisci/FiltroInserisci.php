<?
Isp_Loader::loadClass('Isp_View_Page');
Isp_Loader::loadVistaObj("Pages","Filtro","Filtro");
/**
 * Filtro Inserisci
 *
 */
class FiltroInserisci extends Filtro{
	public $privilegioMin = Permission::REGISTERED;
	public  $currentTab = 6;

	// Static txt
	public $dictionary = array(
			"it" =>
			 array(	"titlePage" => "PANNELLO DI INSERIMENTO",
						"descriptionPage" =>"iSalento - Alpha version",
						"blockTitle" => "INSERISCI",
						"readAll" => "Leggi tutto..",
						// primo blocco
						"1blockTitle" => "Gestione profilo",
						"PWChange" => "Cambia password",
						// secondo blocco
						"2blockTitle" => "Gestione utenti",
						"EnableUser" => "Accettazione",
						//terzo blocco
						"3blockTitle" => "Gestione spiaggia",
						"InsertSpiaggia" => "Inserimento Spiaggia")
			);


	public function skeleton(){
		$this->useDefaultFiltro();

		// secondo blocco cambio password per utenti loggati
		if(isset($_SESSION['user'])){
		Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
		Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
		$this->add(new cCaseBlock(	$this->txt['1blockTitle'],
									null,
									new Href(new Isp_Url_Page(	$this->txt['PWChange'],
																		"Form",
																		"FormChPW")),
									$this->_urls->colors[$this->currentTab]));
		}

		// terzo blocco (ora solo per ADMIN)
		if($this->privilegi <= Permission::ADMIN){
		Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
		Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
		$this->add(new cCaseBlock(	$this->txt['2blockTitle'],
									null,
									new Href(new Isp_Url_Page(	$this->txt['EnableUser'],
																		"Lista",
																		"ListaUtente")),
									$this->_urls->colors[$this->currentTab]));
		}

		// quarto blocco (ora solo per Staff)
		if($this->privilegi <= Permission::STAFF){
		Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
		Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
		$this->add(new cCaseBlock(	$this->txt['3blockTitle'],
									null,
									new Href(new Isp_Url_Page($this->txt['InsertSpiaggia'],
																		"Form",
																		"InsertSpiaggia")),
									$this->_urls->colors[$this->currentTab]));
		}

    	return $this->useDefaultTemplate();
	}
}

?>
