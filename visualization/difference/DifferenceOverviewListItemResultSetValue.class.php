<?php

/**
 * DifferenceOverviewListItemResultSetValue short summary.
 *
 * DifferenceOverviewListItemResultSetValue description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverviewListItemResultSetValue
{
    /**
     * Results value
     * @var mixed
     */
    private $Value;
    
    /**
     * Results style
     * @var mixed
     */
    private $Style;
    
    /**
     * Difference overview list item resultset value
     */
    public function __construct($value = "", $style = "")   {
        $this->Value = $value;
        $this->Style = $style;
    }
    
    /**
     * Set value
     * @param mixed $value 
     */
    public function SetValue($value)    {
        $this->Value =$value;
    }
    
    /**
     * Set style
     * @param mixed $style 
     */
    public function SetStyle($style)    {
        $this->Style = $style;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object 
        $value = new stdClass();
        // Set values
        $value->Value = $this->Value;
        $value->Style = $this->Style;
        // Return result
        return $value;
    }
}
