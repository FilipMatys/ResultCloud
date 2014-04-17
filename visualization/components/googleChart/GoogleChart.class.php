<?php

/**
 * GoogleChart short summary.
 *
 * GoogleChart description.
 *
 * @version 1.0
 * @author Filip
 */
class GoogleChart
{
    private $Type;
    private $Displayed;
    private $Data;
    private $Options;
    private $Formatters;
    
    /**
     * Google Chart constructor
     */
    public function __construct()   {
    
    }
    
    /**
     * Set type of Google Chart
     * @param GCType $type 
     */
    public function setType($type)   {
        $this->Type = $type;
    }
    
    /**
     * Set Displayed value
     * @param bool $displayed 
     */
    public function setDisplayed($displayed)    {
        $this->Displayed = $displayed;
    }
    
    /**
     * Set data
     * @param mixed $data 
     */
    public function setData($data)   {
        $this->Data = $data;
    }
    
    /**
     * Set options
     * @param mixed $options 
     */
    public function setOptions($options)    {
        $this->Options = $options;
    }
    
    /**
     * Set formatters
     * @param mixed $formatters 
     */
    public function setFormatters($formatters)  {
        $this->Formatters = $formatters;
    }
}
