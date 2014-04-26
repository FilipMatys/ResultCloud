<?php

/**
 * SystemTAP_ProjectOverviewList short summary.
 *
 * SystemTAP_ProjectOverviewList description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_ProjectOverviewList
{
    /**
     * Get project overview list data for visualization
     * @param ProjectTSE $project 
     * @return mixed
     */
    public static function GetProjectOverviewList(ProjectTSE $project)    {
        // Initialize list
        $projectOverviewList = new ProjectOverviewList();
        
        foreach ($project->GetSubmissions() as $submission)
        {
            // Create new list item
            $projectOverviewListItem = new ProjectOverviewListItem($submission);
            // Add item to list
            $projectOverviewList->AddItem($projectOverviewListItem);
        }
        
        // Return result
        return $projectOverviewList->ExportObject();
    }
}
