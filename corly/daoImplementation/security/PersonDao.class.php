<?php
/**
 * File: PersonDao.class.php
 * Author: Filip Matys
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_SECURITY);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE);

/**
 * Implements database operations for Person
 */
class PersonDao extends Database 	{
	// Parent constructor
	function __construct()	{
		parent::__construct(new Person());
	}
}
