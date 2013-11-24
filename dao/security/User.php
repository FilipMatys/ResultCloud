<?php
/*
 *  File: user.php
 *  Author: Filip Matys
 *  About: Implements user model
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/base/IndexedEntity.php";
include_once "Name.php";

class User extends IndexedEntity  {
    // User's name
    public $Name;
    // Username
    public $Username;
    // Password
    public $Password;
    // Email
    public $Email;
    
    // Class contructor
    public function __construct()  {
        parent::__construct();
    }
}
?>