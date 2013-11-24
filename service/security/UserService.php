<?php
/*
 * File: UserService.php 
 * Author: Filip Matys
 * About: Implements user service
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/security/User.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/UserDao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/NameDao.php";

class UserService   {
    private $UserService;
    private $NameService;
    
    function __construct() {
        $this->UserService = new UserDao();
        $this->NameService = new NameDao();
    }
    
    /**
     * Authorize user and return basic information
     * to keep him logged in.
     * 
     * @param User $user
     * @return Found user or null
     */
    public function AuthorizeUser(User $user) {
        return NULL;
    }
    
    /**
     * Save modified user
     * 
     * @param User $user
     * @return null
     */
    public function ModifyUser(User $user)  {
        return NULL;
    }
}

?>