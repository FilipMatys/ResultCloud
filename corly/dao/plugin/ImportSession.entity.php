<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_BASE);

/**
 * ImportSession short summary.
 *
 * ImportSession description.
 *
 * @version 1.0
 * @author Bohdan Iakymets
 */
class ImportSession extends IndexedEntity
{
	//Session id
    public $SessionId;
    //Time of creation in UNIX
    public $CreationTime;
    //User id
    public $User;
    //Plugin id
    public $Plugin;
    //Project id
    public $Project;
}
?>