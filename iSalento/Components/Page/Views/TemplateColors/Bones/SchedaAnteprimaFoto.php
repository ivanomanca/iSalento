<?php
Isp_Loader::loadClass("Isp_Url_Page");
Isp_Loader::loadClass('Isp_View_Bones');

class SchedaAnteprimaFoto extends Isp_View_Bones {
	
	public $anteprimaFoto;
	public $fotoSizeAnteprima = 100; // Default size
	
	/**
	 * Constructor
	 *
	 * @param bean $bean
	 * @param string $ntt - struttura, articolo, localita, evento, ecc.
	 * @param array $txt - dizionario con chiavi: readAllFoto; descrReadAllFoto,
	 * descrAnteprimaFoto, anteprimaFoto.
	 * @param string $color - colore
	 */
	public function __construct( $bean, $ntt, $txt, $color){
		
		$upperNtt = ucfirst($ntt);
		$idNtt = "id_".$ntt;
		$nomeNtt = "nome_".$ntt;
		
		if($ntt == "articolo"){
			$titolo = $bean->A7Tea[0]->titolo_tea;
		}else{
			$titolo = $bean->$upperNtt->$nomeNtt;
		}
		
		// ANTEPRIMA FOTO
		$urlAnteprimaFoto = new Isp_Url_Page( 	
								$txt['readAllFoto'],
								"Lista",
								"ListaFoto",
								array(	"id_$ntt-fotovideo" => 
										$bean->$upperNtt->$idNtt),
								$txt['descrReadAllFoto'].$titolo);
		
		$array4foto = array();
		for($i = 1; $i<=4; $i++){
			if(isset($bean->A7B7Fotovideo[$i])){
				
				$urlPhoto = new Isp_Url_Photo(
							$bean->A7B7Fotovideo[$i]->Fotovideo->id_fotovideo,
							$this->fotoSizeAnteprima,
							$bean->A7B7Fotovideo[$i]->Tfv->nome_tfv,
							$bean->A7B7Fotovideo[$i]->Tfv->didascalia_tfv);
				
				$pic  = array($urlAnteprimaFoto, $urlPhoto);
				array_push($array4foto, $pic);										
			}
		}
		if(!empty($array4foto)){
			Isp_Loader::loadVistaObj("Snippets","PageElements","FourPhotos");
			$four = new FourPhotos($txt['descrAnteprimaFoto'].$titolo,
									$array4foto, 
									$urlAnteprimaFoto);
									
			$this->anteprimaFoto = new cCaseBlock(	$txt['anteprimaFoto'],
													null,
													$four,
													$color);
													
			array_push($this->snpOut, $this->anteprimaFoto);
		}
	}
}


?>