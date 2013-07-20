<?
Isp_Loader::loadClass('Isp_View_Page');

class MediaTestPage extends Isp_View_Page{
	private $txt;
	
	// test method: to delete..
	public function setMessage($txt){
		$this->txt = $txt;
	}
	
	// Page structure
	public function skeleton(){
		$body['upload'] = "Form di upload, componente media::<br>";
		$body['input txt'] = $this->txt;
		
		return $body;
	}
	
	
}
?>
