<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Page.php");

/**
 * Controllore specifico di pagina.
 */		
class Ctrl_Lista_ListaSpeciale extends Isp_Controller_Action_Instantiator{

							
	public function init($pag=null){
		
		// URL ARTICOLO NEWS
		$fwParamsArray = array(
							"listaTitle" => $pag->_urls->subUrls[0][0]->title,
							"listaPageName" => $pag->_urls->subUrls[0][0]->page,
							"listaPageDescription" => $pag->_urls->subUrls[0][0]->description,
							   );
		
		// Istanzia il beaner (per ottenere tabelle e beans)
		if($this->instantiate("Isp_Db_Beaner")){
	        $beaner = $this->instancedObj;
        	// 1. Ricava l'articolo speciale da liista random
	        $newsA = $beaner->retrieve("A7B7Articolo", array("speciale_articolo" => 1,
												 			 "order_rnd" => ""));
			// 2. Verifica se  un articolo libero o di entitˆ 
			foreach ($newsA as $news){
				
				// Se  un articolo libero
				if(is_null($news->Articolo->schedahome_entita_articolo)){ 
					$id = $news->Articolo->id_articolo; // manda l'id articolo
					$ntt = "articolo";
				// Se  un articolo correlato ad una scheda entitˆ
				}elseif ($news->Articolo->schedahome_entita_articolo == 1){ 
					// Se  un articolo di struttura
					if(!is_null($news->Articolo->id_struttura)){
						$id = $news->Articolo->id_struttura;
						$ntt = "struttura";
					}elseif (!is_null($news->Articolo->id_localita)){
						$id = $news->Articolo->id_localita;
						$ntt = "localita";
					}elseif (!is_null($news->Articolo->id_evento)){
						$id = $news->Articolo->id_evento;
						$ntt = "evento";
					}elseif (!is_null($news->Articolo->id_attivista)){
						$id = $news->Articolo->id_attivista;
						$ntt = "attivista";
					}
					
				}
													 			 	 			
				if(isset($news)){
					$urlPageNews = new Isp_Url_Page($news->A7Tea[0]->titolo_tea,
												"Scheda",
												"Scheda".ucfirst($ntt),
												array("id_$ntt" => $id)+$fwParamsArray,
												$news->A7Tea[0]->titolo_tea);
				}
				
				// URL FOTO NEWS
				// Random tra le foto speciali di un articolo speciale!
				$foto = $beaner->retrieve("A7Fotovideo",
										 array(	"id_$ntt-fotovideo" => $id,
								 			   	"formato_speciale_fotovideo" => 1,
								 				"order_rnd" => "",
								  				"righe" => 1) );
				
	
							
				if(isset($foto[0])){
					$urlPhotoNews = new Isp_Url_Photo(	$foto[0]->id_fotovideo,
															100,
															$foto[0]->nome_file_fotovideo,
															$urlPageNews->title);
				}else{
				//	$urlPhoto = una foto defalt di bao;
				}
				
				// page, photo, abstract
				$pic = array($urlPageNews, $urlPhotoNews, $news->A7Tea[0]->titolo_tea);
				array_push($pag->urlMatrix, $pic );
			}
		}	
		

		
		
		return $pag;

	}
	
}

?>