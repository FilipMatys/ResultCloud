<?php
/**
 * Description of ObjectPropertyParser
 *
 * @author Filip Matys
 * @author Jiri Kratochvil
 */

class ObjectPropertyParser {
    //put your code here
    private $class;
    
    function __construct($class) {
        $this->class = $class;
    }

    /**
     * Get object properties
     * 
     * @param type $entity
     * @return type
     */
    public function getObjectProperties($entity)  {
        $properties = array();
        
        foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $properties[] = $key;
            }
        }
        return $properties;
    }
    
    /**
     * Get object properties with update
     * postfix
     * 
     * @param type $entity
     * @return string
     */
    public function getObjectPropertiesToUpdate($entity)  {
       $propertiesToUpdate = array();
        
       foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $propertiesToUpdate[] = $key.'=?';
            }
        }
        return $propertiesToUpdate; 
    }

    /**
     * Get marks number based on number 
     * of object properties
     * 
     * @param type $entity
     * @return string
     */
    public function getObjectPropertiesMarks($entity) {
       $marks = array();
        
       foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $marks[] = '?';
            }
        }
        return $marks;
    }
    
    /**
     * Get object values
     * 
     * @param type $entity
     * @return type
     */
    public function getObjectValues($entity)  {
        $values = array();
        
        foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $values[] = $value;
            }
        }
        return $values;
    }
    
    /**
     * Get type of each object value
     * 
     * @param type $entity
     * @return type
     */
    public function getObjectValuesTypes($entity)   {
        $result = '';
        foreach ($entity as $key => $value)    {
            if ($key != 'Id')   {
                $result .= $this->getValueType($value);
            }
        }
        return $result; 
    }
    
    /**
     * Get value type of given value
     * 
     * @param type $value
     * @return string
     */
    public function getValueType($value)   {
        $result = '';
        
        if (is_string($value))  {
            $result .= 's';
        }
        else    {
            $result .= 'd';
        }
        return $result;        
    }
}
