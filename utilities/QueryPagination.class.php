<?php
/**
 * Description of QueryParameter
 *
 * @author Filip Matys
 */

class QueryPagination {

    private $Page;
    private $PageSize;
    private $Order;

    /**
     * Query pagination constructor
     * @param page - page to get
     * @param page size
     * @param order - asc/desc
     */
    public function __construct($page, $pageSize, $order)   {
        $this->Page = $page;
        $this->PageSize = $pageSize;
        $this->Order = $order;
    }

    /**
     * Get page
     */
    public function GetPage()   {
        return $this->Page;
    }

    /**
     * Get page size
     */
    public function GetPageSize()   {
        return $this->PageSize;
    }

    /**
     *
     */
    public function GetOrder()  {
        return $this->Order;
    }
}


