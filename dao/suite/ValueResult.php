<?php
/* 
 * File: ValueResult.php
 * Author: Filip Matys
 * About: Implements value result class model
 */

include_once "Result.php";
include_once "../base/IndexedEntity.php";

class ValueResult extends IndexedEntity   {
    // Value
    public $Value;
    // Value type
    public $ValueType;
    // Parent result
    public $Result;
    
    // Value result constructor
    public function __construct() {
        parent::__construct();
    }   
}

?>

