<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);

class RevisionChangeFlagSummary
{
    const HAS_CHANGE = 1;
    const NO_CHANGE = 0;

    public function Summarize(SubmissionTSE $submissionTSE) {
        // Init validation
        $validation = new ValidationResult(array());
        
        // Check if submission has sequence number set
        if ($submissionTSE->GetSequenceNumber() == 0)
            return $validation;

        // Try to get submission before
        $previousTSE = TestSuiteDataService::GetPreviousRevision($submissionTSE, DataDepth::RESULT);

        // Compute for previous
        $validation->Data = array_merge($this->Compute($previousTSE, $submissionTSE), $validation->Data);

        // Try to get submission after and free memory
        $previousTSE = null;
        $nextTSE = TestSuiteDataService::GetNextRevision($submissionTSE, DataDepth::RESULT);

        // Compute for next
        $validation->Data = array_merge($this->Compute($submissionTSE, $nextTSE), $validation->Data);

        // Return validation
        return $validation;
    }

    /**
     * Compute summary for next submission
     * @access private
     * @param SubmissionTSE previous submission
     * @param SubmissionTSE next submission
     * @return RevisionChangeFlagSummaryEntity[] result
     */
    private function Compute(SubmissionTSE $previousTSE = null, SubmissionTSE $nextTSE = null)  {
        // If there is no next submission, return empty array
        if (is_null($nextTSE) || is_null($previousTSE)) 
            return array();

        // Load needed data
        TestSuiteDataService::LoadCategories($previousTSE, DataDepth::RESULT);
        TestSuiteDataService::LoadCategories($nextTSE, DataDepth::RESULT);

        // Delete old data for 'next' submission
        $this->DeleteOldDataIfExist($nextTSE);

        // Get categories of next submission
        $nextCategories = $nextTSE->GetCategories();

        // Init result
        $revisionChangeFlags = [];

        // Iterate through categories and compare to previous
        foreach ($nextCategories as $category)
        {
            // Get previous category
            $prevCategory = $previousTSE->GetCategoryByName($category->GetName());
            
            // Iterate through test cases
            foreach ($category->GetTestCases() as $testCase)
            {
                // Prepare entity to be filled
                $revisionChangeFlag = new RevisionChangeFlagSummaryEntity();
                $revisionChangeFlag->TestCase = $testCase->GetId();
                $revisionChangeFlag->Submission = $nextTSE->GetId();
                $revisionChangeFlag->Changed = self::NO_CHANGE;

                // Check if previous submission has the category
                // Info: We need to check it, because we need to create 
                // summary entity for each new test case
                if (is_null($prevCategory)) {
                    $revisionChangeFlag->Changed = self::HAS_CHANGE;
                    $revisionChangeFlags[] = $revisionChangeFlag;
                    continue;
                }

                // Get test case from previous submission
                $prevTestCase = $prevCategory->GetTestCaseByName($testCase->GetName());

                // Check if previous submission has the test case
                if (is_null($prevTestCase)) {
                    $revisionChangeFlag->Changed = self::HAS_CHANGE;
                    $revisionChangeFlags[] = $revisionChangeFlag;
                    continue;
                }

                // Check if there is a change
                $revisionChangeFlag->Changed = $this->CompareTestCases($prevTestCase, $testCase);

                // Add result to result list
                $revisionChangeFlags[] = $revisionChangeFlag;
            }
        }

        // Return result
        return $revisionChangeFlags;
    }

    private function CompareTestCases($prevTestCase, $nextTestCase)
    {
        // Get results
        $nextTextCaseResults = $nextTestCase->GetResults();
        $prevTestCaseResults = $prevTestCase->GetResults();

        // Check lengths
        if (count($nextTextCaseResults) != count($prevTestCaseResults))
            return self::HAS_CHANGE;

        // Iterate through results of the next test case
        foreach ($nextTextCaseResults as $testCaseResult)
        {
        	// Get the same result by key from previous test case
            $prevResult = $prevTestCase->GetResultByKey($testCaseResult->GetKey());

            // If there is none, return change
            if (is_null($prevResult))
                return self::HAS_CHANGE;

            // Compare values
            if ($prevResult->GetValue() != $testCaseResult->GetValue())
                return self::HAS_CHANGE;
        }
        
        // All passed, so there is no change
        return self::NO_CHANGE;
    }

    /**
     * Delete old data of given submission
     * @access private
     * @param SubmissionTSE submission
     */
    private function DeleteOldDataIfExist(SubmissionTSE $submissionTSE)    {
        // Save summarize data
        $summarizationEntityHandler = DbUtil::GetEntityHandler(new RevisionChangeFlagSummary());

        // Check if table exists
        if ($summarizationEntityHandler->Check() == 0) {
            // There is no need to delete previous data
            return;
        }

        // Delete data
        $summarizationEntityHandler->DeleteFilteredList(QueryParameter::Where('Submission', $submissionTSE->GetId()));
    }
}

class RevisionChangeFlagSummaryEntity {
    public $Changed;
    public $TestCase;
    public $Submission;
}

?>