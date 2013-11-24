<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of QueryParameter
 *
 * @author Filip
 */
class QueryParameter {
    //put your code here
    public static function Where($property, $value) {
        return new Parameter('WHERE '.$property."=?",$value);     
    }
}

/**
 * 
 */
class Parameter {
    public $Condition;
    public $Value;
    
    function __construct($condition, $value) {
        $this->Condition = $condition;
        $this->Value = $value;
    }
}


