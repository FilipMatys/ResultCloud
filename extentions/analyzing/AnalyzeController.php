<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class AnalyzeController
{
    static private $AnalyzerList = array();
    static public function analyze(SubmissionTSE $submission, LINQ $submissionList, $plugin)
    {
        $validation = new ValidationResult(array());
        foreach (self::$AnalyzerList as $value) {
            $analyzer = new $value();
            $res = $analyzer->analyze($submission, $submissionList, $plugin);
            $validation->Append($res);
            if (!$validation->IsValid) {
                return $validation;
            }
            foreach ($res->Data as $result) {
                FactoryService::AnalyzerService()->SaveAnalyzerResults(array(new AnalyzerTSE($submission->GetId(), $analyzer::ANALYZER_ID, $result)));
            }
        }
        return $validation;
    }

    static public function VisualizeByAnalyzer($analyzerId)
    {
        // var_dump(self::$AnalyzerList);
        if (self::$AnalyzerList[$analyzerId]) {
            error_log("Workkkk");
            $a = self::$AnalyzerList[$analyzerId];
            $analyzer = new $a();
            return $analyzer->Visualize(FactoryService::AnalyzerService()->LoadResultsByAnalyzer($analyzerId));
        }
        return array();
    }

    static public function InitAnalyzers()
    {
        foreach (glob(dirname(__FILE__).DIRECTORY_SEPARATOR."analyzers".DIRECTORY_SEPARATOR."*.php") as $value) {
            include_once($value);
            $name = str_replace(dirname(__FILE__).DIRECTORY_SEPARATOR."analyzers".DIRECTORY_SEPARATOR, "", str_replace(".php", "", $value));
            self::$AnalyzerList[$name::ANALYZER_ID] = $name;
        }
    }
}

AnalyzeController::InitAnalyzers();
