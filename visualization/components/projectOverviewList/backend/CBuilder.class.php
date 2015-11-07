<?php
// projectOverviewList/backend/CBuilder.class.php

class CBuilder {
	// Get data for frontend
	public static function Get($data)	{
		// Load data
                TestSuiteDataService::LoadSubmissions($data->ProjectTSE, DataDepth::SUBMISSION);
        
                // Initialize list
                $projectOverviewList = new ProjectOverviewList();
                
                foreach ($data->ProjectTSE->GetSubmissions() as $submission)
                {
                        // Create new list item
                        $projectOverviewListItem = new ProjectOverviewListItem($submission);
                        // Add item to list
                        $projectOverviewList->Submissions[] = $projectOverviewListItem;
                }
                
                // Return result
                return new ValidationResult($projectOverviewList);
	}
}

?>