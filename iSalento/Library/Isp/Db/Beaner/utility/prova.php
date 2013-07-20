<?php
// unix timestamp del primo giorno
// del mese e dell'anno ricevuti
	//$time = mktime(0,0,0, 2, 1, 2009);

// genera l'array con le informazioni
//$date = getdate($time);
//print_r($date);
// giorni totali per il mese e anno
//$day_total = cal_days_in_month(CAL_GREGORIAN, $date['mon'], $date['year']);
//stampa mese e anno in oggetto

//$arrivo = mktime(0,0,0, 8, 29, 2009);
//$partenza = mktime(0,0,0, 12, 5, 2009);

//$diff = $partenza - $arrivo;
//$diffx = getdate($diff);
//$giorni = $diffx['yday'];
//echo($giorni);

$hashedpassword = sha1("pass");
echo($hashedpassword);

?>

<pre><?php // print_r($date); ?></pre>
<pre><?php // print_r($diffx); ?></pre>

