<?
// Test sulle funzioni php

// Uguaglianza tra gli array
$array1 = array("key1"=> 1, "key2"=>2, "key3"=>3);
$array2 = array("key1"=> 1, "key2"=>2, "key3"=>3);
if($array1 == $array2){
	echo("sono uguali!");
}
// Trova l'underscore all'interno dell'array
$arr = array("par_und"=>3,"pas"=>2,"und_ses"=>"ciao");
$array = array();
foreach ($arr as $key=>$value) {
	if(substr_count($key,"_")>0){
		$array[$key]=$value;
	}
}

// Test lunghezza matrice
$a = array(array(true,"label","value","description"));
$b = array("groupName"=>array(array(true,"label","value","description")));

$matrix = $a;
while(is_array($matrix)){
	$matrix = reset($matrix);
	echo("count  ");
}
$b1 = reset($b);
$b2 = reset($b1);
$b3 = reset($b2);
$size = is_array($b3);

// Primo e ultimo elento dell'array
$array = array("primo","secondo","terzo","quarto");
foreach ($array as $tab){
	if($tab == $array[0]){echo "primo!!";}
	if($tab == end($array)){echo "ultimo!!";}
}
/**
 * array associativo con numeri
 */
$assoc = array(3=>"tre",5=>"cinque");
print_r($assoc);
$assoc[1]="uno";

/**
 * SPEZZARE LE STRINGHE
 */
echo "SPEZZARE LE STRINGHE"."<br />";
$str = "stringa";
echo "Prima lettera: ".$str[0]."<br />";
echo "Stringa restante: ".substr($str,1)."<br />";

/**
 * Percorsi
 */
//print_r($_SERVER);

/**
 * Array
 */
$a1 = array("uno","e");
$a2 = array("due","ci");
array_merge($a1, "e");
print_r($a1);

?>