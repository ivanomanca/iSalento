<?php
require_once($_SERVER['DOCUMENT_ROOT']."Components/Page/Controllers/Ctrl_Scheda/Ctrl_Scheda.php");

/**
 * Controllore padre delle pagine di tipo scheda
 */		
class Ctrl_Scheda_SchedaFoto extends Ctrl_Scheda {
	
	private $pag;
	public $anchorName = "vistaFoto";
								
	public function init($pag = null){
		// Default
		$this->pag = parent::init($pag);
		
		// Setta nella pagina  l'id richiesto
		$this->injectFotoId();
		// Setta nella pagina il bean foto
		$this->setSchedaBean();
		// Setta gli urls delle foto alla pagina precedente, corrente, successiva e finale
		$this->setNextBackLastCurrentUrls();
		
		return $this->pag;
		
	}
	
	private function injectFotoId(){
		// Inject id_fotovideo
		if(isset($this->front->request->params['idFotovideo'])){ 
			$this->pag->id_fotovideo = $this->front->request->params['idFotovideo'];
			$this->pag->paramsArray['idFotovideo'] = $this->pag->id_fotovideo;
		}
	}
	
	private function setSchedaBean(){
		// Get and set the requested photo bean
		$count = 0;
		// Scannerizza tutti gli id della lista bean finch non trovi quello richiesto
		while ($this->pag->listaFoto[$count]->Fotovideo->id_fotovideo != 
														$this->pag->id_fotovideo){
			$count++; // Numero di foto nel bean corrispondente all'id richiesto
		}
		$this->pag->count = $count;
		$this->pag->schedaFoto = $this->pag->listaFoto[$count];
	}
	
	private function setNextBackLastCurrentUrls(){
		
		// --- NEXT PHOTO URL --- //
		if($this->pag->count < sizeof($this->pag->listaFoto)-1){ // Se non  l'ultima foto
			// Copio i parametri
			$nextParams = $this->pag->paramsArray;
			// Assegno l'id della foto successiva
			$nextParams['idFotovideo'] = $this->pag->listaFoto[$this->pag->count+1]
																->Fotovideo->id_fotovideo;

			// Descrizione link fatta da titolo e didascalia insieme
			$tfvNext = $this->pag->listaFoto[$this->pag->count+1]->Tfv;
			$descrzioneNextUrl = $tfvNext->nome_tfv;
			if(!empty($tfvNext->didascalia_tfv)){ // Se presente anche la didascalia
				$descrzioneNextUrl .= $this->pag->urlDescriptionSymbol;
				$descrzioneNextUrl .= ucfirst($tfvNext->didascalia_tfv);
			}
			// Creo il link per puntare alla foto successiva
			$this->pag->nextUrl = new Isp_Url_Page(
										$this->pag->txt['avanti'],
										$this->pag->pageType,
										$this->pag->page,
										$nextParams,
										$descrzioneNextUrl);
			// Aggiungo l'ancora per evitare di visualizzare foto a metˆ schermo
			$this->pag->nextUrl->path .= "#".$this->anchorName;
										
			// Numbered Urls (es. link pag.5, 6, 7..)
			$this->pag->countNextUrl = clone $this->pag->nextUrl;
			$this->pag->countNextUrl->title = $this->pag->count + 2;
		}else{
			$this->pag->nextUrl = null;
			$this->pag->countNextUrl = null;
		}
		
		// --- BACK PHOTO URL --- //
		if($this->pag->count > 0){ // Se non  la prima foto
			// Copio i parametri							
			$backParams = $this->pag->paramsArray;
			// Assegno l'id alla foto precedente
			$backParams['idFotovideo'] = $this->pag->listaFoto[$this->pag->count-1]
																->Fotovideo->id_fotovideo;
			// Descrizione link fatta da titolo e didascalia insieme
			$tfvBack = $this->pag->listaFoto[$this->pag->count-1]->Tfv;
			$descrzioneBackUrl = $tfvBack->nome_tfv;
			if(!empty($tfvBack->didascalia_tfv)){
				$descrzioneBackUrl .= $this->pag->urlDescriptionSymbol;
				$descrzioneBackUrl .= ucfirst($tfvBack->didascalia_tfv);
			}
			// Creo il link per puntare alla foto precedente
			$this->pag->backUrl = new Isp_Url_Page(
										$this->pag->txt['indietro'],
										$this->pag->pageType,
										$this->pag->page,
										$backParams,
										$descrzioneBackUrl);	
			// Aggiungo l'ancora per evitare di visualizzare foto a metˆ schermo
			$this->pag->backUrl->path .= "#".$this->anchorName;
																		
			// Numbered Urls
			$this->pag->countBackUrl = clone $this->pag->backUrl;
			$this->pag->countBackUrl->title = $this->pag->count;				
		}else{
			$this->pag->backUrl = null;
			$this->pag->countBackUrl = null;
		}
		
	
		// --- LAST PHOTO URL --- //
		// Copio i parametri							
		$lastParams = $this->pag->paramsArray;
		// Assegno l'id all' ultima foto
		$lastParams['idFotovideo'] = $this->pag->listaFoto[sizeof($this->pag->listaFoto)-1]
														->Fotovideo->id_fotovideo;
		// Descrizione link fatta da titolo e didascalia insieme
		$tfvLast = $this->pag->listaFoto[sizeof($this->pag->listaFoto)-1]->Tfv;
		$descrzioneLastUrl = $tfvLast->nome_tfv;
		if(!empty($tfvLast->didascalia_tfv)){ // Se presente anche la didascalia
			$descrzioneLastUrl .= $this->pag->urlDescriptionSymbol ;
			$descrzioneLastUrl .= ucfirst($tfvLast->didascalia_tfv);			
		}
		// Creo il link per puntare all'ultima foto								
		$this->pag->lastUrl = new Isp_Url_Page(sizeof($this->pag->listaFoto),
									$this->pag->pageType,
									$this->pag->page,
									$lastParams,
									$descrzioneLastUrl);
		// Aggiungo l'ancora per evitare di visualizzare foto a metˆ schermo
		$this->pag->lastUrl->path .= "#".$this->anchorName;
																							
																
		// --- CURRENT PHOTO URL --- //
		// Creo il link della foto corrente da visualizzare
		$this->pag->urlPhoto = new Isp_Url_Photo(	
										$this->pag->schedaFoto->Fotovideo->id_fotovideo,
										$this->pag->fotoSize,
										$this->pag->schedaFoto->Tfv->nome_tfv,
										$this->pag->schedaFoto->Tfv->didascalia_tfv);															
	}
}

?>