<?
Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina inserimento servizio
 *
 */
class InsertServizio extends Isp_View_Page{
	public $privilegioMin = Permission::REGISTERED;
	public $currentTab = 6;

	public $urlForm = null; // Isp_Url object

	// Dati dinamici related
	public $listaCategoria = null;
	public $listaServizio = null;

	// Dictionary
	public $dictionary = array(
				"it" =>
				array( "titlePage" => "Inserisci servizio",
						"descriptionPage" =>"versione alpha di iSalento",
						"nome" => "Nome : ",
						"descrizione" => "Descrizione : ",
						"serviziInseriti" => "Servizi inseriti",
						"salva" => "Inserisci",
						"categoria" => "Categoria : "
						),
				"en" =>
				array( "titlePage" => "Insert Service",
						"descriptionPage" =>"versione alpha di iSalento")
								);
	/**
	 * Lista di ingredienti diretti (che non dipendono da altri beans).
	 * Convenzione: l'array ingredients contiene i campi di retrieve del beaner,
	 * oppure i campi di ingresso del SimpleEnquirer.
	 * Nel secondo caso la chiave di $ingredients inizia per '*'. :D
	 * Se si vogliono prendere i dati dalla request basta specificare il nome
	 * dell'array nella request come stringa (es. 'userParams').
	 * La chiave dell'array ingredients  = al nome dell'oggetto istanziato
	 *
	 * @return l'array di ingredienti da processare nell'action ctrl
	 */
	public function getIngredients(){
		// Oggetto
		$ingredients['listaServizio'] = array( "A7Servizio",
												array("order_cre" => "id_categoria"));

		// For categoria select
		$ingredients['*listaCategoria'] = array("categoria",
													array("nome_categoria" => "ASC"));

		return $ingredients;
	}

	/**
	 * !CONVENTION: No html o parole o cose statiche!!
	 * Tutto nello stato dell'oggetto.
	 *
	 * @return unknown
	 */
	public function skeleton(){
		// Imports
		Isp_Loader::loadVistaObj("Snippets", "Html", "Select");
		Isp_Loader::loadVistaObj("Snippets", "Form", "Input","Crud");

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['titlePage']));

		// Prepare options for "lista tipostruttura" select
		$optionsCat = array();
		foreach ($this->listaCategoria as $obj) {
			// Delete "description" category reserved only for home page cards
			if($obj['id_categoria'] != 0){
				array_push($optionsCat, array(	false,
											"",
											$obj['id_categoria'],
											ucfirst($obj['nome_categoria'])));
			}
		}
		// Open form
	 	$this->add( "<form method=\"post\" action=".$this->urlForm->path.">");
	 	// Select categoria
		$this->add($this->txt['categoria']);
		$this->add(new Select("id_categoria", $optionsCat));
		$this->add("<br />");

	 	// Nome servizio
	 	$this->add(new Input("text", $this->txt['nome'], "nome_servizio", false, null, 50));
	 	$this->add( "<br />");
	 	// Descrizione servizio
	 	$this->add(new Input(	"text", $this->txt['descrizione'],
	 							"descrizione_servizio", false, null, 50));
	 	$this->add( "<br />");
		// Submit
		$this->add( "<br />");
		$this->add(new Input("submit", null, "nuddu", false, $this->txt['salva']));
		// Close form
		$this->add(	"</form>");

		// Servizi inseriti
		$this->add("<h2>".$this->txt['serviziInseriti']."</h2>");
		$currentCategory = null;
		foreach ($this->listaServizio as $servizio){
			// Mostra la label categoria
			if($servizio->nome_categoria != $currentCategory){
				$currentCategory = $servizio->nome_categoria;
				$this->add("<b><br />".ucfirst($currentCategory)."</b> <br />");
			}
			$this->add(ucfirst($servizio->nome_servizio));
			$this->add("<br />");
		}

		return $this->useDefaultTemplate();
	}



}
?>
