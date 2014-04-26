<?php

/**
 * GLIBC_DiffSummaryCategory short summary.
 *
 * GLIBC_DiffSummaryCategory description.
 *
 * @version 1.0
 * @author Filip
 */
class GLIBC_DiffSummaryCategory
{
    // Style for 
    const BETTER = "background: #2ecc71; color: #ffffff";
    const WORSE = "background: #e74c3c; color: #ffffff";
    
    /**
     * Category name
     * @var mixed
     */
    private $Name;
    
    /**
     * Error counts for each submission
     * @var mixed
     */
    private $Counts;
    
    /**
     * Difference summary category
     * @param mixed $name 
     */
    public function __construct($name = "") {
        $this->Name = $name;
        $this->Counts = array();
    }
    
    /**
     * Set name
     * @param mixed $name 
     */
    public function SetName($name)  {
        $this->Name = $name;
    }
    
    /**
     * Add count
     * @param mixed $count 
     */
    public function AddCount(GLIBC_DiffSummaryValue $item)    {
        if (!empty($this->Counts))  {
            // Get last inserted item
            $lastInserted = $this->GetLastInsertedItem();
            // Check number of errors and set styles
            if ($item->Count > $lastInserted->Count)    {
                $item->Style = GLIBC_DiffSummaryCategory::WORSE;
            }
            else if ($item->Count < $lastInserted->Count)   {
                $item->Style = GLIBC_DiffSummaryCategory::BETTER;
            }
        }
        
        // Add to list
        $this->Counts[] = $item;
    }
    
    /**
     * Get last inserted item
     * @return GLIBC_DiffSummaryCategoryItem
     */
    private function GetLastInsertedItem()  {
        return end(array_values($this->Counts));
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $category = new stdClass();
        // Set values
        $category->Name = $this->Name;
        $category->Counts = $this->Counts;
        
        // Return object
        return $category;
    }
}
