<?php

/**
 * SystemTAP_DiffConfigurationViewRow short summary.
 *
 * SystemTAP_DiffConfigurationViewRow description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_DiffConfigurationViewRow
{
    /**
     * Row name
     * @var mixed
     */
    private $Name;
    
    /**
     * Row cells
     * @var mixed
     */
    private $Cells;
    
    public function __construct($name = "")   {
        $this->Cells = array();
        $this->Name = $name;
    }
    
    /**
     * Add cell
     * @param mixed $cell 
     */
    public function AddCell($cell)  {
        $this->Cells[] = $cell;
    }
    
    /**
     * Set name
     * @param mixed $name 
     */
    public function SetName($name)  {
        $this->Name = $name;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $row = new stdClass();
        
        // Set values
        $row->Cells = $this->Cells;
        $row->Name = $this->Name;
        
        return $row;
    }
}
