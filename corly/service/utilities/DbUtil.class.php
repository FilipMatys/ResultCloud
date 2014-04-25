<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE);
Library::using(Library::UTILITIES);

/**
 * DbUtil short summary.
 *
 * DbUtil description.
 *
 * @version 1.0
 * @author Filip
 */
class DbUtil
{
    /**
     * Get entity handler
     * @param mixed $class 
     * @return mixed
     */
    public static function GetEntityHandler($class)   {
        return new CustomDao($class);
    }
}

/**
 * Class to wrap plugin entity handling
 */
class CustomDao extends Database    {
    // Parent constructor
	function __construct($class)	{
		parent::__construct($class);
	} 
}
