<?php
/**
 * File: Token.entity.php
 * Author: Bohdan Iakymets
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_BASE);

class Token extends IndexedEntity	{
	// Session Id
	public $TokenKey;
	// User id
	public $User;
	// Date and Time of creation in UNIX format
	public $CreationTime;
}