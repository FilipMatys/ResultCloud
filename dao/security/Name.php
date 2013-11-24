<?php
/*
 *  File: name.php
 *  Author: Filip Matys
 *  About: Implements persons name model
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/base/IndexedEntity.php";

class Name extends IndexedEntity  {
    // First name
    public $FirstName;
    // Last name
    public $LastName;
}
?>