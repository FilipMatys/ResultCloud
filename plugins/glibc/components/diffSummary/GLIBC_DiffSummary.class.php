<?php

/**
 * GLIBC_DiffSummary short summary.
 *
 * GLIBC_DiffSummary description.
 *
 * @version 1.0
 * @author Filip
 */
class GLIBC_DiffSummary
{
    // Style for 
    const BETTER = "background: #2ecc71; color: #ffffff";
    const WORSE = "background: #e74c3c; color: #ffffff";
    
    /**
     * Summary headers
     * @var mixed
     */
    private $Headers;
    
    /**
     * Error counts
     * @var mixed
     */
    private $Counts;
    
    /**
     * Summary Categories
     * @var mixed
     */
    private $Categories;
    
    /**
     * Diff summary constructor
     */
    public function __construct()   {
        $this->Headers = array();
        $this->Counts = array();
        
        $this->Categories = array();
    }
    
    /**
     * Add header
     * @param mixed $header 
     */
    public function AddHeader($header)  {
        $this->Headers[] = $header;
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
                $item->Style = GLIBC_DiffSummary::WORSE;
            }
            else if ($item->Count < $lastInserted->Count)   {
                $item->Style = GLIBC_DiffSummary::BETTER;
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
     * Add category
     * @param mixed $category 
     */
    public function AddCategory(GLIBC_DiffSummaryCategory $category)  {
        $this->Categories[] = $category->ExportObject();
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $diffSummary = new stdClass();
        // Set values
        $diffSummary->Headers = $this->Headers;
        $diffSummary->Counts = $this->Counts;
        $diffSummary->Categories = $this->Categories;
        
        // Return result
        return $diffSummary;
    }
}
