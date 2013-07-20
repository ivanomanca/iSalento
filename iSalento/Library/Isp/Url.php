<?php
/**
 * Link Object
 *
 * @category   Isp
 * @package    Isp_Url
 */
class Isp_Url{

	public $relative = null; 	// Relative level
	public $path;  				// String path
	public $title; 				// Description to display
	public $description = null;// Description to display

	/**
	 * Constructor
	 *
	 * @param string $path - The actual link ("/folder/file.x").
	 * @param string $title - Description to dysplay
	 * @param string $description - Description to display on mouse over
	 * @param string $relative - Pass the relative path (eg: "../../")
	 * or string "absolute" to choose the type or link
	 */
	public function __construct(	$path = null, $title = null,
											$description = null, $relative = null){
		// Relative or absolute path
		if(isset($relative) && $relative != "absolute"){
			$this->relative = $relative;
			$level = $relative;
		}elseif(isset($relative) && $relative == "absolute"){
			$level = $_SERVER['DOCUMENT_ROOT'];
		}else{
			$level = null;
		}

		$this->path = $level.$path;
		$this->title = $title;
		$this->description = $description;
	}

}
