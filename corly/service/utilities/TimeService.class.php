<?php

/**
 * TimeService short summary.
 *
 * TimeService description.
 *
 * @version 1.0
 * @author Filip
 */
class TimeService
{
    /**
     * Get current date time
     * @return date time
     */
    public static function DateTime()    {
        return date("c");
    }

    /**
     * Get current date
     * @return date
     */
    public static function Date()	{
    	return date("Y-m-d");
    }


    /**
     * Get array of dates from given date to given interval. Interval
     * defines number of months 
     */
    public static function MonthIntervalArray($startDate, $interval)	{
    	// Initialize array
    	$dateInterval = array();

    	// Make dates into interval (past)
    	if ($interval < 0)	{
    		$interval++;
    		while ($interval != 0)	{
    			$dateInterval[] = date("Y-m-d", strtotime($startDate . ' '. $interval .' months'));
    			$interval++;
    		}

    		// Add start date
    		$dateInterval[] = $startDate;
    		return $dateInterval;
    	}

    	// Add start date
    	$dateInterval[] = $startDate;

    	// Make dates into interval (future)
    	$interval--;
    	while ($interval != 0)	{
    		$dateInterval[] = date("Y-m-d", strtotime($startDate . ' '. $interval .' months'));
    		$interval--;
    	}

    	// Reverse array to have dates chronologicaly
		return array_reverse($dateInterval);

    	// Return result
    	return $dateInterval; 	
    }
}
