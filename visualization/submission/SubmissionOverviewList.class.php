<?php

/**
 * SubmissionOverviewList short summary.
 *
 * SubmissionOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewList
{
    /**
     * List of categories
     * @var mixed
     */
    private $Categories;
    
    /**
     * List of view types
     * @var mixed
     */
    private $ViewTypes;
    
    /**
     * Submission overview list constructor
     */
    public function __construct()   {
        $this->Categories = array();
    }
    
    /**
     * Add category to project overview list
     * @param mixed $category 
     */
    public function AddItem($category)  {
        $this->Categories[] = $category;
    }
    
    /**
     * Add view type to submission overview
     * @param mixed $viewType 
     */
    public function AddView($viewType)  {
        $this->ViewTypes[] = $viewType;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $submissionOverviewList = new stdClass();
        
        // Set values
        $submissionOverviewList->Categories = array();
        
        // Export each category
        foreach ($this->Categories as $category)
        {
            $submissionOverviewList->Categories[] = $category->ExportObject();
        }
        $submissionOverviewList->ViewTypes = $this->ViewTypes;
        
        // return object
        return $submissionOverviewList;
    }
    
    
}
