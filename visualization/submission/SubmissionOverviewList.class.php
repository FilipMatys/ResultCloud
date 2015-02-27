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
    
    private $Page;
    private $ItemsCount;
    private $PageSize;
    
    /**
     * Submission overview list constructor
     */
    public function __construct()   {
        $this->Categories = array();
        $this->Page = 0;
        $this->ItemsCount = 0;
        $this->PageSize = 0;
    }
    
    /**
     * Set page 
     * @param mixed $page 
     */
    public function SetPage($page)  {
        $this->Page = $page;
    }
    
    /**
     * Set items count
     * @param mixed $itemsCount 
     */
    public function SetItemsCount($itemsCount)  {
        $this->ItemsCount = $itemsCount;
    }

    /**
     * Set page size
     * @param mixed $pageSize
     */
    public function SetPageSize($pageSize)  {
        $this->PageSize = $pageSize;
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
        
        $submissionOverviewList->Page = $this->Page;
        $submissionOverviewList->ItemsCount = $this->ItemsCount;
        $submissionOverviewList->PageSize = $this->PageSize;
        
        // return object
        return $submissionOverviewList;
    }
    
    
}
