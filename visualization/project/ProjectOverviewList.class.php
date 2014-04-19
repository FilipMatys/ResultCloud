<?php

/**
 * ProjectOverviewList short summary.
 *
 * ProjectOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectOverviewList
{
    /**
     * List of submissions
     * @var mixed
     */
    private $Submissions;
    
    /**
     * Project overview list constructor
     */
    public function __construct()   {
        $this->Submissions = array();
    }
    
    /**
     * Add submission to project overview list
     * @param mixed $submission 
     */
    public function AddItem($submission)  {
        $this->Submissions[] = $submission;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $projectOverviewList = new stdClass();
        
        // Set values
        $projectOverviewList->Submissions = array();
        
        // Export each submission
        foreach ($this->Submissions as $submission)
        {
            $projectOverviewList->Submissions[] = $submission->ExportObject();
        }
        
        // return object
        return $projectOverviewList;
    }
    
    
}
