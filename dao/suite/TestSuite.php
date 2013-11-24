<?php
/* 
 * File: TestSuite.php
 * Author: Filip Matys
 * About: Implements test suite class model
 */

include_once "../security/User.php";
include_once "TestInput.php";
include_once "../base/IndexedEntity.php";

class TestSuite extends IndexedEntity {
    // Input format
    public $InputFormat;
    // Date of test suite creation
    public $DateCreated;
    // User that created this test suite
    public $CreatedBy;
    // Test inputs
    public $TestInputs;
    
    // Test suite constructor
    public function __construct() {
        parent::__construct();
    }
}

?>

