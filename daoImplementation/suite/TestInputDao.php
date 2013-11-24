<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestInputDao
 *
 * @author Filip Matys
 */
class TestInputDao extends Database {
    //put your code here
    function __construct() {
        parent::__construct(new TestInput());
    }
}
