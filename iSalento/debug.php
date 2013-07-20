<?php
/******************************************************************************/
// configurazioni per l'utilizzo del debug
if(isset($_REQUEST['start_debug']) && $_REQUEST['start_debug']){
	//CONFIGURAZIONI PER I TEST CON IL DEBUGGER
	echo("|--------------------------------------------------\n");
	echo("| Powered-By: vISPo framework alpha (2009) started:\n");
	echo("|	Buon debug ".$_SERVER['USER']."! :D	\n");
	echo("|--------------------------------------------------\n\n");
/******************************************************************************/


	//require_once ($_SERVER['DOCUMENT_ROOT']."Library/Isp/Loader.php") ;
	/*---------------------------------------------------------------------------
		TESTS PAGES
	---------------------------------------------------------------------------*/
	$component = "Page";

	$controllers = $_SERVER['DOCUMENT_ROOT']
						."Tests/Components/$component/Controllers/";
	$page = 	$_SERVER['DOCUMENT_ROOT']
				."Tests/Components/$component/Views/TemplateColors/Pages/";

	// CRUD INSERT
	// includo l'array post
	//include_once($controllers."testCrud.php");

	// PAGE CONTROLLER
	//include_once($controllers."testPage.php");

	// MEDIA
	// includo l'array post e get
	//include_once($controllers."testMedia.php");

	// INSERT STRUTTURA
	// carico la pagina del form partendo dal $_GET
	//include_once($page."testInsertStruttura.php");

	// INSERT SPIAGGIA
	//include_once($page."testInsertSpiaggia.php");

	// INSERT ARTICOLO
	// carico la pagina del form partendo dal $_GET
	//include_once($page."testInsertArticolo.php");

	// UPLOAD PHOTO
	// carico la pagina del form per upload
	//include_once($page."testUploadPhoto.php");

	// HOME PAGE
	//include_once($page."testExtraHome.php");

	// FILTRO MARE
	//include_once($page."testFiltroMare.php");

	// FILTRO ARTICOLO
	//include_once($page."testFiltroArticolo.php");

	// FILTRO INSERISCI
	//include_once($page."testFiltroInserisci.php");

	// LISTA ARTICOLO
	//include_once($page."testListaArticolo.php");

	// LISTA STRUTTURA
	//include_once($page."testListaStruttura.php");

	// LISTA LOCALITA
	//include_once($page."testListaLocalita.php");

	// LISTA FOTO
	//include_once($page."testListaFoto.php");

	// SCHEDA FOTO
	//include_once($page."testSchedaFoto.php");

	// SCHEDA STRUTTURA
	//include_once($page."testSchedaStruttura.php");

	//SCHEDA SPIAGGIA
	//include_once($page."testSchedaSpiaggia.php");

	//READGMAPS
	include_once($page."testReadGmaps.php");
	
	//UPDATE SPIAGGIA
	//include_once($page."testUpdateSpiaggia.php");

	// SCHEDA ARTICOLO
	//include_once($page."testSchedaArticolo.php");

	// TRAINING COMPONENT
	// carico la pagina partendo dal $_GET
	//include_once($controllers."test".$component.".php");
	//include_once($controllers."testTraining.php");

	// ALL SNIPPETS PAGE
	//include_once($page."testAllSnippets.php");

	// PHOTOGALLERY SNIPPETS PAGE
	//include_once($page."testPhotoSnippets.php");

	// LOGIN FORM
	//include_once(	$_SERVER['DOCUMENT_ROOT'].
	//"Tests/Components/Authenticate/Controllers/testAuthenticate.php");

	// TEST SNIPPET
	//include_once($page."testSnippet.php");

}
?>