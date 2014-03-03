<?php
/**
 * File: OfferDao.class.php
 * Author: Filip Matys
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::DAO_SECURITY);
Library::using(Library::DAO_IMPLEMENTATION_BASE);

/**
 * Implements database operations for User
 */
class UserDao extends Database 	{
	// Parent constructor
	function __construct()	{
		parent::__construct(new User());
	}
}
