<?php
/**
 * File: TokenDao.class.php
 * Author: Bohdan Iakymets
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_SECURITY);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE);

/**
 * Implements database operations for Token
 */
class TokenDao extends Database 	{
	// Parent constructor
	function __construct()	{
		parent::__construct(new Token());
	}
}