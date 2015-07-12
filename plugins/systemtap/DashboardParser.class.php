<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::usingProject(dirname(__FILE__));

/**
 * DashboardParser
 * Updates data for dashboard
 */
class DashboardParser {

	/**
	 * Process two submissions. Count testcase states
     * due to last imported submission
	 * @param mixed $submissions
	 * @return array
	 */
	public static function ParseSubmissions($submissions)	{
		// No submissions found, so leave
		if (count($submissions) == 0)
			return array();

        // Only one was found, so we are parsing first submission
        if (count($submissions) == 1)
            return self::ParseFirst($submissions[0]);

        // Compare the two submissions
		return self::Parse($submissions);
	}

    /**
     * Summary of Parse
     * @param mixed $submissions
     */
    private static function Parse($submissions) {
        // Iterate through categories
        $categories = $submissions[0]->GetCategories();
        foreach ($categories as &$category)
        {
            // Get previous category
            $prevCategory = $submissions[1]->GetCategoryByName($category->GetName());

            // Iterate through test cases
            $testcases = $category->GetTestCases();
            foreach ($testcases as &$testCase)
            {
		// Get basic status for test case
                $testCase->SetStatus(self::GetTestCaseStatus($testCase));

                // Check status, if neutral, keep going, if not, compare
                if ($testCase->GetStatus() != SystemTAP_TestCaseStatus::NEUTRAL)
                    $testCase->SetStatus(self::CompareTwoTestCases($testCase, $prevCategory->GetTestCaseByName($testCase->GetName())));
            }
        }

        // Return submissions
        return $submissions;
    }

    /**
     * Compare two test cases and get status for new one
     * @param mixed $new
     * @param mixed $old
     * @return int
     */
    private static function CompareTwoTestCases($new, $old) {
        // Check if there is any old one
        if (is_null($old))
            return $new->GetStatus();

        // If fix was made
        if ($new->GetStatus() == SystemTAP_TestCaseStatus::STAYS_POSITIVE) {
            // Check old one
            if ($old->GetStatus() == SystemTAP_TestCaseStatus::FIX || $new->GetStatus() == SystemTAP_TestCaseStatus::STAYS_POSITIVE)
                return SystemTAP_TestCaseStatus::STAYS_POSITIVE;
            else
                return SystemTAP_TestCaseStatus::FIX;
        }
        // Regression
        else if ($new->GetStatus() == SystemTAP_TestCaseStatus::REGRESSION) {
            // First, get all bad results from each test case
            $oldBadResults = self::GetBadResults($old);
            $newBadResults = self::GetBadResults($new);

            // Get difference to new one
            $newDifference = array_diff($newBadResults, $oldBadResults);

            // New errors
            if (count($newDifference) > 0)
                return SystemTAP_TestCaseStatus::REGRESSION;

            // Get difference to old one
            $oldDifference = array_diff($oldBadResults, $newBadResults);

            // There was more errors than there is now
            if (count($oldDifference) > 0)
                return SystemTAP_TestCaseStatus::PARTIAL_FIXES;

            // Return stays buggy
            return SystemTAP_TestCaseStatus::STAYS_BUGGY;
        }
        // Wierd
        else {
            return SystemTAP_TestCaseStatus::NEUTRAL;
        }
    }

    /**
     * Get bad results from test case
     * @param mixed $testCase
     * @return array
     */
    private static function GetBadResults($testCase)    {
        // Init array
        $badResults = array();

        //Iterate through results
        $results =$testCase->GetResults(); 
        foreach ($results as $result)
        {
            // Check value
		switch ($result->GetValue())    {
                // Catch errors
                case SystemTAP_StatusValue::ERROR:
                case SystemTAP_StatusValue::FAIL:
                    $badResults[] = $result->GetKey();
                    break;

                // Ignore
                default:
                    break;
            }
        }

        // Return result
        return $badResults;
    }

    /**
     * Summary of ParseFirst
     * @param mixed $submission
     * @return mixed $submissions
     */
    private static function ParseFirst(SubmissionTSE $submission) {
        // Get all categories
        $categories = $submission->GetCategories();
        foreach ($categories as &$category)
        {
		// Now get all test cases
        $testcases = $category->GetTestCases(); 
            foreach ($testcases as &$testCase)
            {
                // Set status for given test case
		$testCase->SetStatus(self::GetTestCaseStatus($testCase));
            }
        }

        // Return result
        return array($submission);
    }

    /**
     * Get status of single test case
     * @param TestCaseTSE $testCase
     * @return mixed status
     */
    private static function GetTestCaseStatus(TestCaseTSE $testCase)   {
        // Init status to default value
        $status = SystemTAP_TestCaseStatus::STAYS_POSITIVE;

        // Check each result
        $results =$testCase->GetResults();
        foreach ($results as $result)
        {
            // Check result value
		switch ($result->GetValue())
            {
                // Neutral result
		case SystemTAP_StatusValue::UNSUPPORTED:
                case SystemTAP_StatusValue::UNTESTED:
                    // Set status to be neutral
                    $status = SystemTAP_TestCaseStatus::NEUTRAL;
                    break;

                // Fail or error
                case SystemTAP_StatusValue::ERROR:
                case SystemTAP_StatusValue::FAIL:
                    // Set status to be fail
                    return SystemTAP_TestCaseStatus::STAYS_BUGGY;

                // Not wrong or neutral result
                default:
                    continue;
            }
        }

        // Return status
        return $status;
    }
}

?>