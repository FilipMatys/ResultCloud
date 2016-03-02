<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class AnalyzeController
{
    public function analyze(SubmissionTSE $submission, LINQ $submissionList, $plugin)
    {
        $validation = new ValidationResult(array());
        foreach (glob(dirname(__FILE__).DIRECTORY_SEPARATOR."analyzers".DIRECTORY_SEPARATOR."*.php") as $value) {
            include_once($value);
            $name = str_replace(dirname(__FILE__).DIRECTORY_SEPARATOR."analyzers".DIRECTORY_SEPARATOR, "", str_replace(".php", "", $value));
            $analyzer = new $name();
            $res = $analyzer->analyze($submission, $submissions, $plugin);
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
}
