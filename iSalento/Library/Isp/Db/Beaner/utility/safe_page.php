<?php
// Per sicurezza ogni pagina inclusa ha questo
if ( !defined('IN_iSalento') )
{
	include_once($_SERVER['DOCUMENT_ROOT']."/components/crud/inc/hack_message.inc.php");
	die($hacking_attempt);
}
?>