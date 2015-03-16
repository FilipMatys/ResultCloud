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
    private $Id;
    private $DateTime;
    private $User;
    private $ImportDateTime;
    private $Categories;
    private $Good;
    private $Bad;
    private $Strange;

    /**
     * Submission constructor
     */
    public function __construct($dateTime = "")   {
        $this->DateTime = $dateTime;
        $this->Categories = array();
    }
    
    /**
     * Get id
     * @return id
     */
    public function GetId() {
        return $this->Id;
    }
    
    /**
     * Get submission date time
     */
    public function GetDateTime()   {
        return $this->DateTime;
    }
    
    /**
     * Set import date time
     * @param mixed $time 
     */
    public function SetImportDateTime($time) {
        $this->ImportDateTime = $time;
    }
    
    /**
     * Set user
     * @param mixed $user 
     */
    public function SetUser($user)  {
        $this->User = $user;
    }
    
    /**
     * Get user
     * @return mixed
     */
    public function GetUser()   {
        return $this->User;
    }

    public function SetDiff($good, $bad, $strange) {
        $this->Good = $good;
        $this->Bad = $bad;
        $this->Strange = $strange;
    }
    
    /**
     * Get categories
     */
    public function GetCategories() {
        return $this->Categories;
    }
    
    /**
     * Get category by name
     * @param mixed $name 
     * @return mixed
     */
    public function GetCategoryByName($name)    {
        // If there is no category, return null
        if (empty($this->Categories))
            return null;
        
        // Find match in a list
        foreach ($this->Categories as $category)
        {
            // Check if name matches
            if ($category->GetName() === $name)
                return $category;
        }
        
        // If no match was found, return null
        return null;
    }
    
    /**
     * Add category to submission
     */
    public function AddCategory(CategoryTSE $category)  {
        $this->Categories[] = $category;
    }

    /**
    * Add list of categories to submission
    */
    public function AddCategories($categories)  {
        $this->Categories = $categories;
    }
    
    /**
     * Get submission as object to save to database
     * @param mixed $projectId 
     */
    public function GetDbObject($projectId)   {
        // Init object
        $submission = new stdClass();
        // Assign values of base object
        $submission->DateTime = (string)$this->DateTime;
        // Set parent object id (project)
        $submission->Project = $projectId;
        $submission->User = $this->User;
        $submission->ImportDateTime = $this->ImportDateTime;
        $submission->Good = $this->Good;
        $submission->Bad = $this->Bad;
        $submission->Strange = $this->Strange;
        
        // Return object
        return $submission;
    }
    
    /**
     * Map database object into TS entity
     * @param mixed $dbSubmission 
     */
    public function MapDbObject($dbSubmission)  {
        // Map values
        $this->Id  = $dbSubmission->Id;
        $this->DateTime = $dbSubmission->DateTime;
        $this->ImportDateTime = $dbSubmission->ImportDateTime;
        $this->Good = $dbSubmission->Good;
        $this->Bad = $dbSubmission->Bad;
        $this->Strange = $dbSubmission->Strange;
    }
    
    /**
     * Export object for serialization, strip all references
     * @return mixed
     */
    public function ExportItem()    {
        // Init object
        $submission = new stdClass();
        
        // Set values
        $submission->Id = $this->Id;
        $submission->DateTime = $this->DateTime;
        $submission->ImportDateTime = $this->ImportDateTime;
        $submission->User = $this->User;
        $submission->Good = $this->Good;
        $submission->Bad = $this->Bad;
        $submission->Strange = $this->Strange;
        
        // Return result
        return $submission;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $submission = new stdClass();
        
        // Set values
        $submission->Id = $this->Id;
        $submission->DateTime = $this->DateTime;
        $submission->Categories = array();
        
        // Export each category
        foreach ($this->Categories as $category)    {
            $submission->Categories[] = $category->ExportObject();
        }
        
        // return result
        return $submission;
    }
}
