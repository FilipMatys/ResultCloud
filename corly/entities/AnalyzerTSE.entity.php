<?php

/**
 * Analyzer short summary.
 *
 * Analyzer description.
 *
 * @version 1.0
 * @author Bohdan Iakymets
 */
class AnalyzerTSE
{
    private $Id;
    private $Submission;
    private $Analyzer;
    private $Result;
    
    /**
     * Analyzer constructor
     */
    public function __construct($Submission = 0, $Analyzer = "", $Result = "")
    {
        $this->Submission = $Submission;
        $this->Analyzer = $Analyzer;
        $this->Result = $Result;
        $this->Id = 0;
    }

    /**
     * Get id
     * @return id
     */
    public function GetId()
    {
        return $this->Id;
    }
    
    /**
     * Get Analyzer submission
     */
    public function GetSubmission()
    {
        return $this->Submission;
    }
    
    /**
     * Get Analyzer Result
     */
    public function GetResult()
    {
        return $this->Result;
    }
     
    /**
     * Map database object into TS entity
     * @param mixed $dbAnalyzer
     */
    public function MapDbObject($dbAnalyzer)
    {
        // Map Results
        $this->Id = $dbAnalyzer->Id;
        $this->Submission = $dbAnalyzer->Submission;
        $this->Result = $dbAnalyzer->Result;
        $this->Analyzer = $dbAnalyzer->Analyzer;
    }
     
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()
    {
        // Init object
        $analyzer = new stdClass();
        
        // Set Results
        $analyzer->Id = $this->Id;
        $analyzer->Submission = $this->Submission;
        $analyzer->Result = $this->Result;
        $analyzer->Analyzer = $this->Analyzer;
        
        // return Analyzer
        return $analyzer;
    }
     
    /**
     * Get Analyzer as object to save to database
     * @param mixed $testCaseId
     */
    public function GetDbObject()
    {
        // Init object
        $analyzer = new stdClass();
        // Set properties from base object
        $analyzer->Id = $this->Id;
        $analyzer->Submission = $this->Submission;
        $analyzer->Result = $this->Result;
        $analyzer->Analyzer = $this->Analyzer;
        
        // return Analyzer
        return $analyzer;
    }
}
