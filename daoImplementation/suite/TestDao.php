<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestDao
 *
 * @author Filip
 */
class TestDao extends Database {
    //put your code here
    function __construct() {
        parent::__construct(new Test());
    }
}
