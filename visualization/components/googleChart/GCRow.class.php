<?php

/**
 * GCRow short summary.
 *
 * GCRow description.
 *
 * @version 1.0
 * @author Filip
 */
class GCRow
{
    private $C;
    
    /**
     * Google chart row constructor
     */
    public function __construct()   {
        $this->C = array();
    }
    
    /**
     * Add cell to row
     * @param mixed $c 
     */
    public function AddCell($c) {
        $this->C[] = $c;
    }
    
    /**
     * Export object to allow serialization
     * @return mixed
     */
    public function ExportObject()  {
    
    }
}
