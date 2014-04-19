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
        // Init object
        $row = new stdClass();
        
        // Set value
        $row->c = array();
        foreach ($this->C as $cell)
        {
            $row->c[] = $cell->ExportObject();
        }
        
        // Return result
        return $row;
    }
}
