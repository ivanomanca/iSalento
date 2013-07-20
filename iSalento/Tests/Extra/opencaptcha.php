<form action="processcaptcha.php" method="POST" >
<?
if($_GET['opencaptcha']=='failed') {
	echo "<script>alert('Non hai inserito correttamente il codice');</script>";
}
$date = date("Ymd");
$rand = rand(0,9999999999999);
$height = "80";
$width  = "240";
$img    = "$date$rand-$height-$width.jpgx";
echo "<input type='hidden' name='img' value='$img'>";
echo "<a href='http://www.opencaptcha.com'><img src='http://www.opencaptcha.com/img/$img' height='$height' alt='captcha' width='$width' border='0' /></a><br />";
echo "<input type=text name=code value='inserisci il codice' size='35' />";
?>
<input type="submit" value="avanti">
</form>