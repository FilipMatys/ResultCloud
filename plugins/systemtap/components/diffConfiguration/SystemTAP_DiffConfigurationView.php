<?php

/**
 * SystemTAP_DiffConfigurationView short summary.
 *
 * SystemTAP_DiffConfigurationView description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_DiffConfigurationView
{
    /**
     * View headers
     * @var mixed
     */
    private $Headers;
    
    /**
     * View rows
     * @var mixed
     */
    private $Rows;
    
    public function __construct()   {
        $this->Headers = array();
        $this->Rows = array();
    }
    
    /**
     * Add header to diff configuration view
     * @param mixed $header 
     */
    public function AddHeader($header) {
        $this->Headers[] = $header;
    }
    
    /**
     * Add row
     * @param SystemTAP_DiffConfigurationViewRow $row 
     */
    public function AddRow(SystemTAP_DiffConfigurationViewRow $row) {
        $this->Rows[] = $row->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $view = new stdClass();
        
        // Set values
        $view->Headers = $this->Headers;
        $view->Rows = $this->Rows;
        
        return $view;
    }
}
