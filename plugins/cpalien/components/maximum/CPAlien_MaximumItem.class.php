<?php

/**
 * CPAlien_MaximumItem short summary.
 *
 * CPAlien_MaximumItem description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_MaximumItem
{
    /**
     * Item header
     * @var mixed
     */
    public $Header;
    
    /**
     * Test case
     * @var mixed
     */
    public $TestCase;
    
    /**
     * Summary of __construct
     * @param mixed $header 
     */
    public function __construct($header = "")   {
        $this->Header = $header;
    }
}
