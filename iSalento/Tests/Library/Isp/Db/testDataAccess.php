<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/danielecassini/Sites/iSalento";

// Percorsi alle cartelle dei moduli
require($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/DataAccess.php");
$arr = array("TEST DataAccess VUOTO");

// creo l'istanza dao
try{
	$dao = Isp_Db_DataAccess::getInstance();
}catch (DbConnException $e) {
	echo('DbConnectionException lanciata!');
    //rethrow it
    //throw $e;
}catch (DbSelectException $e) {
    echo('DbSelectionException lanciata!');
	//rethrow it
    //throw $e;
}

$q = "Nessuna query richiesta.";
/*
echo("1: ".$_SERVER['SERVER_ADDR']);
echo("<br><br>");
echo("2: ".$_SERVER['DOCUMENT_ROOT']);
echo("<br><br>");
echo("3: ".$_SERVER['PHP_SELF']);
echo("<br><br>");
echo("4: ".$_SERVER['PATH']);
echo("<br><br>");
echo("5: ".$_SERVER['SCRIPT_FILENAME']);
echo("<br><br>");
echo("6: ".getcwd());
echo("<br><br>");
*/
/* TEST SELECT @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
$q = $dao->make_select_query(	"struttura",
								array(	"id_struttura",
										"nome_struttura"),
								array(	"giorno_notte" => "g",
										"id_tipo_struttura"=> 3),
								array("id_struttura" => "ASC"),0,20
							);
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/* TEST INSERT @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*
$f_a = array(	"nome_struttura" => "ZonaFranca",
				"giorno_notte" => "n",
				"indirizzo_zona" => "via toti 222",
				//"google_map_struttura" => "gmapzonafranca",
				"estivo_invernale" => "i",
				"sito_struttura" => "www.zona.com",
				"stato_struttura" => "p",
				"note_struttura" => "bella gente",
				"username" => "toto",
				"id_localita" => 115,
				"id_tipo_struttura" => 6);
$q = $dao->make_insert_query("struttura", $f_a);
*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

/* TEST SELECT JOIN  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/*
$c_a = array(
"id_struttura",
"nome_struttura",
"giorno_notte",
"indirizzo_zona",
//"google_map_struttura",
"estivo_invernale",
"sito_struttura",
"giorni_apertura",
"orari_apertura",
"stato_struttura",
"data_inserimento_struttura",
"accetta_attivista",
"policy_attivista",
"note_struttura",
"username",
"id_localita",
"id_tipo_struttura",
"nome_localita",
"nome_tipo_struttura",
"descrizione_tipo_struttura");
*/
//$c_a = array("id_struttura");
//$t_a = array("struttura", "referente_struttura", "referente");
//$w_a = array("stato_referente" => 2);

//$o_a = array(array("id_x" => "123"), array("id_x" => "321"));
//$q = $dao->make_select_join_query($c_a,$t_a,$w_a);

//$q = $dao->make_select_join_andor_query($c_a,$t_a,$w_a, $o_a);

/*$q = $dao->make_select_join_query(	array(	"id_foto_video",
											"link_foto_video",
											"data_inserimento_foto_video",
											"marker_foto_video",
											"stato_foto_video",
											"id_struttura",
											"nome_struttura",
											"username",
											"id_categoria",
											"nome_categoria",
											"id_articolo" ),
									array(	"foto_video",
											"categoria",
											"struttura"),
									array ( "id_foto_video" => 1 )
									);
*/
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
//$tables_array = array("foto_video", "categoria", "localita");
//$arr = $dao->get_tbl_connectors_array("struttura", "localita");

//$x = array();
//$arr = $dao->get_multitbl_connectors_array($tables_array, $x);
//print_r($x);

/* TEST CANCELLAZIONE TABELLE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

/* TEST UPDATE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
/*@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/
$arr = $dao->get_tbl_fields_name_array_from("struttura");
echo($q);
/*
if ($q !== "Nessuna query richiesta."){

	if($dao->invia_query($q)){
		echo("<br>"."<br>"."<b> Query eseguita! </b>");
		$arr = array();
		while($row = $dao->get_record()){
	    	array_push($arr, $row);
	    }
	}else{
		echo("<br>"."<br>"."<b> Query fallita </b>");
	}
}
*/
?>
<pre><?php print_r($arr); ?></pre>
