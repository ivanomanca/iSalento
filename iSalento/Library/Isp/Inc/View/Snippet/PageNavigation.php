<?
// -----PAGE NAVIGATION----- //
// SIDE BAR
Isp_Loader::loadVistaObj("Snippets","Navigation","cSideNav");
Isp_Loader::loadVistaObj("Snippets","Navigation","SideListNav");
// First left side bar
if(isset($subUrls[$currentTab])){
	$sxUrl1 = array($topTabUrls[$currentTab]); // Main Tab
	$sxUrl1 = array_merge($sxUrl1, $subUrls[$currentTab]); 		   // Subs
	$sxNav1 =  new SideListNav($sxUrl1, $colors[$currentTab]); 
}

// Altre barre
$topUrlsCopy = $topTabUrls;
$subUrlsCopy = $subUrls;
unset($topUrlsCopy[$currentTab]); // Tolgo la barra giˆ usata
unset($subUrlsCopy[$currentTab]); // Tolgo la sottobarra giˆ usata
if(isset($sxNav1)){
	$sxNavArray = array($sxNav1);			  // Array delle navigazioni
}else{
	$sxNavArray = array();
}
// Per tutte le altre tab che contengono una sottobarra
for($i=0; $i<=sizeof($subUrlsCopy);$i++){ 
	if(isset($subUrlsCopy[$i])){ // Se esiste una sottobarra
		$sxUrl = array($topUrlsCopy[$i]); // Main tab
		$sxUrl = array_merge($sxUrl, $subUrlsCopy[$i]); // Subs
		$sxNav = new SideListNav($sxUrl, $colors[$i]);
		array_push($sxNavArray, $sxNav);
	}
}
								
// Left
$sideNav = new cSideNav($sxNavArray);
// Right
$dxNav1 = new SideListNav($sxUrl, $colors[5]);
$extraNav = new cSideNav(array($dxNav1),"extra");

// LINE NAVIGATION
// Breadcrumb
Isp_Loader::loadVistaObj("Snippets","Navigation","LineNav");
$bread = new LineNav($breadUrls,">");
// Footer
// Temp line!!
$footerUrls = $topTabUrlsLower;
array_push($footerUrls, new Isp_Url_Page("Login", "Form", "FormLogin"));

$footer = new LineNav($footerUrls,"|","footer");
?>