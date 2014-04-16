<?php

/**
 * GCCell short summary.
 *
 * GCCell description.
 *
 * @version 1.0
 * @author Filip
 */
class GCCell
{
    private $V;
    private $F;
    private $P;
    
    /**
     * Google chart cell constructor
     */
    public function __construct()   {
    
    }
    
    /**
     * Set cell value
     * @param mixed $v 
     */
    public function setValue($v)    {
        $this->V = $v;
    }
    
    /**
     * Set cell formated value
     * @param mixed $f 
     */
    public function setFormattedValue($f)   {
        $this->F = $f;
    }
    
    /**
     * Set custom formatting for value
     * @param mixed $p 
     */
    public function setCustom($p)   {
        $this->P = $p;
    }
    
    /**
     * Export object for serialization
     * @return mixed  Exported object
     */
    public function ExportObject()  {
        
    }
}
