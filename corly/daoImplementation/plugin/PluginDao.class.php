<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_SUITE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);

/**
 * PluginDao short summary.
 *
 * PluginDao description.
 *
 * @version 1.0
 * @author Filip
 */
class PluginDao extends Database
{
    // Parent constructor
	function __construct()	{
		parent::__construct(new Plugin());
	}    
}
