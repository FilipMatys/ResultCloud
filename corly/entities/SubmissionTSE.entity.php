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
    private $Categories;

    /**
     * Submission constructor
     */
    public function __construct($dateTime = "")   {
        $this->DateTime = $dateTime;
        $this->Categories = array();
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
