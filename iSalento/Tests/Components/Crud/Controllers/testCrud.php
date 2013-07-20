<?php
/**
 * Parametri di simulazione link per test
 */

/**
 * 1. INSERIMENTO SPIAGGIA + MM
 *
$_POST = array(	// routing params
						"component" => 'Crud',
						"task" => 'insert',
						"crudNtt" => 'Spiaggia',

						// Spiaggia
						"id_struttura" => 107,
						"lunghezza_spiaggia" => 22,
						"ingresso_spiaggia" => "free",
						// MM
						"id_spggsuolo" => array(1, 2),
						"id_spggventoideale" => array("N", "NE"),
						"id_spggfrequentazioni" => array(1),
						"id_spggsport" => array(1, 2)
);
*/

/**
 * INSERIMENTO STRUTTURA+SPIAGGIA+MM
 *
$_POST = array (	// routing params
						"component" => 'Crud',
						"task" => 'insert',
						"crudNtt" => 'Struttura**Spiaggia',

						// Struttura params
						"nome_struttura" => "Le monache",
						"giorno_notte_struttura" => "notte",
						"indirizzo_zona_struttura" => "via aradeo",
						//"google_map_struttura" => "gmaplemonache",
						"estivo_invernale_struttura" => "estivo",
						"sito_struttura" => "www.lemonache.com",
						"giorni_apertura_struttura" => "martedichiuso",
						"orari_apertura_struttura" => "22-03",
						"stato_struttura" => "bozza",
						"accetta_attivista_struttura" => "y",
						"policy_attivista_struttura" => "le politiche per lattivis",
						"note_struttura" => "note",
						"username_utente" => "ivo",
						"id_tipostruttura" => 1,
						"id_localita" => 161,
						"id_servizio" => array(8, 9, 10),

						// Spiaggia
						"lunghezza_spiaggia" => 344,
						"ingresso_spiaggia" => 'free',
						"sicurezza_spiaggia" => '3',
						"affollamento_spiaggia" => '4',
						"relax_spiaggia" => '5',
						"voto_traspubblico_spiaggia" => '7',
						"facilita_parcheggio_spiaggia" => '0',
						"voto_accessibilita_spiaggia" => '6',
						"voto_particolarita_spiaggia" => '4',
						"percent_libera_spiaggia" => '20',
						"pulizia_sabbia_spiaggia" => '3',
						"pulizia_acqua_spiaggia" => '4',
						"fondale_spiaggia" => 'roccia',
						// MM
						"id_spggsuolo" => array(1, 2),
						"id_spggventoideale" => array("N", "NE"),
						"id_spggfrequentazioni" => array(1),
						"id_spggsport" => array(1, 2)
						);

//imposto forward dopo l'inserimento
$_SESSION["nextOkPage"] = array(	"page" => "InsertStruttura",
											"pageType" => "Form");
*/
//------------------------------------------------------------------------------

/**
 * UPDATE ARTICOLO+TEA
 *
$_POST = array (	// routing params
						"component" => 'crud',
						"task" => 'update',

						// Articolo
						"crudNtt" => 'Articolo**Tea',
						"id_articolo" => 60,
						"id_localita" => 160,
						"id_categoria" => 0,
						"rilevanza_articolo" => 9,
						"id_struttura" => null,

						// Tea params
            		"MORE#Tea" => array (
            				array
                        (
                            "id_tea" => 23,
                            "lingua_sigla_tea" => "it",
                            "titolo_tea" => "La friseddhax",
                            "abstract_tea" => 'un articolo sulla frisa..',
                            "descrizione_tea" => 'ecco la frisa tosta tosta',
                            "stato_tea" => 'bozza',
                            "username_utente" => 'baoTheCrazyDog'
                        ),
                     	array
                        (
                            "id_tea" => 24,
                            "lingua_sigla_tea" => "it",
                            "titolo_tea" => "La friseddhax",
                            "abstract_tea" => 'un articolo sulla frisa..2',
                            "descrizione_tea" => 'ecco la frisa tosta tosta2',
                            "stato_tea" => 'bozza',
                            "username_utente" => 'baoTheCrazyDog'
                        ),
                        array
                        (
                            "id_tea" => 25,
                            "titolo_tea" => 'asdfx',
                            "abstract_tea" => 'asdf',
                            "descrizione_tea" => 'asdf',
                            "stato_tea" => 'bozza',
                            "username_utente" => 'baoTheCrazyDog'
                        )
                  )
);
*/


