<?php
/**
 * File: Library.utility.php
 * Author: Filip Matys 
 */

class Library	{
	// Folder constants
	// - utilities
	const UTILITIES = "utilities";
	
	// - api
	const API = "api";
	
	// - dao
	const CORLY_DAO_BASE = "corly/dao/base";
	const CORLY_DAO_SECURITY = "corly/dao/security";
	const CORLY_DAO_STAT = "corly/dao/stat";
    const CORLY_DAO_PLUGIN = "corly/dao/plugin";
    const CORLY_DAO_SUITE = "corly/dao/suite";
    const CORLY_DAO_APPLICATION = "corly/dao/application";
	
	// - dao implementation
	const CORLY_DAO_IMPLEMENTATION_BASE = "corly/daoImplementation/base";
	const CORLY_DAO_IMPLEMENTATION_SECURITY = "corly/daoImplementation/security";
    const CORLY_DAO_IMPLEMENTATION_PLUGIN = "corly/daoImplementation/plugin";
    const CORLY_DAO_IMPLEMENTATION_SUITE = "corly/daoImplementation/suite";

    // db create
    const CORLY_DBCREATE = "corly/dbCreator";
    
    // installation
    const CORLY_INSTALLATION = "corly/installation";
    
	// - service
	const CORLY_SERVICE_SECURITY = "corly/service/security";
    const CORLY_SERVICE_IMPORT = "corly/service/import";
    const CORLY_SERVICE_PLUGIN = "corly/service/plugin";
    const CORLY_SERVICE_SUITE = "corly/service/suite";
    const CORLY_SERVICE_INSTALLATION = "corly/service/installation";
    const CORLY_SERVICE_APPLICATION = "corly/service/application";
    const CORLY_SERVICE_SESSION = "corly/service/session";
    const CORLY_SERVICE_UTILITIES = "corly/service/utilities";
    
    // - visualization
    const VISUALIZATION = "visualization";
    const VISUALIZATION_DIFFERENCE = "visualization/difference";
    const VISUALIZATION_PROJECT = "visualization/project";
    const VISUALIZATION_SUBMISSION = "visualization/submission";
    
    // - visualization components
    const VISUALIZATION_COMPONENT_GOOGLECHART = "visualization/components/googleChart";

    // - entities
    const CORLY_ENTITIES = "corly/entities";
    
    // Plugins
    const PLUGINS = "plugins";
  
	/**
	 * Include files of given folder
	 */
	public static function using($folder, $files = array())	{
		$folder = dirname(__FILE__).DIRECTORY_SEPARATOR . $folder;
		// For each file in given folder
        if (empty($files)) {
            $files = glob("{$folder}/*.php");
        }
        else {
            // Only selected files
            array_walk($files, array('Library', 'AddFolder'), $folder);
        }
		foreach ($files as $filename)	{
            if (is_file($filename))
        	   include_once($filename);
    	}
	}
    public static function AddFolder(&$item, $key, $folder) {
        $item = $folder."/".$item;
    }
    /**
     * Include file of given project folder
     * @param mixed $projectDirectoryName 
     */
    public static function usingProject($projectDirectoryName)   {
        Library::usingAll($projectDirectoryName);        
    }    
    
    /**
     * Include all files in all subfolders
     * @param mixed $path 
     */
    private static function usingAll($path)    {
        // Create recursive iterator
        $directory = new RecursiveDirectoryIterator($path);
        $iterator = new RecursiveIteratorIterator($directory);
        $regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
        // Include all php files
        foreach ($regex as $file) {
            include_once(array_values($file)[0]);
        }
    }
    
    /**
     * Include all vizualization components
     */
    public static function usingVisualization()    {
        Library::using(Library::VISUALIZATION);
        Library::usingAll(dirname(__FILE__).DIRECTORY_SEPARATOR . Library::VISUALIZATION);
    }
    
    /**
     * Get chosen path
     */
    public static function path($folder, $file)    {
        return dirname(__FILE__). DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file;
    }
}