<?php
// projectOverviewList/backend/CBuilder.class.php

class CBuilder {
	// Get data for frontend
	public static function Get($data)	{
		// Load data
                TestSuiteDataService::LoadSubmissions($data->ProjectTSE, DataDepth::SUBMISSION);
                $changes = AnalyzeController::VisualizeByAnalyzer("analyzer1");
        
                // Initialize list
                $projectOverviewList = new ProjectOverviewList();
                
                foreach ($data->ProjectTSE->GetSubmissions() as $submission)
                {
                        $ch = null;
                        error_log("Submission Id ".$submission->getId());
                        if (isset($changes[$submission->getId()])) {
                                $ch = $changes[$submission->getId()];
                        }
                        // Create new list item
                        $projectOverviewListItem = new ProjectOverviewListItem($submission, $ch);
                        // Add item to list
                        $projectOverviewList->Submissions[] = $projectOverviewListItem;
                }
                
                // Return result
                return new ValidationResult($projectOverviewList);
	}
}

?>