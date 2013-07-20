<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Extra_ExtraHome extends Isp_Controller_Action_Instantiator{

							
	public function init($pag=null){
		
		// Istanzia il beaner (per ottenere tabelle e beans)
		if($this->instantiate("Isp_Db_Beaner")){
	        $beaner = $this->instancedObj;
        	// 1. Ricava l'articolo speciale da liista random
	        $newsA = $beaner->retrieve("A7B7Articolo", array("speciale_articolo" => 1,
												 			 "order_rnd" => "",
												 			 "righe" => 1));
			// 2. Verifica se  un articolo libero o di entitˆ 
			if(isset($newsA[0])){ // Se esiste qualcosa nel db!
				// Se  un articolo libero
				if(is_null($newsA[0]->Articolo->schedahome_entita_articolo)){ 
					$id = $newsA[0]->Articolo->id_articolo; // manda l'id articolo
					$ntt = "articolo";
				// Se  un articolo correlato ad una scheda entitˆ
				}elseif ($newsA[0]->Articolo->schedahome_entita_articolo == 1){ 
					// Se  un articolo di struttura
					if(!is_null($newsA[0]->Articolo->id_struttura)){
						$id = $newsA[0]->Articolo->id_struttura;
						$ntt = "struttura";
					}elseif (!is_null($newsA[0]->Articolo->id_localita)){
						$id = $newsA[0]->Articolo->id_localita;
						$ntt = "localita";
					}elseif (!is_null($newsA[0]->Articolo->id_evento)){
						$id = $newsA[0]->Articolo->id_evento;
						$ntt = "evento";
					}elseif (!is_null($newsA[0]->Articolo->id_attivista)){
						$id = $newsA[0]->Articolo->id_attivista;
						$ntt = "attivista";
					}
					
				}
			
												 			 	 
			// URL ARTICOLO NEWS
			$fwParamsArray = array(
							"listaTitle" => $pag->_urls->subUrls[0][0]->title,
							"listaPageName" => $pag->_urls->subUrls[0][0]->page,
							"listaPageDescription" => $pag->_urls->subUrls[0][0]->description,
							   );
			if(isset($newsA[0])){
				$pag->urlPageNews = new Isp_Url_Page($newsA[0]->A7Tea[0]->titolo_tea,
											"Scheda",
											"Scheda".ucfirst($ntt),
											array("id_$ntt" => $id)+$fwParamsArray,
											$newsA[0]->A7Tea[0]->abstract_tea);
			}
			
			// URL FOTO NEWS
			// Random tra le foto speciali di un articolo speciale!
			$foto = $beaner->retrieve("A7Fotovideo",
									 array(	"id_$ntt-fotovideo" => $id,
							 			   	"formato_speciale_fotovideo" => 1,
							 				"order_rnd" => "",
							  				"righe" => 1) );
			

						
			if(isset($foto[0])){
				$pag->urlPhotoNews = new Isp_Url_Photo(	$foto[0]->id_fotovideo,
														296,
														$foto[0]->nome_file_fotovideo,
														$pag->urlPageNews->title);
			}else{
			//	$urlPhoto = una foto defalt di bao;
			}
				
		}else{
				
		}
		}
		return $pag;
	}
	
}

?>