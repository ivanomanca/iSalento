<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * Lista Localita
 *
 */
class ListaUtente extends Isp_View_Page{
	public $currentTab = 5;
	public $privilegioMin = Permission::REGISTERED;

	// Head info
	public $titleMeta = "";
	public $keywordsMeta = "";
	public $descriptionMeta = "";

	// Object state
	public $comingPageInfo = array(); // for scheda to retrieve father list

	// Dictionary
	public $dictionary = array(
			"it" =>
			 array( "titlePage" => "Utenti iscritti",
						"descriptionPage" =>"versione alpha di iSalento",
						"readAll" => "",
						"readAllDescription" => ""));

	// Dynamic data
	public $listaUtente = null;

	public function getIngredients(){
		$ingredients['listaUtente'] = array("A7Utente");
		return $ingredients;
	}

	public function skeleton(){

		// TITLE DESCRIPTION
		Isp_Loader::loadVistaObj("Snippets","PageElements","TitleDescription");
		$this->add( new TitleDescription(	$this->txt['titlePage'],
											$this->txt['descriptionPage']));

		$this->add('<table cellspacing="15">');
		$this->add('<tr>');
		$this->add(	"<td><b>	Username	</b></td>".
						"<td><b>	Email	</b></td>".
						"<td><b>	Email confirm	</b></td>".
						"<td><b>	Status	</b></td>".
						"<td><b>	Modify	</b></td>"
						);
		foreach ($this->listaUtente as $utente) {
			$this->add('</tr>');
			if($utente->privilegi_utente > $this->privilegi){
				if($utente->emailconfirmed_utente == 1){$ec = "ok";}else{$ec = "-";}
				$this->add('<tr>');
				$this->add(	"<td>".$utente->username_utente."</td>".
								"<td>".$utente->email_utente."</td>".
								"<td>".$ec."</td>".
								"<td>".$utente->stato_utente."</td>".
								"<td>");

				// Link to change status
				Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
				if($utente->stato_utente == 'richiesta'){
					$this->add(new Href(new Isp_Url(
						'index.php?component=Authenticate&task=activeUser&'.
						'email='.$utente->email_utente,
						"ACCEPT")));
				}else if(($utente->stato_utente == 'attivo')){
					$this->add(new Href(new Isp_Url(
						'index.php?component=Authenticate&task=disactiveUser&'.
						'email='.$utente->email_utente,
						"DISABLE")));
				}else if(($utente->stato_utente == 'disattivo')){
					$this->add(new Href(new Isp_Url(
						'index.php?component=Authenticate&task=activeUser&'.
						'email='.$utente->email_utente,
						"REACTIVE")));}

				$this->add("</td>");
				$this->add('</tr>');
			}
		}
		$this->add('</table>');

		// link al pannello precedente
		$this->add("<br/>");
		$this->add("<br/>");
		Isp_Loader::loadVistaObj("Snippets", "Html", "Href");
		$this->add(new Href(new Isp_Url_Page(	'Torna al pannello',
															'Filtro',
															'FiltroInserisci')));

		// RUN IN TEMPLATE
		return $this->useDefaultTemplate();
	}
}

?>
