<?php

/**
 * DifferenceVisualization short summary.
 *
 * DifferenceVisualization description.
 *
 * @version 1.0
 * @author Filip
 */
class DifferenceVisualization
{
    /**
     * Visualize difference submission type
     * @param mixed $submissions 
     * @param mixed $type 
     * @param mixed $meta 
     * @return mixed
     */
    public static function Visualize($submissions, $type, $meta) {
        // Choose the right data based on component type
        switch($type)   {
            // Return difference lists
            case DifferenceOverviewType::GOOGLE_CHART:
                return SystemTAP_DifferenceOverviewChart::GetDifferenceOverviewChart($submissions);
            
            case DifferenceOverviewType::VIEWLIST:
                return SystemTAP_DifferenceOverviewList::GetDifferenceOverviewLists($submissions, $meta);
                
            case SystemTAP_DifferenceOverviewType::DIFF_CONFIGURATION:
                return SystemTAP_DifferenceOverviewConfiguration::GetDifferenceOverviewConfiguration($submissions);
                
            case SystemTAP_DifferenceOverviewType::DIFF_LAST:
                return SystemTAP_DifferenceOverviewList::GetDifferenceOverviewLists($submissions, $meta, true);
            default:
                return null;
        }
    }
    
    /**
     * Get data depth based on component type
     * @param mixed $type 
     * @return mixed
     */
    public static function GetDataDepth($type)   {
        // Set data depth based on component type
        switch($type)   {
            case DifferenceOverviewType::GOOGLE_CHART:
                return DataDepth::RESULT;
                
            case DifferenceOverviewType::VIEWLIST:
                return DataDepth::RESULT;
                
            case SystemTAP_DifferenceOverviewType::DIFF_CONFIGURATION:
                return DataDepth::SUBMISSION;
            
            default:
                return DataDepth::SUBMISSION;
        }
    }
    
    /**
     * Get components for plugin
     * @return mixed
     */
    public static function GetViewComponents()   {
        return array(
                SystemTAP_DifferenceOverviewComponent::DIFF_CONFIGURATION,
                DifferenceOverviewComponent::GOOGLE_CHART,
                DifferenceOverviewComponent::VIEWLIST
            );
    }
}
