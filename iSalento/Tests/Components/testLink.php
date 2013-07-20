<?php
/**
 * Parametri di simulazione link per test
 */

$_GET = array (	"component" => 'Page',
				"task" => 'getPage',
				"page" =>'TestPage',
				"pageType" =>'Extra');
/*
$_GET = array (	"component" => 'page',
				"task" => 'getPage',
				"page" =>'test',
				"pageType" =>'extra');

*/

/*
// home page test
$_GET = array (	"component" => 'page',
				"ctrl" => 'home',
				"task" => 'index');
*/

// GET_PAGE TEST
/*				
$_GET = array (	"component" => 'crud',
				"task" => 'get_page',
				"page" => 'lista_struttura',
				"order_cre" => "id_localita",
				"costa_entroterra_localita" => "c",
				"giorno_notte_struttura" => 'g');
*/				 

// INSERT OBJ TEST
/*			
$_POST = array (	"component" => 'crud',
					"task" => 'insert',
					"obj" => 'Localita',
					"nome_localita" => "S. Isidoro",
					"costa_entroterra_localita" => "c",
					"rilevanza_localita" => 4,
					"google_map_localita" => "sisidorogmapaddress"); 
*/

// UPDATE OBJ TEST
/*			
$_POST = array (	"component" => 'crud',
					"task" => 'update',
					"obj" => 'Localita',
					"id_localita" => 116,
					"nome_localita" => "S. Caterina",
					"costa_entroterra_localita" => "c",
					"rilevanza_localita" => 5,
					"google_map_localita" => "santacaterinagmapaddress"); 
*/
// DELETE OBJ TEST
// attenzione, non bisogna indicare il nome dell'id! mettere direttamente
// il valore dell'id oppure 0 => 117
/*		
$_POST = array (	"component" => 'crud',
					"task" => 'delete',
					"obj" => 'Localita', 0 => 117);
*/



?>