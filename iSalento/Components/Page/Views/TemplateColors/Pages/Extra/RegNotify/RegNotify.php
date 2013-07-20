<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Pagina delle notifiche in merito alla registrazione di un account
 *
 */
class RegNotify extends Isp_View_Page{
	// Pagina appartenente alla macrosezione n¡ 4
	public $currentTab = 5;

	// Dizionario
	public $dictionary = array(
								"it" => array( "title" => "COMUNICAZIONE DALLO STAFF",
											   "description" =>"",
											   "regCompleted" => "La tua richiesta di registrazione e' stata inoltrata!<br/>A breve ti verra' comunicata l'avvenuta attivazione del tuo username.<br/><br/>IMPORTANTE: non dimenticare la tua password perche' e' stata criptata nel nostro database e non abbiamo la possibilita' di estrarla. Qualora la dimenticassi hai la possibilita' di richiederne una nuova che sara' attivata con lo stesso procedimento di questo account. Grazie. :)"),

								"en" => array(	"title" => "Staff communication",
													"description" => "")
								);

	// Page structure
	public function skeleton(){

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add(new TitleDescription($this->txt['title'], $this->txt['description']));

		// Errors
		if (isset($this->errorMsg) && !is_null($this->errorMsg)) {
			$i = 0;
			foreach ($this->errorMsg as $errorString){
			$i++;
			$this->add($i.") ".$errorString);
			}
		}else{
			// Notifica di avvenuta registrazione.
			$this->add($this->txt['regCompleted']);

		}
		// RUN IN TEMPLATE
		return $this->useDefaultTemplate();

	}
}
?>
