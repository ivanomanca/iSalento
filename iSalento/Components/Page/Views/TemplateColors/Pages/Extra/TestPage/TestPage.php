<?
/*
echo "<pre>";
print_r($this->oStruttura);
echo "</pre>";
*/	

/**
 * 'o'= oggetto; 'ao'= array oggetti
 * 'b'= bean; 's' = static
 */

Isp_Loader::loadClass('Isp_View_Page');

/**
 * Pagina test
 *
 */
class TestPage extends Isp_View_Page{
	
	
	// Dati dinamici risolti dal ctrl
	public $oStruttura = null;
	// Dati dinamici related
	public $bLocalita = null;
	
	/**
	 * Static CNT
	 */
	public $sTitolo = "<h1>Titulu</h1>";
	public $sSottoTitolo = "Benvenuti nella home page";
	
	
	/**
	 * Lista di ingredienti diretti (che non dipendono da altri beans).
	 * Convenzione: l'array ingredients contiene i campi di retrieve del beaner.
	 * Se si vogliono prendere i dati dalla request basta specificare il nome 
	 * dell'array nella request come stringa (es. 'userParams').
	 * La chiave dell'array ingredients  = al nome dell'oggetto istanziato
	 *
	 * @return l'array di ingredienti da processare nell'action ctrl
	 */
	public function getIngredients(){
		
		$ingredients['oStruttura'] = array("Struttura", array("id_struttura" => 16));
		//$ingredients['oStruttura'] = array("Struttura", "userParams");
		
		return $ingredients;
	}
	
	/**
	 * Lista richieste che dipendono da altri beans. (Secondo ciclo iterativo
	 * di retrieve beans). Se i cicli iterativi sono molti si dovrebbe impostare 
	 * un loop anzich aggiungere molte funzioni.
	 */
	public function getRelatedIngredients(){
		$related = null;
		
		if(isset($this->oStruttura->id_localita)){
			$idLoc = array($this->oStruttura->id_localita);
			$related['bLocalita'] = array("B7Localita", $idLoc);
		}
		
		return $related;
	}
	
	/**
	 * Snippets da includere
	 */
	public function includeSnippets(){
		Isp_Loader::loadVistaObj("Snippets","Meta","Doctype");
		//isp_loader::loadVistaObj("snippets","meta","eccetera");							
	}
	/**
	 * !CONVENTION: No html o parole o cose statiche!!
	 * Tutto nello stato dell'oggetto.
	 *
	 * @return unknown
	 */
	public function skeleton(){
		// HEAD
	 	$doctype = new Doctype();
	 	/*$meta = new Meta($this->oStruttura->nome_struttura);
	 	$linkRel = new LinkRel(new isp_url("/css/folder"));*/
	 	
		$body['head'] = "Siamo nello skeletro amici, ah-ah..<br>";
		
		// PERNACCHIA
		$body['pernacchia'] = $doctype->out();
		// TITOLO
		$body['titolo'] = $this->sTitolo;
		// LOCALITA'
		if(isset($this->bLocalita) && isset($this->bLocalita->Localita->nome_localita)){
			$locNome = $this->bLocalita->Localita->nome_localita;
			$body['localita'] = "Si trova nella localita' di: ".$locNome;
		}
		
		return $body;
	}
	
	
	
}
?>
