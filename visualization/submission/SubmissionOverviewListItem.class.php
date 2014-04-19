<?php

/**
 * SubmissionOverviewListItem short summary.
 *
 * SubmissionOverviewListItem description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewListItem
{
    /**
     * Category object
     * @var mixed
     */
    private $Category;
    
    /**
     * Project overview list item constructor
     */
    public function __construct($category)   {
        $this->Category = $category->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $listItem = new stdClass();
        
        // Set values
        $listItem->Category = $this->Category;
        
        // Return result
        return $listItem;
    }
}
