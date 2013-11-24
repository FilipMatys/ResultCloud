<?php
/* 
 * File: UserDao.php
 * Author: Filip Matys
 * About: Implements basic database operations for given
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/base/Database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/security/User.php";

class UserDao extends Database  {
    // Make this USER handler
    function __construct() {
        parent::__construct(new User);
    }
}

?>