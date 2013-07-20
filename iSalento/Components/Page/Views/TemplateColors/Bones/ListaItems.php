<?php
Isp_Loader::loadClass("Isp_Url_Photo");
Isp_Loader::loadClass('Isp_View_Bones');

class ListaItems extends Isp_View_Bones {
	// Stato
	public $fotoSize = 100; // Default size
	public $ombraFotoPx = 100; // Int px della foto
	
	// Out
	public $cList;
	
	/**
	 * Constructor
	 *
	 * @param bean $beanLista
	 * @param string $ntt - struttura, articolo, localita, evento, ecc.
	 * @param array $txt - dizionario con chiavi: readAll; readAllDescription.
	 * @param array $comingPageInfo - l'array comingPageInfo della pagina
	 */
	public function __construct($beanLista, $ntt, $txt, $comingPageInfo){
		
		// In box items
		Isp_Loader::loadVistaObj("Snippets","PageElements","PicTitleAbstract");
		Isp_Loader::loadVistaObj("Snippets","List","Separator");
		Isp_Loader::loadVistaObj("Snippets","List","cListItem");
		
		$upperNtt = ucfirst($ntt);
		$idNtt = "id_".$ntt;
		$nomeNtt = "nome_".$ntt;
		
		
		// LIST
		$listArray = array();
		foreach ($beanLista as $bean){
			if($ntt == "articolo"){
				$titolo = $bean->A7Tea[0]->titolo_tea;
				$articolo = $bean;
			}else{
				$titolo = $bean->$upperNtt->$nomeNtt;
				$articolo = $bean->A7B7Articolo[0]; 
			}
						
			// *** LINKS E TESTI *** //
			// FOTO
			if(isset($bean->A7B7Fotovideo[0])){
				$urlPhoto = new Isp_Url_Photo( 
									$bean->A7B7Fotovideo[0]->Fotovideo->id_fotovideo,
									$this->fotoSize,
									$bean->A7B7Fotovideo[0]->Tfv->nome_tfv,
									$bean->A7B7Fotovideo[0]->Tfv->didascalia_tfv
									);
			}else{
				$urlPhoto = null;
			}
			// TITOLO
			$urlTitle = new Isp_Url_Page($titolo,
										"Scheda",
										"scheda".$upperNtt,
										array($idNtt => $bean->$upperNtt->$idNtt)
										+ $comingPageInfo,
										$titolo);
			// DESCRIZIONE
			$abstract = $articolo->A7Tea[0]->abstract_tea;
			// LINK LEGGI TUTTO
			$readAllUrl = new Isp_Url(	$urlTitle->path, 
										$txt['readAll'] , 
										$txt['readAllDescription']." ".
										$titolo);
			// *** SNIPPETS *** //
			// Single box
			$inBoxItems = new PicTitleAbstract($urlPhoto, 
												$urlTitle, 
												$abstract, 
												$readAllUrl,
												$this->ombraFotoPx);
			// Separatore !Patch non riusabile!									
			if($ntt == "struttura"){
				$listSep = new Separator(ucfirst($bean->Struttura->nome_tipostruttura), 
										$bean->Struttura->nome_localita);
			}elseif ($ntt == "articolo"){
				$listSep = new Separator($bean->A7Tea[0]->data_tea,
									ucfirst($bean->Articolo->nome_categoria));
			}elseif ($ntt == "localita"){
				$listSep = new Separator(ucfirst(
												$bean->$upperNtt->costa_entroterra_localita));
			}else{
				$listSep = new Separator();
			}
				
			// Elemento di lista						
			$listItem = new cListItem($listSep, $inBoxItems, true);
			array_push($listArray, $listItem);
		}
	
		// List case
		Isp_Loader::loadVistaObj("Snippets","List","cList");
		$this->cList = new cList($listArray);
		
		array_push($this->snpOut, $this->cList);
		
	}
}
?>