<?php
/**
 * Description of QueryParameter
 *
 * @author Filip Matys
 * @author Jiri Kratochvil
 */

class QueryParameter {
    /**
     * Condition WHERE column = value
     * 
     * @param type $property
     * @param type $value
     * @return \Parameter
     */
    public static function Where($property, $value) {
        return new Parameter('WHERE '.$property."=?",$value);     
    }
    
    /**
     * Condition WHERE with multiple column equations
     * @param $properties
     * @param $values
     * @return \Parameter
     */
    public static function WhereAnd($properties, $values)   {
        // Init param
        $param = 'WHERE';
        $itemsCount = count($values);

        // Create param
        for ($index = 0; $index < $itemsCount; $index++) {
            $param .= ' '.$properties[$index].'=?';
            
            if ($index < ($itemsCount - 1))
                $param .= ' AND';
        }         
        
        // Return parameter
        return new Parameter($param, $values);
    }
    
    /**
     * Custom query
     */
    public static function Query($query, $values)  {
        return new Parameter($query, $values);
    }
    
    /**
     * Condition WHERE column != value
     * 
     * @param type $property
     * @param type $value
     * @return \Parameter
     */
    public static function WhereNot($property, $value) {
        return new Parameter('WHERE '.$property."!=?",$value);     
    }

    /**
     * Condition WHERE column < value
     * 
     * @param type $property
     * @param type $value
     * @return \Parameter
     */
    public static function WhereLess($property, $value) {
        return new Parameter('WHERE '.$property."<?",$value);     
    }

    /**
     * Condition WHERE column > value
     * 
     * @param type $property
     * @param type $value
     * @return \Parameter
     */
    public static function WhereGreater($property, $value) {
        return new Parameter('WHERE '.$property.">?",$value);     
    }

    /**
     * Condition WHERE column LIKE %value%
     * 
     * @param type $property
     * @param type $value
     * @return \Parameter
     */
    public static function WhereLike($property, $value) {
        return new Parameter("WHERE ".$property." LIKE CONCAT('%', ?, '%')", $value);
    }
}

/**
 * 
 */
class Parameter {
    public $Condition;
    public $Value;
    
    function __construct($condition, $value) {
        $this->Condition = $condition;
        $this->Value = $value;
    }
}


