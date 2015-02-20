<?php 

class PaginatedTSE {
	protected $Page;
	protected $TotalCount;


    /**
     * Get page
     * @return page
     */
    public function GetPage()   {
        return $Page;
    }

    /**
     * Set page
     * @param page
     */
    public function SetPage($page)   {
        $this->Page = $page;
    }

    /**
     * Get total count
     * @return total count
     */
    public function GetTotalCount()  {
        return $this->TotalCount;
    }

    /**
     * Set total count
     * @param totalCount
     */
    public function SetTotalCount($totalCount)	{
    	$this->TotalCount = $totalCount;
    }
}


?>