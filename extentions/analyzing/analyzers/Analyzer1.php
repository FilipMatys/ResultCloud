<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);

class Analyzer1
{
    const ANALYZER_ID = "analyzer1";
    public function analyze(SubmissionTSE $submission, LINQ $submissionList, $plugin)
    {
        if ($plugin == "systemtap") {
            $good = 0;
            $bad = 0;
            $strange = 0;

            $submission1 = $submissionList->Last();
            $submission2 = $submission;
            
            foreach ($submission1->GetCategories() as $category) {
                $category2 = $submission2->GetCategoryByName($category->GetName());
                if (is_null($category2)) {
                    continue;
                }
                foreach ($category->GetTestCases() as $testCase) {
                    $testCase2 = $category2->GetTestCaseByName($testCase->GetName());
                    if (is_null($testCase2)) {
                        continue;
                    }
                    foreach ($testCase->GetResults() as $result) {
                        $result2 = $testCase2->GetResultByKey($result->GetKey());
                        if (is_null($result2)) {
                            continue;
                        }
                        if ($result->GetValue() != $result2->GetValue()) {
                            if ($result->GetValue() == "PASS" &&
                                $result2->GetValue() == "FAIL") {
                                $bad++;
                            } elseif ($result->GetValue() == "FAIL" &&
                                $result2->GetValue() == "PASS" ) {
                                $good++;
                            } elseif ($result->GetValue() == "FAIL" &&
                                $result2->GetValue() == "ERROR") {
                                $strange++;
                            }
                        }
                    }
                }
            }
            $res = new stdClass();
            $res->Good = $good;
            $res->Bad = $bad;
            $res->Strange = $strange;
            $validation = new ValidationResult(array(json_encode($res)));
            return $validation;
        }
    }
}
