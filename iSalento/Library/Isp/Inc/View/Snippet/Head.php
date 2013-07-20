<?
// !OBSOLETE - usa head nella pagina
$titleMeta = "iSalento - alpha version";
$keywordsMeta = "iSalento, Salento, spiagge, mare";
$descriptionMeta = "iSalento, versione alpha test..mare, spiagge nel Salento";

// HEAD
Isp_Loader::loadVistaObj("Snippets","Meta","cHead");
Isp_Loader::loadVistaObj("Snippets","Meta","Meta");
$cHead = new cHead(new Meta($titleMeta,$keywordsMeta,$descriptionMeta));

// HEAD NELLA PAGINA!
/*
Isp_Loader::loadVistaObj("Snippets","Meta","cHead");
Isp_Loader::loadVistaObj("Snippets","Meta","Meta");
$cHead = new cHead(new Meta($this->titleMeta,
							$this->keywordsMeta,
							$this->descriptionMeta));*/
?>