<?php
/** Isp_Url Object */
require_once($_SERVER['DOCUMENT_ROOT']."Library/Isp/Url.php");

/**
 * Photo link object
 */
class Isp_Url_Photo extends Isp_Url{
	
	// Auto build photo path
	public $id = null;
	public $size = null;
	 // Default Photoname set in Media controller
	public $photoDefaultName = "iSalento-Lecce-Puglia"; 
	public $fileName = null;
	
	
	
	/**
	 * It builds up the Photo link object given 'id' and 'size'
	 *
	 * @param int $id - photo's id 
	 * @param string $size - photo's size
	 * @param string $title - title for human reading
	 * @param string $description - didascalia da far comparire on mouse over
	 * @param string $directPhotoPath - the complete image url (eg. folder/foto.jpg)
	 * @param string $relative - relative level (see Isp_Url)
	 */
	public function __construct($id = null, 
								$size = null, 
								$title = null, 
								$description = null, 
								$directPhotoPath = null,
								$relative = null){
		
		parent::__construct(null, $title, $description, $relative);												
		// Auto build photo path							
		if(!isset($directPhotoPath)){
			
			$this->id = $id;
			$this->size = $size;
			
			// Sostituisco gli spazi con i trattini (convenzione salvataggio foto)
			if(isset($title)){
				$this->fileName = str_replace(" ", "-", $title);
			}else{ // Default
				$this->fileName = $this->photoDefaultName;
			}	
			// Usa la descrizione della pagina target se quella in ingresso  nulla
		/*	if(!isset($description)){
				$description = $urlTarget->description;
			}*/
			parent::__construct(null, $title, $description, $relative);
			
			// Continue to build path from father
			$this->path .= "Foto/";
			$this->path .= $this->id."/".$this->size."/".$this->fileName;
			$this->path .= ".jpg";
		// Manual photo path
		}else{
			$this->path = $directPhotoPath;
		}
	}

}
?>