/*$_SESSION["nextOkPage"] = array(	"page" => "InsertArticolo",
											"pageType" => "Form");

//------------------------------------------------------------------------------

/**
* INSERIMENTO ARTICOLO+TEA

$_POST = array (	// routing params
						"component" => 'crud',
						"task" => 'insert',

						// Articolo
						"crudNtt" => 'Articolo**Tea',
						"id_localita" => 170,
						"id_categoria" => 0,
						"rilevanza_articolo" => 2,
						//"id_struttura" => 67,

						// Tea params
            		"MORE#Tea" => array (
            				array
                        (
                            "lingua_sigla_tea" => "it",
                            "titolo_tea" => "La pappina",
                            "abstract_tea" => 'un articolo sulla frisa..',
                            "descrizione_tea" => 'ecco la frisa tosta tosta',
                            "stato_tea" => 'bozza',
                            "username_utente" => 'baoTheCrazyDog'
                        ),
                     	array
                        (
                            "lingua_sigla_tea" => "it",
                            "titolo_tea" => "La pappina",
                            "abstract_tea" => 'un articolo sulla frisa..2',
                            "descrizione_tea" => 'ecco la frisa tosta tosta2',
                            "stato_tea" => 'bozza',
                            "username_utente" => 'baoTheCrazyDog'
                        ),
                        array
                        (
                            "lingua_sigla_tea" => 'it',
                            "titolo_tea" => 'La pappina',
                            "abstract_tea" => 'asdf',
                            "descrizione_tea" => 'asdf',
                            "stato_tea" => 'bozza',
                            "username_utente" => 'baoTheCrazyDog'
                        )
                  )
);
*/

//------------------------------------------------------------------------------

/* MULTIPLE UPDATE NTT TEST
$_SESSION["nextOkPage"] = array(	"page" => "UpdateArticolo",
											"pageType" => "Form");

$_POST = array (	// routing params
						"component" => 'crud',
						"task" => 'update',
						"crudNtt" => 'Articolo**Tea',

						// Articolo params
						"id_articolo" => 69,
						"rilevanza_articolo" => 3,
						"id_categoria" => 0,
						"id_struttura" => 67,
						// multiple of Tea
						"MORE#Tea" => array(
								// Tea 1 params
								array(
								"id_tea" => 0,
								"lingua_sigla_tea" => 'it',
								"autore_tea" => 'camillo',
								"titolo_tea" => 'Che mmerda de discoteca stu Riobo',
								"abstract_tea" => 	'Questo  tutto quello che'
															.' avreste voluto sapere...',
								"descrizione_tea" => 'Questa  la descrizione della'
															.' traduzione espansione articolo',
								"a_colpo_d_occhio_tea" => 'A colpo di occhio',
								"stato_tea" => 'bozza',
								"username_utente" => 'baoTheCrazyDog'
								),
								// Tea 2 params
								array(
								"id_tea" => 1,
								"lingua_sigla_tea" => 'it',
								"autore_tea" => 'camillo',
								"titolo_tea" => 'La magia del Riobo di mmerda',
								"abstract_tea" => 	'Questo  tutto quello che'
															.' avreste voluto sapere...',
								"descrizione_tea" => 'Questa  la descrizione della'
															.' traduzione espansione articolo',
								"a_colpo_d_occhio_tea" => 'bellu bellu',
								"stato_tea" => 'bozza',
								"username_utente" => 'baoTheCrazyDog'
								),
								// Tea 3 params
								array(
								"id_tea" => 2,
								"lingua_sigla_tea" => 'it',
								"autore_tea" => 'camillo',
								"titolo_tea" => 'Stasera Riobo? ma vaff...',
								"abstract_tea" => 	'Questo  tutto quello che'
															.' avreste voluto sapere...',
								"descrizione_tea" => 'Questa  la descrizione della'
															.' traduzione espansione articolo',
								"a_colpo_d_occhio_tea" => 'ste manie te protagionismu',
								"stato_tea" => 'bozza',
								"username_utente" => 'baoTheCrazyDog'
								)
						)
					);
*/

//------------------------------------------------------------------------------

