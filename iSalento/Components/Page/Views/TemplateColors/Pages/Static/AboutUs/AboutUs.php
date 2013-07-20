<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * This is the simplest page you can design.
 */
class AboutUs extends Isp_View_Page{
	//Pagina appartenente alla macrosezione n°1
	public $currentTab = 5; 
	
	// Head info - i meta contenuti
	public $titleMeta = "Scheda iSalento - alpha version";
	public $keywordsMeta = "iSalento, salento, spiagge, mare, vacanze,";
	public $descriptionMeta = "Pagina chi siamo";
	
	//DIZIONARIO
	public $dictionary = array(
								"it" => array( "title" => "Chi Siamo",
												),
												
								"en" => array( "title" => "Title",
												)
	
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
	
		$this->add("<h1>Chi Siamo</h1>");
		$this->add("<p>\"...sono quasi le tre e mezza di notte e sono seduto per strada appoggiato ad un albero.
Vi scrivo sull' email personale perchè è di persona che voglio parlarvi. Personalmente sono ad un bivio: ci metto l'anima o lascio perdere tutto (lasciandomi comunque alle spalle un'esperienza di cui ne vado fiero)?
Ciò che conta, comunque, è che dopo questa email per me non esisteranno più vie di mezzo (o walking deads)!</p>

<p>Potrò sembrare un pazzo squilibrato, ma in questo periodo della mia vita voglio fare, creare e realizzare puntando in alto!
Sono sempre più carico e motivato, vedo alto potenziale in molte idee, le vedo già funzionanti ed usate world wide, le vedo in grande.</p>

<p>Ogni giorno, qui in America, conosco dei ragazzi che credono fino alla morte nelle loro idee, si chiudono in un garage, si ammazzano e alla fine diventano i fondatori dei loro sogni. Ce ne sono molti, ovunque. Ieri ne ho incontrato un altro, si chiama Zuckenberg ed ha creato Facebook a 19 anni. Sono speciali? Più bravi? Hanno semplicemente uno stato mentale diverso. Semplicemente credono che le cose possono accadere, e accadono.
Ed io, in questa filosofia ne ero immerso fino al collo già prima di venire qui (o forse è per questo che son finito qui).
C'è un solo segreto dietro a tutto questo: la passione e la voglia di credere in un'idea e \"farla\", punto.</p>

<p>Ho amato iSalento perchè per me è stato la forza e la dimostrazione per tanti altri che le cose si possono cambiare, anche in un posto dove tutto sembra represso e la gente è rassegnata a credere che non si può uscire da un binario su cui tutti girano. Ho un sogno: creare qualcosa di utile che cambi e migliori le cose nella terra in cui sono nato.
Vorrei vivere con la soddisfazione di sentirmi dire un giorno \"grazie per averlo fatto\".</p>

<p>Ragazzi, non so voi, ma io voglio \"fare\" qualcosa. Sono molto motivato e voglio lavorare per arrivare in alto solo con gente che ci crede veramente e disposta come me a metterci l'anima. Molti di noi, o forse tutti, potrebbero avere qualcos'altro di più interessante o prioritario; o semplicemente sono convinti che non si possa uscire da quel binario su cui tutti girano. iSalento, o qualsiasi altra idea simile, non potrebbe mai funzionare in questa situazione e sarebbe uno spreco di tempo per tutti. Questa e-mail non vuole \"forzare\" qualcuno a stare dentro ne tantomeno \"cacciare\" chi ci ha creduto di meno, semplicemente sentitevi liberi di fare la scelta senza problemi o vincoli di nessun tipo basandovi su queste nuove considerazioni. iSalento come \"walking dead\" muore con questa e-mail. Decidere di continuare, rispetto che a fermarsi, richiede un impegno maggiore, vuol dire prendersi la merda in faccia nelle situazioni critiche senza scappare via e godersi tutta la ricompensa nel successo. Vuol dire essere \"fondatore\", non \"dipendente\".</p>

<p>iSalento è diventato adesso un treno che sta passando, da prendere o lasciare!
Se siete interessati al treno chiamatemi entro questa settimana max.
Per chi non è interessato questa è l'ultima email di iSalento (amici come prima!)</p>

<p>Se siete qui e avete letto questa mail, significa che queste parole hanno avuto un senso per tutti. Che questa mail non è stata la fine di qualcosa ma il primo passo per arrivare qui e chissà dove ancora.
Chi siamo? Siamo tutto ciò che avete letto: passione, rabbia, voglia di emergere, ambizione, voglia di fare e assoluta demoralizzazione in alcuni momenti. Avremmo potuto lasciare tutto alle spalle e rimanere amici, sarebbe stata la scelta più facile per tutti. Invece siamo qui tutti più motivati di prima e la walking dead è diventata la nostra start line.</p>\"

iSalento team.
");
		
		
		
		
	return $this->useDefaultTemplate(true,true);
		
		
	}
	
}
?>
