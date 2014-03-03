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


