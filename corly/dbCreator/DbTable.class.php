<?php

/**
 * DbTable short summary.
 *
 * DbTable description.
 *
 * @version 1.0
 * @author Filip Matys
 */
class DbTable
{
    // Table name
    private $Name;
    
    // Array of table properties
    private $Properties;
    
    /**
     * DbTable constructor
     * @param name: Table name
     */
    public function __construct($name) {
        // Set table name
        $this->Name = $name;
        // Initialize property array
        $this->Properties = array();
    }
    
    /**
     * Add property to table
     * @param property: Table property
     */
    public function AddProperty($property)  {
        // Add property to properties array
        $this->Properties[] = $propery;
    }
}
