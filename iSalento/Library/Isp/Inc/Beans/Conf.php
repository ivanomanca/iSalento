<?php
//--------------------------------------------------------------
//	CONFIGURAZIONI ENTITA' PER IL BEANER
//--------------------------------------------------------------
class Conf{
// entit� che il beaner vede solo come Bean
public $OnlyBeanNTTS = array(/*"Articolo", "Fotovideo"*/);
public $SpecialBeanNTTS = array("Articolo", "Fotovideo");
// entit� che il beaner vede come SimpleObj (oggetti semplici indipendenti)
public $SimpleObjNTTS = array(	"Area",
											"Attivista",
											"Evento",
											"Feedback",
											"Localita",
											"Referente",
											//---------
											"Fotovideo",
											"Articolo",
											//---------
											"Servizio",
											"Struttura",
											"Spiaggia",
											"Tea",
											"Utente",
											"Spggventoideale",
											"Spggsuolo",
											"Spggfrequentazioni",
											"Spggsport");
// entit� semplici che il Beaner ricava tenendo conto della lingua
public $SimpleLangNTTS = array("Tfv");
// entit� semplici che il Beaner ricava come lista, tenendo conto di Lang
// nel codice del Beaner va fatta una miglioria per generalizzare
// quindi ci vuole un todo sull'uso di questo array nel Beaner
public $SimpleLangListNTTS = array("Tea");
// entit� che il Beaner vede come Beans
public $BeanNTTS = array(	"Articolo",
									"Attivista",
									"Evento",
									"Fotovideo",
									"Localita",
									"Struttura",
									"Spiaggia");
// entit� che il Beaner pu� ricavare nelle liste
public $ListedObjNTTS = array(	"Area",
											"Articolo",
											"Attivista",
											"Evento",
											"Feedback",
											"Fotovideo",
											"Localita",
											"Servizio",
											"Referente",
											"Struttura",
											"Spiaggia",
											"Utente",
											"Spggventoideale",
											"Spggsuolo",
											"Spggfrequentazioni",
											"Spggsport");
	public function __construct(){}
}
?>