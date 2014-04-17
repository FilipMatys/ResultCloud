<?php

/**
 * ProjectTSE short summary.
 *
 * ProjectTSE description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectTSE
{
    private $Id;
    private $Name;
    private $Author;
    private $DateCreated;
    private $Submissions;
    
    /**
     * Project test suite entity constructor
     */
    public function __construct()   {
        $this->Submissions = array();
    }
    
    /**
     * Get project name
     * @return mixed
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Get project author
     * @return mixed
     */
    public function GetAuthor() {
        return $this->Author;
    }
    
    /**
     * Get project date creation
     * @return mixed
     */
    public function GetDateCreated()    {
        return $this->DateCreated;
    }
    
    /**
     * Get project submissions
     * @return mixed
     */
    public function GetSubmissions()    {
        return $this->Submissions;
    }
    
    /**
     * Add submission to project
     * @param mixed $submission 
     */
    public function AddSubmission($submission)  {
        $this->Submissions[] = $submission;
    }
    
    /**
     * Summary of MapDbObject
     * @param mixed $dbProject 
     */
    public function MapDbObject($dbProject) {
        // Map values
        $this->Id = $dbProject->Id;
        $this->Name = $dbProject->Name;
        $this->Author = $dbProject->Author;
        $this->DateCreated = $dbProject->DateCreated;
    }
}
