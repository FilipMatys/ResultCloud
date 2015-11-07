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
     * Summary of $HasChange
     * @var mixed
     */
    private $HasChange;
    
    /**
     * Difference overview list item resultset value
     */
    public function __construct($value = "", $style = "")   {
        $this->Value = $value;
        $this->Style = $style;
        
        // Set change flag
        $this->HasChange = $style != "" ? true : false; 
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
        $this->HasChange = $style != "" ? true : $this->HasChange; 
    }
    
    /**
     * Get change flag
     * @return mixed
     */
    public function HasChange() {
        return $this->HasChange;
    }
    
    /**
     * Get value
     * @return mixed
     */
    public function GetValue()  {
        return $this->Value;
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
