<?

// CENTRAL PAGE
Isp_Loader::loadVistaObj("Snippets","Layout","cCentralPage");
$cPage = new cCentralPage($this->snpArray, $sideNav, $extraNav, $bread, $footer);

// WRAPPER
Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
Isp_Loader::loadVistaObj("Snippets","Meta","Doctype");
$wrap = new cWrapper(new Doctype(), $cHead, $header, $cPage, $colors[$currentTab]);
$body['wrap'] = $wrap->out();
?>