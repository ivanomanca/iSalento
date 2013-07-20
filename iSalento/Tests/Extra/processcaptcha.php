<?
if(file_get_contents("http://www.opencaptcha.com/validate.php?ans="
							.$_POST['code']."&img=".$_POST['img']) =='pass') {
  // CONTINUE LOGIN
  echo("Mittico!");
} else {
  header("LOCATION: ".$_SERVER['HTTP_REFERER']."?opencaptcha=failed");
  //echo("hai sbagliato!");
}
?>