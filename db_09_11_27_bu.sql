-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 16 nov, 2009 at 05:38 PM
-- Versione MySQL: 5.1.37
-- Versione PHP: 5.2.11

--
-- Database: `isalento`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `articolo`
--

CREATE TABLE `articolo` (
  `id_articolo` int(9) unsigned NOT NULL AUTO_INCREMENT,
-- E' una specie di rank
  `rilevanza_articolo` int(2) DEFAULT NULL,
  `id_categoria` int(2) unsigned NOT NULL,
  `id_localita` int(3) unsigned DEFAULT NULL,
  `id_struttura` int(8) unsigned DEFAULT NULL,
  `id_evento` int(9) unsigned DEFAULT NULL,
  `id_attivista` int(8) unsigned DEFAULT NULL,
-- Finisce nell'home page tra gli speciali
  `speciale_articolo` set('1') DEFAULT NULL,
-- Articolo associato alla scheda tecnica, non correlato (rubriche)
  `schedahome_entita_articolo` set('1') DEFAULT NULL,
  PRIMARY KEY (`id_articolo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `articolo`
--

INSERT INTO `articolo` VALUES(1, NULL, 0, 1, NULL, NULL, NULL, '1', '1');
INSERT INTO `articolo` VALUES(2, NULL, 0, NULL, 1, NULL, NULL, '1', '1');
INSERT INTO `articolo` VALUES(3, NULL, 0, NULL, 2, NULL, NULL, '1', '1');

-- --------------------------------------------------------

--
-- Struttura della tabella `attivista`
--

CREATE TABLE `attivista` (
  `id_attivista` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `nome_attivista` varchar(20) DEFAULT NULL,
  `email_attivista` varchar(30) DEFAULT NULL,
  `tel_attivista` varchar(20) DEFAULT NULL,
  `sito_attivista` varchar(50) DEFAULT NULL,
  `dati_visibili_attivista` varchar(3) DEFAULT NULL,
  `data_inserimento_attivista` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `locale_forestiero_attivista` varchar(1) DEFAULT NULL,
  `voti_attivista` int(4) NOT NULL,
  `rilevanza_attivista` int(1) DEFAULT NULL,
  `username_utente` varchar(20) DEFAULT NULL,
  `id_tipoattivista` int(8) unsigned NOT NULL,
  PRIMARY KEY (`id_attivista`),
  UNIQUE KEY `email` (`email_attivista`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `attivista`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `attivistaevento`
--

CREATE TABLE `attivistaevento` (
  `id_attivista` int(7) unsigned NOT NULL,
  `id_evento` int(7) unsigned NOT NULL,
  PRIMARY KEY (`id_attivista`,`id_evento`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `attivistaevento`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `attivistaservizio`
--

CREATE TABLE `attivistaservizio` (
  `id_attivista` int(8) unsigned NOT NULL,
  `id_servizio` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id_attivista`,`id_servizio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `attivistaservizio`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(2) unsigned NOT NULL,
  `nome_categoria` varchar(35) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` VALUES(0, 'home');
INSERT INTO `categoria` VALUES(1, 'arte e storia');
INSERT INTO `categoria` VALUES(2, 'mare');
INSERT INTO `categoria` VALUES(3, 'notte e divertimenti');
INSERT INTO `categoria` VALUES(4, 'natura e relax');
INSERT INTO `categoria` VALUES(5, 'sport');
INSERT INTO `categoria` VALUES(6, 'cucina');
INSERT INTO `categoria` VALUES(7, 'shopping');
INSERT INTO `categoria` VALUES(8, 'folklore');
INSERT INTO `categoria` VALUES(9, 'info utili');

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `nome_evento` varchar(50) NOT NULL,
  `luogo_evento` varchar(100) NOT NULL,
  `data_evento` date NOT NULL,
  `orario_evento` time DEFAULT NULL,
  `sito_evento` varchar(100) DEFAULT NULL,
  `rilevanza_evento` int(1) unsigned DEFAULT NULL,
  `data_inserimento_evento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stato_evento` set('bozza','proponi','approvato','rivisto') NOT NULL,
  `counter_SMS_evento` int(6) unsigned DEFAULT NULL,
  `username_utente` varchar(20) NOT NULL,
  `id_localita` int(5) NOT NULL,
  PRIMARY KEY (`id_evento`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` VALUES(1, 'House dj set', '', '2008-05-09', '22:00:00', 'www.houseriobo.com', 10, '2008-05-28 15:01:46', '', NULL, 'ivo', 56);
INSERT INTO `evento` VALUES(2, 'Schiuma party', 'torre san giovanni', '2008-05-30', '15:00:00', 'www.schiumaparty.com', 12, '2008-05-28 15:01:46', '', NULL, 'ivo', 56);

-- --------------------------------------------------------

--
-- Struttura della tabella `feedback`
--

CREATE TABLE `feedback` (
  `id_feedback` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `categoria_feedback` varchar(15) NOT NULL,
  `titolo_feedback` varchar(30) NOT NULL,
  `commento_feedback` text,
  `data_feedback` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `visibile_feedback` varchar(1) NOT NULL,
  `note_feedback` text,
  `username_utente` varchar(20) NOT NULL,
  `id_localita` int(3) DEFAULT NULL,
  `id_struttura` int(8) DEFAULT NULL,
  `id_evento` int(7) DEFAULT NULL,
  `id_attivista` int(7) DEFAULT NULL,
  `id_articolo` int(7) unsigned DEFAULT NULL,
  `id_fotovideo` int(7) unsigned DEFAULT NULL,
  `lingua_sigla_feedback` varchar(2) NOT NULL,
  PRIMARY KEY (`id_feedback`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `feedback`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `fotovideo`
--

CREATE TABLE `fotovideo` (
  `id_fotovideo` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `data_inserimento_fotovideo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
-- ogni quanto bisognerebbe aggiornare quella foto
  `frequenza_aggiornamento_fotovideo` int(5) DEFAULT NULL,
  `ultimo_aggiornamento_fotovideo` timestamp NULL DEFAULT NULL,
  `marker_fotovideo` set('cartolina','panoramica') NOT NULL,
  `stato_fotovideo` set('bozza','proponi','approvato','rivisto') DEFAULT NULL,
  `rilevanza_fotovideo` int(2) DEFAULT '0',
  `id_articolo` int(8) DEFAULT NULL,
  `id_localita` int(5) DEFAULT NULL,
  `id_struttura` int(8) DEFAULT NULL,
  `id_evento` int(9) DEFAULT NULL,
  `id_attivista` int(8) DEFAULT NULL,
  `id_categoria` int(2) unsigned DEFAULT NULL,
-- la foto appartiene solo alla localita, non alle sue attrazioni correlate
  `home_localita_fotovideo` int(1) DEFAULT '0',
  `username_utente` varchar(20) NOT NULL,
-- esiste anche una copia in formato 16:9 per la homepage
  `formato_speciale_fotovideo` set('1') DEFAULT NULL,
-- il nome con il quale viene salvata la foto senza l'estensione
  `nome_file_fotovideo` varchar(150) NOT NULL,
  PRIMARY KEY (`id_fotovideo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dump dei dati per la tabella `fotovideo`
--

INSERT INTO `fotovideo` VALUES(1, '2009-11-15 16:17:58', 744, NULL, 'cartolina', 'proponi', 7, NULL, 1, NULL, NULL, NULL, 1, 1, '', '1', 'Il rivellino');
INSERT INTO `fotovideo` VALUES(2, '2009-11-15 16:21:27', 744, NULL, 'cartolina', 'proponi', 10, NULL, 1, NULL, NULL, NULL, 1, 1, '', '1', 'Tra le strade del borgo antico');
INSERT INTO `fotovideo` VALUES(3, '2009-11-15 16:21:31', 744, NULL, 'cartolina', 'proponi', 10, NULL, 1, NULL, NULL, NULL, 6, 1, '', '1', 'Ristoranti nella cittÃ  vecchia');
INSERT INTO `fotovideo` VALUES(4, '2009-11-15 16:21:37', 744, NULL, 'cartolina', 'proponi', 7, NULL, 1, NULL, NULL, NULL, 2, 1, '', '1', 'Il mercato');
INSERT INTO `fotovideo` VALUES(5, '2009-11-15 16:21:41', 744, NULL, 'cartolina', 'proponi', 7, NULL, 1, NULL, NULL, NULL, 6, 1, '', NULL, 'Ristoranti di pesce');
INSERT INTO `fotovideo` VALUES(6, '2009-11-15 16:21:45', 744, NULL, 'cartolina', 'proponi', 7, NULL, 1, NULL, NULL, NULL, 1, 1, '', NULL, 'I bastioni nella cittÃ  vecchia');
INSERT INTO `fotovideo` VALUES(7, '2009-11-15 16:33:49', 744, NULL, 'cartolina', 'proponi', 6, NULL, 1, 1, NULL, NULL, 2, 0, '', '1', 'Lidi nella baia');
INSERT INTO `fotovideo` VALUES(8, '2009-11-15 16:33:54', 744, NULL, 'cartolina', 'proponi', 7, NULL, 1, 1, NULL, NULL, 2, 0, '', NULL, 'Fondale baia verde');
INSERT INTO `fotovideo` VALUES(9, '2009-11-15 16:34:03', 744, NULL, 'cartolina', 'proponi', 4, NULL, 1, 1, NULL, NULL, 2, 0, '', NULL, 'Il mare a Gallipoli');
INSERT INTO `fotovideo` VALUES(10, '2009-11-15 16:34:09', 744, NULL, '', 'proponi', 0, NULL, 1, 1, NULL, NULL, 2, 0, '', NULL, 'Affollamento ad agosto');
INSERT INTO `fotovideo` VALUES(11, '2009-11-15 16:34:12', 744, NULL, 'cartolina', 'proponi', 4, NULL, 1, 1, NULL, NULL, 2, 0, '', '1', 'Gallipoli spiaggia');
INSERT INTO `fotovideo` VALUES(12, '2009-11-15 16:44:35', 744, NULL, 'cartolina', 'proponi', 10, NULL, 1, 2, NULL, NULL, 2, 0, '', '1', 'Parco naturale');
INSERT INTO `fotovideo` VALUES(13, '2009-11-15 16:44:39', 744, NULL, 'cartolina', 'proponi', 8, NULL, 1, 2, NULL, NULL, 2, 0, '', '1', 'Pulizia delle acque');
INSERT INTO `fotovideo` VALUES(14, '2009-11-15 16:44:43', 744, NULL, 'cartolina', 'proponi', 6, NULL, 1, 2, NULL, NULL, 2, 0, '', NULL, 'Punta della suina ');
INSERT INTO `fotovideo` VALUES(15, '2009-11-15 16:44:48', 744, NULL, 'cartolina', NULL, 6, NULL, 1, 2, NULL, NULL, 4, 0, '', '1', 'Ingresso del parco');
INSERT INTO `fotovideo` VALUES(16, '2009-11-15 16:44:52', 744, NULL, 'cartolina', 'proponi', 6, NULL, 1, 2, NULL, NULL, 4, 0, '', NULL, 'Parco e spiaggia');

-- --------------------------------------------------------

--
-- Struttura della tabella `frequentazioni`
--

CREATE TABLE `frequentazioni` (
  `id_frequentazioni` int(3) NOT NULL AUTO_INCREMENT,
  `nome_frequentazioni` varchar(15) NOT NULL,
  PRIMARY KEY (`id_frequentazioni`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `frequentazioni`
--

INSERT INTO `frequentazioni` VALUES(1, 'gay');
INSERT INTO `frequentazioni` VALUES(2, 'vecchi');

-- --------------------------------------------------------

--
-- Struttura della tabella `frequentazionispiaggia`
--

CREATE TABLE `frequentazionispiaggia` (
  `id_struttura` int(8) NOT NULL,
  `id_frequentazioni` int(3) NOT NULL,
  PRIMARY KEY (`id_struttura`,`id_frequentazioni`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `frequentazionispiaggia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `informa`
--

CREATE TABLE `informa` (
  `id_serviziostruttura` int(7) unsigned NOT NULL,
  `username_utente` varchar(20) NOT NULL,
  `modalita_informa` varchar(1) NOT NULL,
  `data_inserimento_informa` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_serviziostruttura`,`username_utente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `informa`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `localita`
--

CREATE TABLE `localita` (
  `id_localita` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `nome_localita` varchar(40) NOT NULL,
  `costa_entroterra_localita` set('costa','entroterra') NOT NULL,
  `rilevanza_localita` int(1) unsigned DEFAULT NULL,
  `google_map_localita` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_localita`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `localita`
--

INSERT INTO `localita` VALUES(1, 'Gallipoli', 'costa', 10, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `referente`
--

CREATE TABLE `referente` (
  `id_referente` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `ruolo_referente` varchar(10) NOT NULL,
  `mostra_contatti_al_pubblico_referente` int(1) NOT NULL,
  `note_referente` varchar(150) DEFAULT NULL,
  `stato_referente` set('bozza','proponi','approvato','rivisto') NOT NULL,
  `username_utente` varchar(20) NOT NULL,
  PRIMARY KEY (`id_referente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `referente`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `referentestruttura`
--

CREATE TABLE `referentestruttura` (
  `id_struttura` int(8) unsigned NOT NULL,
  `id_referente` int(5) unsigned NOT NULL,
  PRIMARY KEY (`id_struttura`,`id_referente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `referentestruttura`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `servizio`
--

CREATE TABLE `servizio` (
  `id_servizio` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nome_servizio` varchar(50) DEFAULT NULL,
  `descrizione_servizio` varchar(50) DEFAULT NULL,
  `id_categoria` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id_servizio`),
  FULLTEXT KEY `categoria` (`descrizione_servizio`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dump dei dati per la tabella `servizio`
--

INSERT INTO `servizio` VALUES(1, 'salvataggio e bagnino', 'sono presenti strutture per il savataggio ed il se', 2);
INSERT INTO `servizio` VALUES(2, 'accesso barca', 'consentito accesso con barca privata', 2);
INSERT INTO `servizio` VALUES(3, 'accesso sport acquatici', 'canale per entrata con attrezzature per sport acqu', 2);
INSERT INTO `servizio` VALUES(4, 'ombrellone/lettino', 'descrizione', 2);
INSERT INTO `servizio` VALUES(5, 'stazione meteo', 'descrizione', 2);
INSERT INTO `servizio` VALUES(6, 'deposito oggetti personali', 'descrizione', 2);
INSERT INTO `servizio` VALUES(7, 'noleggio per sport acquatici', 'descrizione', 2);
INSERT INTO `servizio` VALUES(9, 'docce', 'descrizione', 2);
INSERT INTO `servizio` VALUES(10, 'acqua scooter ', 'descrizione', 2);
INSERT INTO `servizio` VALUES(11, 'banana surf', 'descrizione', 2);
INSERT INTO `servizio` VALUES(12, 'musica dal vivo', 'descrizione', 3);
INSERT INTO `servizio` VALUES(13, 'dj set', 'descrizione', 3);
INSERT INTO `servizio` VALUES(14, 'dance hall', 'descrizione', 3);
INSERT INTO `servizio` VALUES(15, 'percorso con segnaletica', 'descrizione', 4);
INSERT INTO `servizio` VALUES(16, 'campo da beach volley', 'descrizione', 5);
INSERT INTO `servizio` VALUES(17, 'aperitivo', 'descrizione', 6);
INSERT INTO `servizio` VALUES(18, 'servizio bar', 'descrizione', 6);
INSERT INTO `servizio` VALUES(19, 'pranzo', 'descrizione', 6);
INSERT INTO `servizio` VALUES(20, 'accetta carte', 'descrizione', 7);
INSERT INTO `servizio` VALUES(21, 'medicheria', 'descrizione', 9);
INSERT INTO `servizio` VALUES(22, 'bancomat', 'descrizione', 9);
INSERT INTO `servizio` VALUES(23, 'cucina tipica', 'cucina tipica del luogo', 6);
INSERT INTO `servizio` VALUES(24, 'esposizione quadri', '', 1);
INSERT INTO `servizio` VALUES(25, 'Fermata autobus vicina', '', 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `servizioevento`
--

CREATE TABLE `servizioevento` (
  `id_evento` int(7) unsigned NOT NULL,
  `id_serviziostruttura` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id_evento`,`id_serviziostruttura`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `servizioevento`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `serviziostruttura`
--

CREATE TABLE `serviziostruttura` (
  `id_servizio` int(7) unsigned NOT NULL,
  `id_struttura` int(8) unsigned NOT NULL,
  `id_serviziostruttura` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `data_inserimento_serviziostruttura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_serviziostruttura`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dump dei dati per la tabella `serviziostruttura`
--

INSERT INTO `serviziostruttura` VALUES(1, 1, 1, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(11, 1, 2, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(10, 1, 3, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(9, 1, 4, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(7, 1, 5, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(4, 1, 6, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(2, 1, 7, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(17, 1, 8, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(18, 1, 9, '2009-11-15 16:25:31');
INSERT INTO `serviziostruttura` VALUES(1, 2, 10, '2009-11-15 16:36:18');
INSERT INTO `serviziostruttura` VALUES(9, 2, 11, '2009-11-15 16:36:18');
INSERT INTO `serviziostruttura` VALUES(6, 2, 12, '2009-11-15 16:36:18');
INSERT INTO `serviziostruttura` VALUES(3, 2, 13, '2009-11-15 16:36:18');
INSERT INTO `serviziostruttura` VALUES(17, 2, 14, '2009-11-15 16:36:18');
INSERT INTO `serviziostruttura` VALUES(18, 2, 15, '2009-11-15 16:36:18');
INSERT INTO `serviziostruttura` VALUES(25, 2, 16, '2009-11-15 16:36:18');

-- --------------------------------------------------------

--
-- Struttura della tabella `spiaggia`
--

CREATE TABLE `spiaggia` (
  `id_struttura` int(8) NOT NULL,
  `lunghezza_spiaggia` int(8) DEFAULT NULL,
  `larghezza_spiaggia` int(8) DEFAULT NULL,
  `colore_spiaggia` set('chiara','scura') DEFAULT NULL,
  `percent_libera_spiaggia` int(2) DEFAULT NULL,
  `fondale_spiaggia` set('sabbia','roccia','misto') DEFAULT NULL,
  `pulizia_acqua_spiaggia` int(2) DEFAULT NULL,
  `pulizia_sabbia_spiaggia` int(2) DEFAULT NULL,
  `voto_particolarita_spiaggia` int(2) DEFAULT NULL,
  `voto_accessibilita_spiaggia` int(2) DEFAULT NULL,
  `facilita_parcheggio_spiaggia` int(2) DEFAULT NULL,
-- voto sul trasporto pubblico
  `voto_traspubblico_spiaggia` int(2) DEFAULT NULL,
  `sicurezza_spiaggia` int(2) DEFAULT NULL,
  `ingresso_spiaggia` set('free','pagamento','invito') DEFAULT NULL,
  `affollamento_spiaggia` int(2) DEFAULT NULL,
  `relax_spiaggia` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_struttura`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `spiaggia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `sport`
--

CREATE TABLE `sport` (
  `id_sport` int(3) NOT NULL AUTO_INCREMENT,
  `nome_sport` varchar(15) NOT NULL,
  PRIMARY KEY (`id_sport`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `sport`
--

INSERT INTO `sport` VALUES(1, 'kitesurf');
INSERT INTO `sport` VALUES(2, 'beach-volley');

-- --------------------------------------------------------

--
-- Struttura della tabella `sportspiaggia`
--

CREATE TABLE `sportspiaggia` (
  `id_struttura` int(8) NOT NULL,
  `id_sport` int(3) NOT NULL,
  PRIMARY KEY (`id_struttura`,`id_sport`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `sportspiaggia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `struttura`
--

CREATE TABLE `struttura` (
  `id_struttura` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `nome_struttura` varchar(30) NOT NULL,
  `giorno_notte_struttura` set('giorno','notte','sempre') DEFAULT NULL,
  `indirizzo_zona_struttura` varchar(40) NOT NULL,
  `google_map_struttura` varchar(250) NOT NULL,
  `estivo_invernale_struttura` set('estivo','invernale','annuale') NOT NULL,
  `sito_struttura` varchar(80) DEFAULT NULL,
  `giorni_apertura_struttura` varchar(50) DEFAULT NULL,
  `orari_apertura_struttura` varchar(50) DEFAULT NULL,
  `stato_struttura` set('bozza','proponi','approvato','rivisto') DEFAULT 'bozza',
  `data_inserimento_struttura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `accetta_attivista_struttura` varchar(1) DEFAULT NULL,
  `policy_attivista_struttura` varchar(250) DEFAULT NULL,
  `note_struttura` varchar(200) DEFAULT NULL,
  `username_utente` varchar(20) DEFAULT NULL,
  `id_localita` int(3) DEFAULT NULL,
  `id_tipostruttura` int(3) DEFAULT NULL,
  PRIMARY KEY (`id_struttura`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `struttura`
--

INSERT INTO `struttura` VALUES(1, 'Baia verde', 'giorno', 'Litoranea Gallipoli Leuca', '', '', NULL, NULL, NULL, 'bozza', '2009-11-15 16:25:31', NULL, NULL, NULL, NULL, 1, 1);
INSERT INTO `struttura` VALUES(2, 'Parco naturale Punta Pizzo', 'giorno', 'Litoranea Gallipoli Leuca', '', '', NULL, NULL, NULL, 'bozza', '2009-11-15 16:36:18', NULL, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `suolo`
--

CREATE TABLE `suolo` (
  `id_suolo` int(2) NOT NULL AUTO_INCREMENT,
  `tipo_suolo` varchar(15) NOT NULL,
  PRIMARY KEY (`id_suolo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `suolo`
--

INSERT INTO `suolo` VALUES(1, 'sabbia');
INSERT INTO `suolo` VALUES(2, 'roccia');
INSERT INTO `suolo` VALUES(3, 'misto');

-- --------------------------------------------------------

--
-- Struttura della tabella `suolospiaggia`
--

CREATE TABLE `suolospiaggia` (
  `id_struttura` int(8) NOT NULL,
  `id_suolo` int(2) NOT NULL,
  PRIMARY KEY (`id_struttura`,`id_suolo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `suolospiaggia`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `tea` (traduzione espansione articolo)
--

CREATE TABLE `tea` (
  `id_tea` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `id_articolo` int(8) unsigned NOT NULL,
  `lingua_sigla_tea` set('it','en','de','es') NOT NULL,
  `autore_tea` varchar(20) DEFAULT NULL,
  `titolo_tea` varchar(50) NOT NULL,
  `abstract_tea` varchar(300) DEFAULT NULL,
  `descrizione_tea` text,
-- non usato, riassunto dei concetti dei paragrafi
  `a_colpo_d_occhio_tea` varchar(300) DEFAULT NULL,
  `data_tea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stato_tea` set('bozza','proponi','approvato','rivisto') DEFAULT NULL,
  `username_utente` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id_tea`,`id_articolo`,`lingua_sigla_tea`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dump dei dati per la tabella `tea`
--

INSERT INTO `tea` VALUES(1, 1, 'it', NULL, 'La perla dello Jonio', 'Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.', 'Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.', NULL, '2009-11-15 16:17:13', NULL, NULL);
INSERT INTO `tea` VALUES(2, 1, 'it', NULL, 'La cittÃ  vecchia di Gallipoli', NULL, 'Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.', NULL, '2009-11-15 16:17:13', NULL, NULL);
INSERT INTO `tea` VALUES(3, 1, 'it', NULL, 'Il porto', NULL, 'Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.', NULL, '2009-11-15 16:17:13', NULL, NULL);
INSERT INTO `tea` VALUES(4, 1, 'it', NULL, 'Vita notturna', NULL, 'Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.', NULL, '2009-11-15 16:17:13', NULL, NULL);
INSERT INTO `tea` VALUES(5, 1, 'it', NULL, 'Come raggiungere Gallipoli', NULL, 'Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.Una delle cittÃ  piÃ¹ rinomate del Salento per l''arte, il mare, la natura e il divertimento.', NULL, '2009-11-15 16:17:13', NULL, NULL);
INSERT INTO `tea` VALUES(6, 2, 'it', NULL, 'La spiaggia baia verde di Gallipoli', 'Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.', 'Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.', NULL, '2009-11-15 16:28:19', 'proponi', NULL);
INSERT INTO `tea` VALUES(7, 2, 'it', NULL, 'Il fondale', NULL, 'Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.', NULL, '2009-11-15 16:28:19', NULL, NULL);
INSERT INTO `tea` VALUES(8, 2, 'it', NULL, 'Accesso alla spiaggia', NULL, 'Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.', NULL, '2009-11-15 16:28:19', NULL, NULL);
INSERT INTO `tea` VALUES(9, 2, 'it', NULL, 'Parcheggi', NULL, 'Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.', NULL, '2009-11-15 16:28:19', NULL, NULL);
INSERT INTO `tea` VALUES(10, 2, 'it', NULL, 'Servizi', NULL, 'Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.Ormai da decenni presa d''assalto dai turisti per il suo mare cristallino e il movimento che si Ã¨ creato.', NULL, '2009-11-15 16:28:19', NULL, NULL);
INSERT INTO `tea` VALUES(11, 3, 'it', NULL, 'Il parco punta pizzo', 'Uno dei posti piÃ¹ naturali del Salento', 'Uno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del Salento', NULL, '2009-11-15 16:37:43', 'proponi', NULL);
INSERT INTO `tea` VALUES(12, 3, 'it', NULL, 'La natura', NULL, 'Uno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del Salento', NULL, '2009-11-15 16:37:43', NULL, NULL);
INSERT INTO `tea` VALUES(13, 3, 'it', NULL, 'I lidi nel parco', NULL, 'Uno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del <b>SalentoUno</b> dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del Salento', NULL, '2009-11-15 16:37:43', NULL, NULL);
INSERT INTO `tea` VALUES(14, 3, 'it', NULL, 'Attracco per gli yatch', NULL, 'Uno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del Salento', NULL, '2009-11-15 16:37:43', 'proponi', NULL);
INSERT INTO `tea` VALUES(15, 3, 'it', NULL, 'Spiagge', NULL, 'Uno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del SalentoUno dei posti piÃ¹ naturali del Salento', NULL, '2009-11-15 16:37:43', 'proponi', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `tfv` (traduzione foto video)
--

CREATE TABLE `tfv` (
  `lingua_sigla_tfv` varchar(3) NOT NULL,
  `id_fotovideo` int(9) unsigned NOT NULL,
-- titolo della foto
  `nome_tfv` varchar(100) NOT NULL,
-- breve descrizione
  `didascalia_tfv` varchar(250) DEFAULT NULL,
  `data_tfv` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stato_tfv` set('bozza','proponi','approvato','rivisto') DEFAULT NULL,
  `username_utente` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`lingua_sigla_tfv`,`id_fotovideo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `tfv`
--

INSERT INTO `tfv` VALUES('it', 1, 'Il rivellino', 'Il castella di Gallipoli', '2009-11-15 16:17:58', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 2, 'Tra le strade del borgo antico', 'Siamo a Gallipoli', '2009-11-15 16:21:27', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 3, 'Ristoranti nella cittÃ  vecchia', 'Vista suggestiva dei ristoranti a Gallipoli', '2009-11-15 16:21:31', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 4, 'Il mercato', NULL, '2009-11-15 16:21:37', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 5, 'Ristoranti di pesce', NULL, '2009-11-15 16:21:41', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 6, 'I bastioni nella cittÃ  vecchia', NULL, '2009-11-15 16:21:45', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 7, 'Lidi nella baia', NULL, '2009-11-15 16:33:49', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 8, 'Fondale baia verde', NULL, '2009-11-15 16:33:54', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 9, 'Il mare a Gallipoli', NULL, '2009-11-15 16:34:03', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 10, 'Affollamento ad agosto', NULL, '2009-11-15 16:34:09', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 11, 'Gallipoli spiaggia', 'Baia verde', '2009-11-15 16:34:12', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 12, 'Parco naturale', NULL, '2009-11-15 16:44:35', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 13, 'Pulizia delle acque', NULL, '2009-11-15 16:44:39', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 14, 'Punta della suina ', NULL, '2009-11-15 16:44:43', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 15, 'Ingresso del parco', NULL, '2009-11-15 16:44:48', NULL, NULL);
INSERT INTO `tfv` VALUES('it', 16, 'Parco e spiaggia', NULL, '2009-11-15 16:44:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipoattivista`
--

CREATE TABLE `tipoattivista` (
  `id_tipoattivista` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `nome_tipoattivista` varchar(15) NOT NULL,
  `descrizione_tipoattivista` text NOT NULL,
  `id_categoria` int(2) NOT NULL,
  PRIMARY KEY (`id_tipoattivista`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `tipoattivista`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `tipostruttura`
--

CREATE TABLE `tipostruttura` (
  `id_tipostruttura` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nome_tipostruttura` varchar(20) NOT NULL,
  `descrizione_tipostruttura` varchar(200) DEFAULT NULL,
  `id_categoria` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id_tipostruttura`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `tipostruttura`
--

INSERT INTO `tipostruttura` VALUES(1, 'spiaggia', 'di tutti i tipi', 2);
INSERT INTO `tipostruttura` VALUES(2, 'grotta marina', 'descrizione', 2);
INSERT INTO `tipostruttura` VALUES(3, 'kite-wind-surf', 'punto di sport acquatico', 2);
INSERT INTO `tipostruttura` VALUES(4, 'subacqua', 'punto di interesse per immersioni', 2);
INSERT INTO `tipostruttura` VALUES(5, 'lidi', 'lidi attrezzati', 2);

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `username_utente` varchar(25) NOT NULL,
  `crypted_password_utente` varchar(40) NOT NULL,
  `privilegi_utente` int(1) NOT NULL DEFAULT '1',
  `stato_utente` set('richiesta','attivo','disattivo') NOT NULL,
  `domanda_recovery_utente` varchar(30) DEFAULT NULL,
  `data_registrazione_utente` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nome_utente` varchar(20) DEFAULT NULL,
  `cognome_utente` varchar(20) DEFAULT NULL,
  `email_utente` varchar(30) NOT NULL,
  `emailconfirmed_utente` int(1) NOT NULL,
  `dati_visibili_utente` varchar(3) DEFAULT NULL,
  `tel_utente` varchar(12) DEFAULT NULL,
  `msn_utente` varchar(30) DEFAULT NULL,
  `skype_utente` varchar(30) DEFAULT NULL,
  `data_nascita_utente` date DEFAULT NULL,
  `provenienza_utente` varchar(20) DEFAULT NULL,
  `passioni_utente` varchar(200) DEFAULT NULL,
  `firma_utente` varchar(200) DEFAULT NULL,
  `sito_utente` varchar(100) DEFAULT NULL,
  `occupazione_utente` varchar(25) DEFAULT NULL,
-- Contiene la stringa che permette di verificare la conferma dell'indirizzo email inserito dall'utente
  `fp_utente` varchar(40) NOT NULL,
  PRIMARY KEY (`username_utente`),
  UNIQUE KEY `email` (`email_utente`,`tel_utente`,`msn_utente`),
  FULLTEXT KEY `nome` (`nome_utente`,`cognome_utente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` VALUES('admin', '22665f9cd19cc9946cf921623d4dcab834b221e4', 1, 'attivo', NULL, '2009-11-16 11:15:19', 'Amministratore', 'Amministratore', 'isalento.it@gmail.com', 1, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e37a2178c21633f396315f93f63594dd80a9b737');
INSERT INTO `utente` VALUES('ivo', '616b54f69c85d51a61385a5b0fd9225e424fbb33', 4, 'attivo', NULL, '2009-11-16 16:42:19', NULL, NULL, 'ivano.isp@gmail.com', 1, 'yes', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '35c6eefb46f13b1d5d8bf871946b390468abda69');

-- --------------------------------------------------------

--
-- Struttura della tabella `ventoideale`
--

CREATE TABLE `ventoideale` (
  `id_ventoideale` set('N','NE','E','SE','S','SO','O','NO') NOT NULL,
  `nome_ventoideale` varchar(15) NOT NULL,
  PRIMARY KEY (`id_ventoideale`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `ventoideale`
--

INSERT INTO `ventoideale` VALUES('N', 'nord');
INSERT INTO `ventoideale` VALUES('NE', 'nord-est');
INSERT INTO `ventoideale` VALUES('E', 'est');
INSERT INTO `ventoideale` VALUES('SE', 'sud-est');
INSERT INTO `ventoideale` VALUES('S', 'sud');
INSERT INTO `ventoideale` VALUES('SO', 'sud-ovest');
INSERT INTO `ventoideale` VALUES('O', 'ovest');
INSERT INTO `ventoideale` VALUES('NO', 'nord-ovest');

-- --------------------------------------------------------

--
-- Struttura della tabella `ventoidealespiaggia`
--

CREATE TABLE `ventoidealespiaggia` (
  `id_ventoideale` set('N','NE','E','SE','S','SO','O','NO') NOT NULL,
  `id_struttura` int(8) NOT NULL,
  PRIMARY KEY (`id_ventoideale`,`id_struttura`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `ventoidealespiaggia`
--

