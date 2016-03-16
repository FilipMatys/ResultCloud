<?php
// submissionOverviewChart/backend/CBuilder.class.php

class CBuilder {
	// Get data for frontend
	public static function Get($data)	{
        // Initialize Google chart object
        $submissionOverviewChart = new OverviewChart();
        $googleChart = new GoogleChart();
        $googleChart->setType(GCType::PIE_CHART);
        
        // Assign options to chart
        $googleChart->setOptions(self::GetGCOptions());
        
        // Get data
        $googleChart->setData(self::GetGCData($data->SubmissionTSE));
        
        // Set chart as chart overview
        $submissionOverviewChart->SetChart($googleChart);
        
        // return google chart object
        return new ValidationResult($submissionOverviewChart->ExportObject());
	}
        
        
    /**
     * Get data for submission google chart
     * @param SubmissionTSE $submission 
     * @return mixed
     */
    private static function GetGCData(SubmissionTSE $submission) {
        // Initialize data
        $gcData = new GCData();
        
        $listOfValues = SummaryController::Load('ResultsSummary', $submission);
        
        // Create STATUS column
        $gcStatusCol = new GCCol();
        $gcStatusCol->setId("result");
        $gcStatusCol->setLabel("Result");
        $gcStatusCol->setType("string");
        // Add column to data set
        $gcData->AddColumn($gcStatusCol);
        
        // Create VALUE column
        $gcValueCol = new GCCol();
        $gcValueCol->setId("value");
        $gcValueCol->setLabel("Value");
        $gcValueCol->setType("number");
        // Add column to data set
        $gcData->AddColumn($gcValueCol);
        
        foreach ($listOfValues as $value) {
            // Create new row
            $gcRow = new GCRow();
            
            // Create label cell
            $gcLabelCell = new GCCell();
            $gcLabelCell->setValue($value->Name);
            // Add cell to row
            $gcRow->AddCell($gcLabelCell);
            
            // Create value cell
            $gcValueCell = new GCCell();
            $gcValueCell->setValue($value->Value);
            // Add cell to row
            $gcRow->AddCell($gcValueCell);
            
            // Add row to data
            $gcData->AddRow($gcRow);
        }
        
        // Return result
        return $gcData;
    }
    
    /**
     * Get google chart options
     * @return mixed
     */
    private static function GetGCOptions()  {
        // Create options and set all in it
        $gcOptions = new GCOptions();
        $gcOptions->setTitle("Result overview");
        $gcOptions->setDisplayOverviewHeader(false);
        
        // Return options
        return $gcOptions;
    }
}

?>