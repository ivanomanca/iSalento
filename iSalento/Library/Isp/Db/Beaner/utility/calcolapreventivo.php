<?php
// TARIFFARIO
$anno = 2009;
$tariffe = array("bassa" => 15, "media" => 20, "alta" => 25);
$scontoOltreSettimana = 5;
$maxGiorniPrenotabili = 30;


/****************************************************************************
	CALCOLATORE
****************************************************************************/

if (isset($_POST['numeropersone'])&&
	isset($_POST['g_arrivo'])&&
	isset($_POST['m_arrivo'])&&
	isset($_POST['a_arrivo'])&&
	isset($_POST['g_partenza'])&&
	isset($_POST['m_partenza'])&&
	isset($_POST['a_partenza'])) {
	
	//recupero input
	$numero_persone = $_POST['numeropersone'];	
	$g_arrivo = $_POST['g_arrivo'];
	$m_arrivo = $_POST['m_arrivo'];
	$a_arrivo = $_POST['a_arrivo'];
	
	$g_partenza = $_POST['g_partenza'];
	$m_partenza = $_POST['m_partenza'];
	$a_partenza = $_POST['a_partenza'];
	
	// controllo consistenza input
	$arrivo = mktime(0,0,0, $m_start, $g_start, $a_start);
	$partenza = mktime(0,0,0, $m_stop, $g_stop, $a_stop);
	
	if(inputControlOk(	$g_arrivo, $m_arrivo, $a_arrivo,
						$g_partenza, $m_partenza, $a_partenza)){
		
		$num_notti = diffDate($arrivo, $partenza);
		$tariffaMax = $tariffe[calcoloTariffa($arrivo)];
		
		// controllo che non sia stato prenotato più di un mese
		if($num_notti < $maxGiorniPrenotabili){
			// controllo che siano stati rispettati i vincoli delle settimane
			if(vincoliOk($arrivo, $partenza)){
				// tariffa scontata per > 4 persone
				if($numero_persone - 4 < 0){ $sconto = 0; }
				elseif ($numero_persone - 4 >= 0) {$sconto = $numero_persone - 4;}
				$tariffa = $tariffaMax - $sconto;
				// calcolo il preventivo
				$prev = calcolaPreventivo(	$tariffa,
											$numero_persone,
											$num_notti);
				// arrotondo il preventivo
				$preventivo_finale = $prev;
				
				// stampo il preventivo
				stampaPreventivo($numero_persone, $num_notti, $preventivo_finale);
			}else{
				echo("Correggi e riprova.");
			}
		}else{
			echo(	"Per soggiorni oltre i 30 giorni".
					" inviare una mail a cesaremanca@gmail.com");
		}
	}else {
		echo("<br>Correggere e riprovare.");
	}
}else{ 
	echo("Il calcolo del preventivo non e' al momento disponibile.");
}

/***********************************************************************
	UTILITY
***********************************************************************/
function calcolaSconto(){
	return 0;
}

function calcoloTariffa($data){
	// 1 Gen - 13 Giu, 12 Set - 31 Dic
	if((mktime(0, 0, 0, 1, 1, $anno) < $data && 
		$data < mktime(0, 0, 0, 6, 12, $anno))
		||
		mktime(0, 0, 0, 1, 1, $anno) < $data && 
		$data < mktime(0, 0, 0, 1, 1, $anno)){
		return "bassa";	
	}
	// 13 Giu - 1 Ago, 29 Ago - 12 Set
	if((mktime(0, 0, 0, 6, 13, $anno) < $data && 
		$data < mktime(0, 0, 0, 8, 1, $anno))
		||
		mktime(0, 0, 0, 8, 29, $anno) < $data && 
		$data < mktime(0, 0, 0, 9, 12, $anno)){
		return "media";	
	}
	// 1 Ago - 29 Ago
	if((mktime(0, 0, 0, 6, 1, $anno) < $data && 
		$data < mktime(0, 0, 0, 8, 29, $anno))){
		return "media";
	}
}

function calcolaPreventivo($tariffa, $numero_persone, $numero_notti){
	$scontopercentuale = 0;
	// tariffa
	if($numero_notti > 7){
		$scontopercentuale = $scontoOltreSettimana;
	}
	// calcolo il totale
	$totale = $numero_persone*$numero_notti*$tariffa;
	// applico sconto
	$preventivo = $totale - $totale/100*$scontopercentuale;
	// ritorno il valore
	return $preventivo;
}

function inputControlOk(	$g_arrivo, $m_arrivo, $a_arrivo,
							$g_partenza, $m_partenza, $a_partenza){
	// controllo esistenza delle date specificate
	if(	($m_arrivo == 2 && in_array($g_arrivo, array(29, 30, 31)))||
		($m_arrivo == 4 && $g_arrivo == 31)||
		($m_arrivo == 6 && $g_arrivo == 31)||
		($m_arrivo == 9 && $g_arrivo == 31)||
		($m_arrivo == 11 && $g_arrivo == 31)){
			echo("Hai specificato una data di arrivo inesistente.");
			return false;
		}
	if(	($m_partenza == 2 && in_array($g_partenza, array(29, 30, 31)))||
		($m_partenza == 4 && $g_partenza == 31)||
		($m_partenza == 6 && $g_partenza == 31)||
		($m_partenza == 9 && $g_partenza == 31)||
		($m_partenza == 11 && $g_partenza == 31)){
			echo("Hai specificato una data di partenza inesistente.");
			return false;
		}
	
	// controllo che la data di partenza non sia prima dell'arrivo
	if(!isBefore(	$g_arrivo, $m_arrivo, $a_arrivo,
					$g_partenza, $m_partenza, $a_partenza)){
		echo("La data di arrivo deve essere precedente alla partenza :).");
		return false;
	}
	return true;
}

function isBefore($g_start, $m_start, $a_start, $g_stop, $m_stop, $a_stop){
	$arrivo = mktime(0,0,0, $m_start, $g_start, $a_start);
	$partenza = mktime(0,0,0, $m_stop, $g_stop, $a_stop);
	$giorni = diffDate($arrivo, $partenza);
	if($giorni > 0){
		return true;
	}else{
		return false;
	}
}

function diffDate($arrivo, $partenza){
	$diff = $partenza - $arrivo;
	$diffx = getdate($diff);
	$giorni = $diffx['yday'];
	return $giorni;
}

function stampaPreventivo($numero_persone, $num_notti, $preventivo_finale){
	// loggo su file...
	
	// stampo a video
	echo(	"Totale del preventivo [".
			$numero_persone." persone per ".
			$num_notti." notti]: ".
			$preventivo_finale." euro.");		
}

function vincoliOk($arrivo, $partenza){
	// da sabato a sabato
	$wday_arrivo = getdate($arrivo); 
	$wday_partenza = getdate($partenza);
	echo("arrivo ".$wday_arrivo['weekday']); 
	echo("partenza ".$wday_partenza['weekday']);
	
	if((	$wday_arrivo['weekday'] == "Saturday" &&
			$wday_partenza['weekday'] == "Saturday")){
				return true;
	}else{
		echo("Il giorno di arrivo e di partenza deve essere un sabato.");
		return false;
	}
}
?>
