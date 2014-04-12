<?php
/**
 * Submission short summary.
 *
 * Submission description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionTSE
{
    private $DateTime;
    private $Categories;

    /**
     * Submission constructor
     */
    public function __construct($dateTime)   {
        $this->DateTime = $dateTime;
        $this->Categories = array();
    }
    
    /**
     * Get submission as object to save to database
     * @param mixed $projectId 
     */
    public function GetDbObject($projectId)   {
        // Init object
        $submission = new stdClass();
        // Assign values of base object
        $submission->DateTime = $this->DateTime;
        // Set parent object id (project)
        $submission->Project = $projectId;
        
        // Return object
        return $submission;
    }
    
    /**
     * Get submission date time
     */
    public function GetDateTime()   {
        return $this->DateTime;
    }
    
    /**
     * Get categories
     */
    public function GetCategories() {
        return $this->Categories;
    }
    
    /**
     * Add category to submission
     */
    public function AddCategory($category)  {
        $this->Categories[] = $category;
    }
}