//MULTIPLE INSERT NTT TEST
/*
$_SESSION["nextOkPage"] = array(	"page" => "InsertArticolo",
											"pageType" => "Form");

$_POST = array (	// routing params
						"component" => 'crud',
						"task" => 'insert',
						"crudNtt" => 'Articolo**Tea',

						// Articolo params
						"rilevanza_articolo" => 10,
						"id_categoria" => 0,
						"id_struttura" => 67,
						// multiple of Tea
						"MORE#Tea" => array(
								// Tea 1 params
								array(
								//"id_tea" => 0,
								"lingua_sigla_tea" => 'it',
								"autore_tea" => 'ivo',
								"titolo_tea" => 'Che mmerda de discoteca stu Riobo',
								"abstract_tea" => 	'Questo  tutto quello che'
															.' avreste voluto sapere...',
								"descrizione_tea" => 'Questa  la descrizione della'
															.' traduzione espansione articolo',
								"a_colpo_d_occhio_tea" => 'A colpo di occhio',
								"stato_tea" => 'bozza',
								"username_utente" => 'baoTheCrazyDog'
								),
								// Tea 2 params
								array(
								//"id_tea" => 1,
								"lingua_sigla_tea" => 'it',
								"autore_tea" => 'dan',
								"titolo_tea" => 'La magia del Riobo di mmerda',
								"abstract_tea" => 	'Questo  tutto quello che'
															.' avreste voluto sapere...',
								"descrizione_tea" => 'Questa  la descrizione della'
															.' traduzione espansione articolo',
								"a_colpo_d_occhio_tea" => 'bellu bellu',
								"stato_tea" => 'bozza',
								"username_utente" => 'baoTheCrazyDog'
								),
								// Tea 3 params
								array(
								//"id_tea" => 2,
								"lingua_sigla_tea" => 'it',
								"autore_tea" => 'ivo',
								"titolo_tea" => 'Stasera Riobo? ma vaff...',
								"abstract_tea" => 	'Questo  tutto quello che'
															.' avreste voluto sapere...',
								"descrizione_tea" => 'Questa  la descrizione della'
															.' traduzione espansione articolo',
								"a_colpo_d_occhio_tea" => 'ste manie te protagionismu',
								"stato_tea" => 'bozza',
								"username_utente" => 'baoTheCrazyDog'
								)
						)
					);
*/


/*imposto forward dopo l'inserimento
$_SESSION["nextOkPage"] = array(	"page" => "InsertStruttura",
											"pageType" => "Form");

//------------------------------------------------------------------------------
/**
* INSERIMENTO LOCALITA'+STRUTTURA

$_POST = array (	// routing params
						"component" => 'crud',
						"task" => 'insert',
						"crudNtt" => 'Localita**Struttura',
						// Localita params
						"nome_localita" => "Nard",
						"rilevanza_localita" => 5,
						"costa_entroterra_localita" => 'entroterra',
						"google_map_localita" => 'gmapnard',
						// Struttura params
						"nome_struttura" => "Mind the Gap",
						"giorno_notte_struttura" => "notte",
						"indirizzo_zona_struttura" => "via galatone",
						//"google_map_struttura" => "gmapmindthegap",
						"estivo_invernale_struttura" => "",
						"sito_struttura" => "www.mindthegap.com",
						"giorni_apertura_struttura" => "lunedchiuso",
						"orari_apertura_struttura" => "22-03",
						"stato_struttura" => "bozza",
						"accetta_attivista_struttura" => "y",
						"policy_attivista_struttura" => "le politiche per lattivis",
						"note_struttura" => "note",
						"username_utente" => "ivo",
						"id_tipostruttura" => 2);

/**
* INSERIMENTO LOCALITA'
*/
$_POST = array (	// routing params
						"component" => 'crud',
						"task" => 'insert',
						"crudNtt" => 'Localita',
						// Localita params
						"nome_localita" => "Nard�",
						"rilevanza_localita" => 10,
						"costa_entroterra_localita" => 'entroterra',
						"google_map_localita" => '40.364718,18.173332',
						"id_lcltarea" => array(1, 2)
						);



//------------------------------------------------------------------------------
/**
* CANCELLAZIONE ARTICOLO
*
// attenzione, non bisogna indicare il nome dell'id! mettere direttamente
// il valore dell'id oppure 0 => 117
// imposto forward dopo l'inserimento
$_SESSION["nextOkPage"] = array(	"page" => "deleteArticolo",
											"pageType" => "Form");

$_POST = array (	"component" => 'crud',
						"task" => 'delete',
						"crudNtt" => 'Articolo',
						70);

*/
?>