<?php

/**
 * Submission short summary.
 *
 * Submission description.
 *
 * @version 1.0
 * @author Filip
 */
class Submission
{
    private $DateTime;
    private $Categories;

    /**
     * Submission constructor
     */
    public function __construct($dateTime)   {
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
     * Add category to submission
     */
    public function AddCategory($category)  {
        $this->Categories[] = $category;
    }
}
