<?php

/**
 * SubmissionOverviewListItemCaseResult short summary.
 *
 * SubmissionOverviewListItemCaseResult description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewListItemCaseResult
{
    /**
     * Result key
     * @var mixed
     */
    private $Key;
    
    /**
     * Result value
     * @var mixed
     */
    private $Value;
    
    /**
     * Style of result
     * @var mixed
     */
    private $Style;
    
    /**
     * Submission overview list item result
     * @param ResultTSE $result 
     */
    public function __construct(ResultTSE $result)   {
        $this->Key = $result->GetKey();
        $this->Value = $result->GetValue();
        $this->Style = "";
    }
    
    /**
     * Get result key
     * @return mixed
     */
    public function GetKey()    {
        return $this->Key;
    }
    
    /**
     * Get result value
     * @return mixed
     */
    public function GetResult() {
        return $this->Value;
    }
    
    /**
     * Set result style
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
        $result = new stdClass();
        // Set values
        $result->Key = $this->Key;
        $result->Value = $this->Value;
        $result->Style = $this->Style;
        
        // Return value
        return $result;
    }
}
