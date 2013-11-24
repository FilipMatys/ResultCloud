<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/base/Database.php";
/**
 * Description of NameDao
 *
 * @author Filip
 */
class NameDao extends Database {
    //put your code here
    function __construct() {
        parent::__construct(new Name());
    }
}
