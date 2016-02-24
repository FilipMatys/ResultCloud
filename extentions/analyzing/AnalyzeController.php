<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);

class AnalyzeController
{
    public function Analyze(SubmissionTSE $submission, array $submissions, $plugin)
    {
        foreach (glob(dirname(__FILE__).DIRECTORY_SEPARATOR."analyzers".DIRECTORY_SEPARATOR."*.php") as $value) {
            include_once($value);
            $name = str_replace(dirname(__FILE__).DIRECTORY_SEPARATOR."analyzers".DIRECTORY_SEPARATOR, "",
                str_replace(".php", "", $value));
            $analyzer = new $name();
            $analyzer->Analyze($submission, $submissions, $plugin);
        }
    }
}
