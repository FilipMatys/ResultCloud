<?php

/**
 * DbProperty short summary.
 *
 * DbProperty description.
 *
 * @version 1.0
 * @author Filip
 */
class DbProperty
{
    // Property name
    private $Name;
    // Property type declaration
    private $TypeDeclaration;
    // Is nullable
    private $IsNull;
    // Default value
    private $Default;
    
    /**
     * DbProperty constructor
     * @param name: Property name
     */
    public function __construct($name)   {
        // Set property name
        $this->Name = $name;
        
        // Another properties initalizaton
        $this->IsNull = true;
        $this->Default = "";
    }
    
    /**
     * Set property type
     * @param type: Property type
     */
    public function SetType($type)   {
        // Set property type
        $this->TypeDeclaration = $type;
    }
    
    /**
     * Set default value
     * @param value: Default value
     */
    public function SetDefaultValue($value)   {
        // Set default value
        $this->Default = $value;
    }
    
    /**
     * Set property to not be null
     */
    public function NotNull()   {
        // Set null to false
        $this->IsNull = false;
    }
}
