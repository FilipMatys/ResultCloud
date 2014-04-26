<?php

/**
 * ProjectVisualisation short summary.
 *
 * ProjectVisualisation description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectVisualization
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
            case ProjectOverviewType::GOOGLE_CHART:
                return DataDepth::RESULT;
            
            case ProjectOverviewType::VIEWLIST:
                return DataDepth::SUBMISSION;
                
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
                ProjectOverviewComponent::GOOGLE_CHART,
                ProjectOverviewComponent::VIEWLIST
            );
    }
    
    /**
     * Visualize project detail
     * @param ProjectTSE $project 
     * @return mixed
     */
    public static function Visualize(ProjectTSE $project, $type)   {
        // Get view based on type
        switch ($type)  {
            // Get google chart
            case ProjectOverviewType::GOOGLE_CHART:
                return SystemTAP_ProjectOverviewChart::GetProjectOverviewChart($project);
                
            // Get list view
            case ProjectOverviewType::VIEWLIST:
                return SystemTAP_ProjectOverviewList::GetProjectOverviewList($project);
            
            // Return null if type was not found    
            default:
                return null;
        }
    }
}
