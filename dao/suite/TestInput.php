<?php
/* 
 * File: TestInput.php
 * Author: Filip Matys
 * About: Implements test input class model
 */

include_once "TestSuite.php";
include_once "Test.php";
include_once "../base/IndexedEntity.php";

class TestInput extends IndexedEntity {
    // Date of test import
    public $Date;
    // Parent suite
    public $TestSuite;
    
    // Test input constructor
    public function __construct() {
        parent::__construct();
    }
}

?>
