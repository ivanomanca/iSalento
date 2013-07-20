<?php
//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
$_SERVER['DOCUMENT_ROOT'] = "/Users/ivanomanca/Sites/iSalento";

// Percorsi alle cartelle dei moduli
require_once($_SERVER['DOCUMENT_ROOT']."/Library/Isp/Db/SimpleEnquirer.php");
try{
	$g = Isp_Db_SimpleEnquirer::getInstance();
	}catch (DbConnException $e) {
		//rethrow it
        //throw $e;
    }catch (DbSelectException $e) {
        //rethrow it
        //throw $e;
    }
$arr = array("TEST SimpleEnquirer VUOTO");

/* TEST @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@*/

//$arr = $g->getRecord("localita", array("id_localita" => 160));
//$arr = $g->getList("tipostruttura");
//$arr = $g->getList("categoria");
/*$arr = $g->getList("struttura", array( 'distance' => 'ASC',
													'gmapfilter' =>
													array(	'latgmap_struttura' => 37,
 																'lnggmap_struttura' => -122,
 																'rgmap' => 30)));*/
$arr = $g->getList("arealocalita", null, null, null, array("id_area" => 1));


// TEST PER LA VIEW
/*
$listaTipo = $g->getList('tipostruttura');
$listaCategoria = $g->getList('categoria');

$listaOrdinata = array();
foreach($listaTipo as $tipostruttura){
	// lo puoi fare perch categoria non ha l'id auto_increment
	$nome_categoria =	$listaCategoria[$tipostruttura['id_categoria']]
 												['nome_categoria'];
	$listaOrdinata["{$tipostruttura['id_tipostruttura']}"] =
						$nome_categoria." - ".$tipostruttura['nome_tipostruttura'];
}

asort($listaOrdinata);
print_r($listaOrdinata);
//$arr = $listaOrdinata;
*/
?>
<pre><?php print_r($arr); ?></pre>
