<?php
/**
 * DbDatabase short summary.
 *
 * DbDatabase description.
 *
 * @version 1.0
 * @author Filip
 */
class DbDatabase
{
    // Database name
    private $Name;
    
    // Tables
    private $Tables;
    
    /**
     * Database constructor
     * @param name: Database name
     */
    public function __construct($name)   {
        // Set database name
        $this->Name = $name;
        
        // Init database properties
        $this->Tables = array();
    }
    
    /**
     * Database constructor
     * @param table: database table
     */
    public function AddTable($table)   {
        // Add table to database
        $this->Tables[] = $table;
    }
    
    /**
     * Get database name
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Get database tables
     */
    public function GetTables() {
        return $this->Tables;
    }
        
}
