<?php
/* 
 * File: Result.php
 * Author: Filip Matys
 * About: Implements result class model
 */

include_once "Test.php";
include_once "ValueResult.php";
include_once "../base/IndexedEntity.php";

class Result extends IndexedEntity    {
    // Test parent
    public $Test;
    // Value
    public $ValueResult;
    // Result alias
    public $Alias;
    
    // Result constructor
    public function __construct() {
        $this->ValueResult = new ValueResult();
    }
}

?>