<?php

/**
 * CPAlien_SubmissionOverviewMaximum short summary.
 *
 * CPAlien_SubmissionOverviewMaximum description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_SubmissionOverviewMaximum
{
    /**
     * Get submission overview maximum
     * @param SubmissionTSE $submission 
     * @return mixed
     */
    public static function GetSubmissionOverviewMaximum(SubmissionTSE $submission) {
        // Initialize maximum object
        $maximum = new CPAlien_Maximum();
        
        // initialize properties
        $maximumCPUTimeItem = new CPAlien_MaximumItem("Maximum CPU Time");
        $minimumCPUTimeItem = new CPAlien_MaximumItem("Minimum CPU Time");
        // Memory usage
        $maximumMemUsageItem = new CPAlien_MaximumItem("Maximum Memory Usage");
        $minimumMemUsageItem = new CPAlien_MaximumItem("Minumum Memory Usage");
        // Wall time
        $maximumWallTimeItem = new CPAlien_MaximumItem("Maximum Wall Time");
        $minimumWallTimeItem = new CPAlien_MaximumItem("Minimum Wall Time");
        
        // CPU time
        $maximumCPUTime = 0;
        $minimumCPUTime = 0;
        // Memory usage
        $maximumMemUsage = 0;
        $minimumMemUsage = 0;
        // Wall time
        $maximumWallTime = 0;
        $minimumWallTime = 0;
        
        // Iterate through each category
        foreach ($submission->GetCategories() as $category) {
            // Iterate through test cases
            foreach ($category->GetTestCases() as $testCase) {
                // Iterate through results
                foreach ($testCase->GetResults() as $result) {
                    // Check for cpu time
                    if ($result->GetKey() == "cputime") {
                        // Compare maximum
                        if (floatval($result->GetValue()) > $maximumCPUTime)    {
                            $maximumCPUTimeItem->TestCase = $testCase->ExportObject();
                            $maximumCPUTime = floatval($result->GetValue());
                        }
                        // Compare minimum
                        if ($minimumCPUTime == 0 || floatval($result->GetValue()) < $minimumCPUTime)    {
                            $minimumCPUTimeItem->TestCase = $testCase->ExportObject();
                            $minimumCPUTime = floatval($result->GetValue());
                        }
                    }
                    else if ($result->GetKey() == "memUsage")   {
                        // Compare maximum
                        if (floatval($result->GetValue()) > $maximumMemUsage)    {
                            $maximumMemUsageItem->TestCase = $testCase->ExportObject();
                            $maximumMemUsage = floatval($result->GetValue());
                        }
                        // Compare minimum
                        if ($minimumMemUsage == 0 || floatval($result->GetValue()) < $minimumMemUsage)    {
                            $minimumMemUsageItem->TestCase = $testCase->ExportObject();
                            $minimumMemUsage = floatval($result->GetValue());
                        }
                    }
                    else if ($result->GetKey() == "walltime")   {
                        // Compare maximum
                        if (floatval($result->GetValue()) > $maximumWallTime)    {
                            $maximumWallTimeItem->TestCase = $testCase->ExportObject();
                            $maximumWallTime = floatval($result->GetValue());
                        }
                        // Compare minimum
                        if ($minimumWallTime == 0 || floatval($result->GetValue()) < $minimumWallTime)    {
                            $minimumWallTimeItem->TestCase = $testCase->ExportObject();
                            $minimumWallTime = floatval($result->GetValue());
                        }
                    }
                }
            }
        }
        
        // Fill object
        $maximum->MaximumCPUTime  = $maximumCPUTimeItem;
        $maximum->MinimumCPUTime = $minimumCPUTimeItem;
        $maximum->MaximumMemUsage = $maximumMemUsageItem;
        $maximum->MinimumMemUsage = $minimumMemUsageItem;
        $maximum->MaximumWallTime = $maximumWallTimeItem;
        $maximum->MinimumWallTime = $minimumWallTimeItem;
            
        // Return result
        return $maximum;
    }
}
