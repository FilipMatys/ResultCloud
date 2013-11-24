<?php
/* 
 * File: Test.php
 * Author: Filip Matys
 * About: Implements test class model
 */

include_once "TestInput.php";
include_once "../base/IndexedEntity.php";

class Test extends IndexedEntity  {
    // Test name
    public $Source;
    // Test input
    public $TestInput;
    
    // Test constructor
    public function __construct() {
        $this->TestInput = new TestInput();
        $this->Results = array();
    }
}

?>