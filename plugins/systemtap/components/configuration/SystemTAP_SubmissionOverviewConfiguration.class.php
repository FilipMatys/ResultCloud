<?php

/**
 * SystemTAP_SubmissionOverviewConfiguration short summary.
 *
 * SystemTAP_SubmissionOverviewConfiguration description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_SubmissionOverviewConfigurationView
{
    /**
     * Get submission overview configuration
     * @param SubmissionTSE $submission 
     * @return mixed
     */
    public static function GetSubmissionOverviewConfigurationView(SubmissionTSE $submission)   {
        // Get entity handler
        $configurationHandler = DbUtil::GetEntityHandler(new SystemTAP_Configuration);
        // Load system info for given submission
        $lConfiguration = $configurationHandler->GetFilteredList(QueryParameter::Where('DateTime', $submission->GetDateTime()));
        
        // Return result
        return new SystemTAP_ConfigurationView($lConfiguration->Single());
    }
}
