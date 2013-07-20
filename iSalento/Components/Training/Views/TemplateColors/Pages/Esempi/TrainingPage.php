<?
Isp_Loader::loadClass('Isp_View_Page');
/**
 * This is the simplest page you can design.
 *
 */
class TrainingPage extends Isp_View_Page{
	public $nomeLoc = "";
	
	// Page structure
	public function skeleton(){
		
		$code = "<h1>Pagina proprietaria Training</h1> ";
		$code .= "La localita si chiama".$this->nomeLoc;
		
		$body['localita'] = $code;
		return $body;
	}
	
}
?>
