<?php
Isp_Loader::loadClass("Isp_Url_Photo");
Isp_Loader::loadClass('Isp_View_Bones');

class SchedaAbstractFoto extends Isp_View_Bones {
	// Stato
	public $fotoSize = 200; // Default size
	public $ombraFotoPx = null; // Int px della foto
	
	// Out
	public $abstractFoto;
	
	/**
	 * Constructor
	 *
	 * @param bean $bean
	 * @param string $ntt - struttura, articolo, localita, evento, ecc.
	 * @param array $txt - dizionario con chiavi: inBreve;
	 * @param string $color - colore
	 */
	public function __construct($bean, $ntt, $txt, $color){
		
		$upperNtt = ucfirst($ntt);
		$idNtt = "id_".$ntt;
		$nomeNtt = "nome_".$ntt;
		
		// ABSTRACT	+ FOTO	
		if(isset($bean->A7B7Fotovideo[0])){
			$urlPhoto = new Isp_Url_Photo(	$bean->A7B7Fotovideo[0]
														->Fotovideo->id_fotovideo,
											$this->fotoSize,
											$bean->A7B7Fotovideo[0]
																	->Tfv->nome_tfv,
											$bean->A7B7Fotovideo[0]
															->Tfv->didascalia_tfv);
		}else {
			$urlPhoto = null;
		}	

		
		if($ntt == "articolo"){
			$articolo = $bean; 	
		}else{
			$articolo = $bean->A7B7Articolo[0]; 
		}
								
		$abstract = $articolo->A7Tea[0]->abstract_tea;
		
		Isp_Loader::loadVistaObj("Snippets","PageElements","PicTitleAbstract");
		$inBoxItems = new PicTitleAbstract($urlPhoto, 
											new Isp_Url(), 
											$abstract, null, 
											$this->ombraFotoPx, "");
		// Case box
		Isp_Loader::loadVistaObj("Snippets","Boxes","cCaseBlock");
		$this->abstractFoto = new cCaseBlock( 	$txt['inBreve'],
												null,
												$inBoxItems, 
												$color);
												
		array_push($this->snpOut, $this->abstractFoto);
	}
}
?>