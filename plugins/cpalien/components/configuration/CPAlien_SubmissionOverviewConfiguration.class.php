<?php

/**
 * CPAlien_SubmissionOverviewConfiguration short summary.
 *
 * CPAlien_SubmissionOverviewConfiguration description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_SubmissionOverviewConfiguration
{
    /**
     * Get submission overview configuration
     * @param SubmissionTSE $submission 
     * @return mixed
     */
    public static function GetSubmissionOverviewConfiguration(SubmissionTSE $submission)   {
        // Get entity handler
        $systemInfoHandler = DbUtil::GetEntityHandler(new CPAlien_SystemInfo);
        // Load system info for given submission
        $lSystemInfo = new LINQ($systemInfoHandler->GetFilteredList(QueryParameter::Where('DateTime', $submission->GetDateTime())));
        
        // Return result
        return new CPAlien_Configuration($lSystemInfo->Single());
    }
}
