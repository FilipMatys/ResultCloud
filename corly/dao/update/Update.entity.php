<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_BASE);

/**
 * Update short summary.
 *
 * Update description.
 *
 * @version 1.0
 * @author Bohdan Iakymets
 */
class Update extends IndexedEntity
{
	public $Id;
	//DB Version
    public $DBVersion;
}
?>