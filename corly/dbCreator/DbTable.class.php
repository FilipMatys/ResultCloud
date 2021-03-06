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
        $this->Properties[] = $property;
    }
    
    /**
     * Get table name
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Get table definition into string
     * @return string - table definition
     */
    public function GetTableDefinition()    {
        $properties = array();
        
        // Get all properties definitions
        foreach ($this->Properties as $property)    {
            $properties[] = $property->GetPropertyDefinition();    
        }
        
        // Parse properties into string
        $sProperties = implode(", ", $properties);
        
        // Return table definition
        return "CREATE TABLE `" . $this->Name . "` ({$sProperties});"; 
    }

    public function GetAdd2TableDefinition()    {
        $properties = array();
        
        // Get all properties definitions
        foreach ($this->Properties as $property)    {
            $properties[] = $property->GetAddPropertyDefinition();    
        }
        
        // Parse properties into string
        $sProperties = implode(", ", $properties);
        
        // Return table definition
        return "ALTER TABLE `" . $this->Name . "` {$sProperties};"; 
    }
    
    /**
     * Delete table content
     */
    public function GetClearTableDefinition()   {
        return "DELETE FROM `" . $this->Name . "`";
    }
    
    /**
     * Drop column from table
     */
    public function GetDropColumnDefinition()   {
        return "ALTER TABLE `" . $this->Name . "` " . $this->Properties[0]->GetDropPropertyDefinition();
    }
}
