<?php
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * It contains title and description of the page
 *
 * EXAMPLE CODE:
 * <script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ?
							"https://ssl." : "http://www.");
		document.write(unescape(	"%3Cscript src='"
											+ gaJsHost
											+ "google-analytics.com/ga.js'
											type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
		var pageTracker = _gat._getTracker("UA-9087451-1");
		pageTracker._initData();
		pageTracker._trackPageview();
	</script>
 */

class Analytics extends Isp_View_Snippet{

	public $snippetType = "Statistics";

	/**
	 * Object state
	 */
	public $title = null;
	public $description = null;
	public $format = null;

	/**
	 * Markup tags names (ids' & classes' names)
	 */
	//public $accountGoogleAnalytics = "UA-9087451-1";


	public function __construct(){

		parent::__contruct();

		// Render into father's code variable
		$this->run();
	}

	public function render(){

    	// Div page title
    	$code = "
    	<script type=\"text/javascript\">
				var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
				document.write(unescape(\"%3Cscript src='\"+gaJsHost+\"google-analytics.com/ga.js'type='text/javascript'%3E%3C/script%3E\"));
		</script>
		<script type=\"text/javascript\">
			var pageTracker = _gat._getTracker(\"UA-9087451-1\");
			pageTracker._initData();
			pageTracker._trackPageview();
		</script>";

		return $code;
	}
}
?>