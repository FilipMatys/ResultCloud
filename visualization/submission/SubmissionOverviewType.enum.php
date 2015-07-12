<?php

/**
 * SubmissionOverviewType short summary.
 *
 * SubmissionOverviewType description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionOverviewType
{
    /**
     * Basic list for data. This list is able to show data in
     * list or grouped format. Also supports pagination. In 
     * fact, it is the only way to show large amount of data
     * with the lowest performance and memory usage requirements
     */
    const VIEWLIST = "LIST";
    
    /**
     * Google chart, that allows representing data graphically
     * and user readable. Given data can be represented by
     * many different charts. These should be chosen wisely,
     * based on given data
     */
    const GOOGLE_CHART = "GOOGLE_CHART";

    /**
     * List of all available results of tests, it will be used for
     * submission filter.
     */
    const STATUSES = "STATUSES";
}
