<?php

/*
 * File: IndexedEntity
 * Author: Filip Matys
 * About: Indexed entity implementation
 */

abstract class IndexedEntity    {
    // Object ID
    public $Id;
    
    // Indexed entity constructor
    public function __construct($Id = 0) {
        if (!$this->Id) {
            $this->Id = $Id;
        }
    }
}

