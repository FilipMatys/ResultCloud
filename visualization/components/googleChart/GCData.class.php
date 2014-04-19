<?php

/**
 * GCData short summary.
 *
 * GCData description.
 *
 * @version 1.0
 * @author Filip
 */
class GCData
{
    private $Cols;
    private $Rows;
    
    /**
     * Google chart data constructor
     */
    public function __construct()   {
        $this->Cols = array();
        $this->Rows = array();
    }
    
    /**
     * Add column to Google chart data
     * @param mixed $column 
     */
    public function AddColumn($column)  {
        $this->Cols[] = $column;
    }
    
    /**
     * Add row to Google chart data
     * @param mixed $row 
     */
    public function AddRow($row)    {
        $this->Rows[] = $row;
    }
    
    /**
     * Export object to allow serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $data = new stdClass();
        
        // Set values
        $data->cols = array();
        foreach ($this->Cols as $col)
        {
            $data->cols[] = $col->ExportObject();  
        }
        
        $data->rows = array();
        foreach ($this->Rows as $row)
        {
            $data->rows[] = $row->ExportObject();
        }
        
        // Return values
        return $data;
    }
}
