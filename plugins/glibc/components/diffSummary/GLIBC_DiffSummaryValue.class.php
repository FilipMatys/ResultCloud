<?php

/**
 * GLIBC_DiffSummaryCategoryItem short summary.
 *
 * GLIBC_DiffSummaryCategoryItem description.
 *
 * @version 1.0
 * @author Filip
 */
class GLIBC_DiffSummaryValue
{
    /**
     * Number of errors
     * @var mixed
     */
    public $Count;
    
    /**
     * Style for column
     * @var mixed
     */
    public $Style;
    
    /**
     * Difference summary category item
     * @param mixed $count 
     */
    public function __construct($count = 0) {
        $this->Count = $count;
        $this->Style = "";
    }
}
