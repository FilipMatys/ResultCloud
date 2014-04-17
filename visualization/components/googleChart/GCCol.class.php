<?php

/**
 * GCCol short summary.
 *
 * GCCol description.
 *
 * @version 1.0
 * @author Filip
 */
class GCCol
{
    private $Id;
    private $Label;
    private $Type;
    private $P;
    
    /**
     * Google chart column constructor
     */
    public function __construct()   {
    
    }
    
    /**
     * Set column id
     * @param mixed $id 
     */
    public function setId($id) {
        $this->Id = $id;
    }
    
    /**
     * Set column label
     * @param mixed $label 
     */
    public function setLabel($label)    {
        $this->Label = $label;
    }
    
    /**
     * Set column type
     * @param mixed $type 
     */
    public function setType($type)  {
        $this->Type =  $type;
    }
    
    /**
     * Set 
     * @param mixed $p 
     */
    public function setCustom($p)   {
        $this->P = $p;
    }
    
    /**
     * Export object for serialization
     */
    public function ExportObject()  {
    
    }
}
