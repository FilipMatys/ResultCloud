<?php

/**
 * DbType short summary.
 *
 * DbType description.
 *
 * @version 1.0
 * @author Filip
 */
class DbType
{
    /**
     * Get type of double
     */
    public static function Double()  {
        return "double";
    }
    
    /**
     * Get type of varchar with given length
     * @param length: varchar length
     */
    public static function Varchar($length)  {
        return "varchar({$length})";
    }
    
    /**
     * Get type of longtext
     */
    public static function LongText()  {
        return "longtext";
    }
}
