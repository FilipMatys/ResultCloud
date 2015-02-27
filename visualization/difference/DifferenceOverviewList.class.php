<?php

/**
 * DifferenceOverviewList short summary.
 *
 * DifferenceOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceOverviewList
{
    /**
     * List of list items
     * @var mixed
     */
    private $Items;
    
    /**
     * List of view headers
     * @var mixed
     */
    private $Headers;
    
    /**
     * Get name
     * @var mixed
     */
    private $Name;
    
    /**
     * Change flag
     * @var mixed
     */
    private $HasChange;
    
    /**
     * Actual page
     * @var mixed
     */
    private $Page;
    
    /**
     * Total items count
     * @var mixed
     */
    private $ItemsCount;
    
    /**
     * Pagination flag
     */
    private $Pagination;

    private $PageSize;
    
    /**
     * Difference overview list constructor
     */
    public function __construct()   {
        $this->Items = array();
        $this->Headers = array();
        $this->HasChange = false;
        $this->Pagination = false;
        $this->Page = 0;
        $this->ItemsCount = 0;
        $this->PageSize = 0;
    }
    
    /**
     * Set name
     * @param mixed $name 
     */
    public function SetName($name)   {
        $this->Name = $name;
    }

    /**
     * Set page size
     * @param mixed $pageSize
     */
    public function SetPageSize($pageSize)  {
        $this->PageSize = $pageSize;
    }

    
    /**
     * Add item to list
     * @param DifferenceOverviewListItem $differenceOverviewListItem 
     */
    public function AddItem(DifferenceOverviewListItem $differenceOverviewListItem)   {
        $this->Items[] = $differenceOverviewListItem;
        
        $this->HasChange = $differenceOverviewListItem->HasChange() ? true : $this->HasChange;
    }
    
    /**
     * Add header to list
     * @param mixed $header 
     */
    public function AddHeader($header)  {
        $this->Headers[] = $header;
    }
    
    /**
     * Set page
     * @param mixed $page 
     */
    public function SetPage($page)   {
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
     * Set pagination
     * @param mixed $pagination 
     */
    public function SetPagination($pagination)  {
        $this->Pagination = $pagination;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Initialize object
        $overviewList = new stdClass();
        // Set values
        $overviewList->Headers = $this->Headers;
        $overviewList->Items = array();
        $overviewList->Name = $this->Name;
        $overviewList->HasChange = $this->HasChange;
        $overviewList->PageSize = $this->PageSize;
        
        if (!$this->ItemsCount)
            $overviewList->ItemsCount = count($this->Items);
        else
            $overviewList->ItemsCount = $this->ItemsCount;
        
        $overviewList->Pagination = $this->Pagination;
        $overviewList->Page = $this->Page;
        foreach ($this->Items as $item)
        {
            $overviewList->Items[] = $item->ExportObject();
        }
        // Return result
        return $overviewList;
    }
}
