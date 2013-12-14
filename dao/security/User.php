<?php
/*
 *  File: user.php
 *  Author: Filip Matys
 *  About: Implements user model
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/base/IndexedEntity.php";
include_once "Name.php";

class User extends IndexedEntity  {
    // Username
    public $Username;
    // Password
    public $Password;
    // Email
    public $Email;
    // User's name
    public $Name;
    
    // Class contructor
    public function __construct()  {
        parent::__construct();
    }
}
?>