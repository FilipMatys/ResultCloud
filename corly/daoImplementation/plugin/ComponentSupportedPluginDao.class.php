<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_PLUGIN);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE);

/**
 * @version 1.0
 * @author Filip
 */
class ComponentSupportedPluginDao extends Database
{
    // Parent constructor
	function __construct()	{
		parent::__construct(new ComponentSupportedPlugin());
	} 
}
