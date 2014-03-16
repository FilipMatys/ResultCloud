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
	
	// - dao implementation
	const CORLY_DAO_IMPLEMENTATION_BASE = "corly/daoImplementation/base";
	const CORLY_DAO_IMPLEMENTATION_SECURITY = "corly/daoImplementation/security";

    // db create
    const COLRY_DBCREATE = "corly/dbCreator";
    
	// - service
	const CORLY_SERVICE_OFFER = "corly/service/offer";
	const CORLY_SERVICE_SECURITY = "corly/service/security";
    const CORLY_SERVICE_IMPORT = "corly/service/import";

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
}