<?php/** Questo file contiene le passwords e i paramentri per accedere ai databases (locale o su server).* Il seguente codice viene incluso  solitamente in altre pagine che richiedono l'uso di questi * parametri. 	*//************************************ * DB: LOCALE o REMOTO o ZEND ************************************/if(!isset($_SERVER['SERVER_NAME'])){	//parametri per zend debugger	if($_SERVER['DOCUMENT_ROOT'] == "/var/www/iSalento/")		$db_host     = ":/var/run/mysqld/mysqld.sock";	else		$db_host     = ":/Applications/MAMP/tmp/mysql/mysql.sock";	$db_user     = "zend";	$db_password = "zend";	$db_name     = "isalento"; }elseif($_SERVER['SERVER_NAME'] == "localhost"){	// Se Dany	if($_SERVER['DOCUMENT_ROOT'] == "/var/www/iSalento/"){		//parametri del database locale 	   $db_host     = "localhost:8080"; 	   $db_user     = "root"; 	   $db_password = "10101985"; 	   $db_name     = "isalento"; 	}else{ // D@n & Ivo		//parametri del database locale		$db_host     = "localhost:8889";		$db_user     = "root";		$db_password = "root";		$db_name     = "isalento";	}}else{	//parametri per web	$db_host     = "localhost";    $db_user     = "isalent1_viSPo";    $db_password = "vKuR{crR1(!a";    $db_name     = "isalent1_isalento";}?>