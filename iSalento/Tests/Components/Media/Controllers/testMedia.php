<?php
// Test controller MEDIA
			
$_GET = array (	"component" => 'Media',
				"task" => 'testDbInsertPhoto'
				);

$_POST = array("photos"=>array(
							array("nome_tfv"=>"la mia foto",
								 "id_localita" => 2),
							array("nome_tfv"=>"seconda foto",
								"id_localita" => 2)),
				"salva"=>"upload");

				
//! da copiare nel controllore Media direttamente!
/*public function testDbInsertPhoto(){
	//$photoInfo = $this->front->request->params["photos"][$i];
	$photoInfo = $this->front->request->params["photos"][0];
	$idDb = $this->dbInsertPhoto($photoInfo);
	echo "l'id inserito per la foto ".$photoInfo["nome_tfv"]."e': ".$idDb;
}*/

/*
// !test for computeSize function, da cancellare!
	public function testComputeSize(){
		$newSizesArray = $this->computeSize($_FILES[0]['tmp_name'], $this->formats[1]);	
		echo("Dimensioni originali:<br>");
		print_r(getimagesize($_FILES[0]['tmp_name']));
		echo("<br><br>Dimensioni calcolate per il resize:<br>");
		print_r($newSizesArray);
		
	}
*/
?>