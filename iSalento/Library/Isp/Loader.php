<?php

/**
 * Static methods to include files in the Components folders.
 *
 * @category   Isp
 * @package    Isp_Loader
 */
class Isp_Loader
{
    /**
     * Loads a class from a PHP file.  
     * 
     * !CONVENTION: The filename must be formatted as "$class.php".
     * It will split the class name at underscores to generate a path 
     * hierarchy (e.g. "Isp_Example_Class" will map to "Isp/Example/Class.php").
     * 
     * @param string $class      - The full class name.
     * @return void
     */
    public static function loadClass($class){
		// Add Library folder
		$class = "Library_".$class;
		
    	// Not found
    	if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }
        // Autodiscover the path from the class name
        $file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        $file = $_SERVER['DOCUMENT_ROOT'].$file;
         
        if(self::_securityCheck($file)){
        	require_once $file;
        } 
    }
    
    /**
     * returns class base name
     *
     * @param string $class
     * @return string
     */
    public static function getClassName($class){
    	$array = explode("_", $class);
		return $array[sizeof($array)-1];
    }
    
    /**
     * returns package base name
     *
     * @param string $class
     * @return string
     */
    public static function getPackageName($class){
    	$package = rtrim($class, "_".Isp_Loader::getClassName($class));
    	return $package;
    }
    
    /**
	 * It makes up the snippet or pages link and includes it.
	 * 
	 * @param string $pagesOrSnippets - "Pages" or "Snippets" or "Reusable"
	 * @param string $type - the type (folder) of snippet or page
 	 * @param string $name - the file name
	 * @param string $component 
	 * @param string $template 
	 */
	public static function loadVistaObj( $pagesOrSnippets,
										 $type=null,
										 $class=null,
										 $component="Page",
										 $template="TemplateColors",
										 $pageFolder = null){

		// Default per le pagine								 	
		if($pagesOrSnippets == "Pages" and is_null($pageFolder)){
			if(isset($class)){
				$pageFolder = $class;
			}
		}
		$path =	self::buildVistaPath($pagesOrSnippets,
									 $type,
									 $class,
									 $component,
									 $template, 
									 $pageFolder);
		
		require_once $path;								
	}
	
	/**
	 * Ottiene la cartella della pagina (indipendentemente dalla sua 
	 * esistenza fisica sul file server)
	 *
	 * @param string $pageType
	 * @param string $pageName
	 * @param array $params
	 * @return Il percorso alla cartella della pagina
	 */
	public static function getPageFolder($pageType, $pageName, $params = null){
		
		// Converte in maiuscolo la prima lettera (convenzione)
		$pageName = ucfirst($pageName);
		$pageType = ucfirst($pageType);
			
	 	// Se ci sono dei parametri	
	 	if(isset($params)){
	 		$paramsPageName = "";
	 		// Calcola pagine pi specifiche
			// Aggiunge i parametri al nome base della pagina
		 	foreach ($params as $param => $value){
				// Aggiunge il formato "-categoria"		
				$paramsPageName .= "+$param";
				$paramsPageName.= "+$value";
				
		 	}//foreach
	 	} 

		
	 	/**
	 	 * Esegue la verifica dell'esistenza pagina + specifica
	 	 */
		$pageFolder = self::buildVistaPath("Pages", 
											$pageType);
		//$pageFolder = rtrim($pageFolder, ".php");
		//$pageFolder = rtrim($pageFolder, $pageName.".php");
		$pageFolder .= $pageName.$paramsPageName."/";

	
	 	 return $pageFolder;
		
	}
	/**
	 * Build a Page or Snippet object path.
	 * 
	 * @param string $pagesOrSnippets - "Pages" or "Snippets"
	 * @param string $type - the type (folder) of snippet or page
 	 * @param string $class - the file name
	 * @param string $component 
	 * @param string $template 
	 * @param string $relative - don't automatically use $_SERVER['DOCUMENT_ROOT'].
	 * Prepend the $relative string to the path (es. ../../).
	 * 
	 * @return string $path
	 */
	static public function buildVistaPath($pagesOrSnippets,
										 $type = null,
										 $class = null,
										 $component = "Page",
										 $template = "TemplateColors",
										 $pageFolder = null,
										 $relative = null){
		$path = "";
		
		// Relative prefix
		if(isset($relative)){
			$path .= $relative;
		}else{// Absolute path
			//$path .= $_SERVER['DOCUMENT_ROOT'];
		}
		
		$path .= "Components/$component/Views/$template/$pagesOrSnippets/";
		
		if(isset($type)){ // Add type
			$path .= "$type/";		
		}
		if(isset($class) and $pagesOrSnippets == "Snippets"){
			$path .= $class."/"; // Folder+ file name	
		}elseif (isset($pageFolder) and $pagesOrSnippets == "Pages"){
			$path .= $pageFolder."/";
		}
		
		if(isset($class)){
			$path .= $class.".php";
		}
		return $path;
	}
      
    /**
     * Ensure that filename does not contain exploits
     *
     * @param  string $filename
     * @return void
     */
    protected static function _securityCheck($filename)
    {
        /**
         * Security check
         */
        if (!preg_match('/[^a-z0-9\\/\\\\_.-]/i', $filename)) {
           return 1; 
        }
    }
    
   
    
    /**
     * Returns TRUE if the $filename is readable, or FALSE otherwise.
     * This function uses the PHP include_path, where PHP's is_readable()
     * does not.
     *
     * @param string   $filename
     * @return boolean
     *
    public static function isReadable($filename)
    {
        if (!$fh = @fopen($filename, 'r', true)) {
            return false;
        }
        @fclose($fh);
        return true;
    }
    */
    

}
