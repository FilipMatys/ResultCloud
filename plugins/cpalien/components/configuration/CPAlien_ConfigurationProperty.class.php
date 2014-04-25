<?php

/**
 * CPAlien_ConfigurationProperty short summary.
 *
 * CPAlien_ConfigurationProperty description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_ConfigurationProperty
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
