<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ObjectPropertyParser
 *
 * @author Filip
 */
class ObjectPropertyParser {
    //put your code here
    private $class;
    
    function __construct($class) {
        $this->class = $class;
    }

    // Get properties of an object (without ID)
    public function getObjectProperties()  {
        foreach ($this->class as $key => $value)    {
            if ($key != 'Id')   {
                $properties[] = $key;
            }
        }
        return $properties;
    }
    
    // Get object properties with update postfix
    public function getObjectPropertiesToUpdate()  {
       foreach ($this->class as $key => $value)    {
            if ($key != 'Id')   {
                $propertiesToUpdate[] = $key.'=?';
            }
        }
        return $propertiesToUpdate; 
    }

    // Get as much ? marks as there is properties
    public function getObjectPropertiesMarks() {
        foreach ($this->class as $key => $value)    {
            if ($key != 'Id')   {
                $marks[] = '?';
            }
        }
        return $marks;
    }
    
    // Get values of an object (without ID)
    public function getObjectValues($entity)  {
        foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $values[] = $value;
            }
        }
        return $values;
    }
    
    public function getObjectValuesTypes($entity)   {
        $result = '';
        foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $result .= $this->getValueType($value);
            }
        }
        return $result; 
    }
    
    public function getValueType($value)   {
        if (is_string($value))  {
            $result .= 's';
        }
        else    {
            $result .= 'd';
        }
        return $result;        
    }
}
