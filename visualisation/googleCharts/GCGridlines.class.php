<?php

/**
 * GCGridlines short summary.
 *
 * GCGridlines description.
 *
 * @version 1.0
 * @author Filip
 */
class GCGridlines
{
    private $Count;
    
    /**
     * Google chart gridlines constructor
     */
    public function __construct()   {
    
    }
    
    /**
     * Set Google chart gridlines count
     * @param mixed $count 
     */
    public function setCount($count)  {
        $this->Count = $count;
    }
}
