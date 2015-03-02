<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_UPDATE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE);

/**
 * UpdateDao short summary.
 *
 * UpdateDao description.
 *
 * @version 1.0
 * @author Bohdan Iakymets
 */
class UpdateDao extends Database
{
    // Parent constructor
	function __construct()	{
		parent::__construct(new Update());
	}    
}