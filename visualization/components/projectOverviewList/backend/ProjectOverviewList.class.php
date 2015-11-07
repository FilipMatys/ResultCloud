<?php

/**
 * ProjectOverviewList short summary.
 *
 * ProjectOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectOverviewList
{
    /**
     * List of submissions
     * @var mixed
     */
    public $Submissions;
    
    /**
     * Project overview list constructor
     */
    public function __construct()   {
        $this->Submissions = array();
    }   
}
