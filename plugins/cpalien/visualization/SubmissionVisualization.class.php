<?php

/**
 * SubmissionVisualization short summary.
 *
 * SubmissionVisualization description.
 *
 * @version 1.0
 * @author Filip
 */
class SubmissionVisualization
{  
    /**
     * Get data depth based on component type
     * @param mixed $type 
     * @return mixed
     */
    public static function GetDataDepth($type)   {
        // Decide data depth
        switch($type)   {
            // Get results for google chart
            case SubmissionOverviewType::GOOGLE_CHART:
                return DataDepth::RESULT;
            
            case SubmissionOverviewType::VIEWLIST:
                return DataDepth::RESULT;
                
            case CPALIEN_SubmissionOverviewType::CONFIGURATION:
                return DataDepth::SUBMISSION;
                
            case CPALIEN_SubmissionOverviewType::MAXIMUM:
                return DataDepth::RESULT;
            
            default:
                return DataDepth::SUBMISSION;
        }
    }
    
    /**
     * Get view components for project view
     * @return mixed
     */
    public static function GetViewComponents()  {
        return array(
                CPALIEN_SubmissionOverviewComponent::CONFIGURATION,
                SubmissionOverviewComponent::GOOGLE_CHART,
                CPALIEN_SubmissionOverviewComponent::MAXIMUM,
                SubmissionOverviewComponent::VIEWLIST
            );
    }
    
    /**
     * Create submission object for visualization of given type
     * @param SubmissionTSE $submission 
     * @return mixed
     */
    public static function Visualize(SubmissionTSE $submission, $type, $meta) {
        // Get view based on demanded ty
        switch($type)   {
            // Get google chart
            case SubmissionOverviewType::GOOGLE_CHART:
                return CPAlien_SubmissionOverviewChart::GetSubmissionOverviewChart($submission);
            
            // Get view list
            case SubmissionOverviewType::VIEWLIST:
                return CPAlien_SubmissionOverviewList::GetSubmissionOverviewList($submission, $meta);
            
            // Get configuration
            case CPALIEN_SubmissionOverviewType::CONFIGURATION:
                return CPAlien_SubmissionOverviewConfiguration::GetSubmissionOverviewConfiguration($submission);
                
            // Get maximum
            case CPALIEN_SubmissionOverviewType::MAXIMUM:
                return CPAlien_SubmissionOverviewMaximum::GetSubmissionOverviewMaximum($submission);
                
            // Return null if no assigned component was found
            default:
                return null;
        }
    }
}
