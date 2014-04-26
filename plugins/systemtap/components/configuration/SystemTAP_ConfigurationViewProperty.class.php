<?php

/**
 * SystemTAP_ConfigurationProperty short summary.
 *
 * SystemTAP_ConfigurationProperty description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_ConfigurationViewProperty
{
    /**
     * Key
     * @var mixed
     */
    public $Key;
    
    /**
     * Value
     * @var mixed
     */
    public $Value;
    
    /**
     * Property constructor
     * @param mixed $key 
     * @param mixed $value 
     */
    public function __construct($key, $value)   {
        $this->Key = $key;
        $this->Value = $value;
    }
}
