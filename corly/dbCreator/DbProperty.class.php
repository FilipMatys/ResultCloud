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
    // Is primary key
    private $IsPrimaryKey;
    // Is auto increment
    private $IsAutoIncrement;
    
    const NOT_NULL = " NOT NULL";
    const AUTO_INCREMENT = " AUTO_INCREMENT";
    const PRIMARY_KEY = " PRIMARY KEY";
    
    /**
     * DbProperty constructor
     * @param name: Property name
     */
    public function __construct($name)   {
        // Set property name
        $this->Name = $name;
        
        // Another properties initalizaton
        $this->IsPrimaryKey = false;
        $this->IsAutoIncrement = false;
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
    
    /**
     * Set property as primary key
     */
    public function PrimaryKey()   {
        // Set property to be primary key
        $this->IsPrimaryKey = true;
    }
    
    /**
     * Set property to auto increment
     */
     public function AutoIncrement()    {
        // Set property to auto increment
        $this->IsAutoIncrement = true;
     }
    
    /**
     * Get string representation  of property
     * @return string Property database definition
     */
    public function GetPropertyDefinition() {
        
        return $this->GetBasicPropertyDefinition();
    }

    public function GetAddPropertyDefinition() {
        
        return "ADD ".$this->GetBasicPropertyDefinition();
    }

    private function GetBasicPropertyDefinition() {
        $definition = "";
        // Set property name
        $definition .= $this->Name . " ";
        // Set property type
        $definition .= $this->TypeDeclaration;
        
        // Check if not null is set
        if (!$this->IsNull) {
            $definition .= DbProperty::NOT_NULL; 
        }
        // Check if auto increment is set
        if ($this->IsAutoIncrement) {
            $definition .= DbProperty::AUTO_INCREMENT;
        }
        // Check if primary key is set
        if ($this->IsPrimaryKey)    {
            $definition .= DbProperty::PRIMARY_KEY;
        }
        
        return $definition;
    }
}
