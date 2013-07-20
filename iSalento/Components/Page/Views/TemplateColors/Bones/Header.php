<?php
Isp_Loader::loadClass('Isp_View_Bones');

class Header extends Isp_View_Bones {
	
	public $topNav; 
	public $testata; 
	public $header;
	 
	public function __construct(NavigationUrls $_urls, $currentTab){
		

		Isp_Loader::loadVistaObj("Snippets","Navigation","SubNav");
		Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNavTab");
		// Top nav tabs
		$tabs = array();
		for ($i = 0; $i<sizeof($_urls->topTabUrls); $i++){
			$sub = null; 
			if(isset($_urls->subUrls[$i]) and ($currentTab != 0)){  // If a subNav bar esists
				$sub = new SubNav($_urls->subUrls[$i]);
			}
			array_push($tabs, new cTopNavTab($_urls->colors[$i], $_urls->topTabUrls[$i], $sub)); 
		}
		
		Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNav");
		$this->topNav = new cTopNav($tabs, $_urls->colors[$currentTab]);
		
		// TESTATA
		Isp_Loader::loadVistaObj("Snippets","Layout","Testata");
		$this->testata = new Testata(null, "iSalento");
		
		// HEADER
		Isp_Loader::loadVistaObj("Snippets","Layout","cHeader");
		$this->header = new cHeader($this->topNav, $this->testata);
		
	}

}
?>