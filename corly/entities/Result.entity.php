<?php

/**
 * Result short summary.
 *
 * Result description.
 *
 * @version 1.0
 * @author Filip
 */
class Result
{
    private $RKey;
    private $RValue;
    
    /**
     * Result constructor
     */
    public function __construct($rKey, $rValue)  {
        $this->RKey = $rKey;
        $this->RValue = $rValue;
    }
    
    /**
     * Get result key
     */
    private function GetKey()   {
        return $this->Rkey;
    }
    
    /**
     * Get result value
     */
     private function GetValue()    {
        return $this->RValue;
     }
}
