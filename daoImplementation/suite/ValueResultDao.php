<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValueResultDao
 *
 * @author Filip Matys
 */
class ValueResultDao extends Database {
    //put your code here
    function __construct() {
        parent::__construct(new ValueResult());
    }
}
