<?php
/**
 * File: User.entity.php
 * Author: Filip Matys
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_BASE);

class User extends IndexedEntity	{
	// Username
	public $Username;
	// Password
	public $Password;
	// State
	public $State;
	// Date created
	public $Created;
	// FK: Person
	public $Person;
}