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
    
    // - visualization
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
	public static function using($folder)	{
		$folder = dirname(__FILE__).DIRECTORY_SEPARATOR . $folder;
		// For each file in given folder
		foreach (glob("{$folder}/*.php") as $filename)	{
        	include_once($filename);
    	}
	}
    
    /**
     * Get chosen path
     */
    public static function path($folder, $file)    {
        return dirname(__FILE__). DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $file;
    }
}