<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);

class Analyzer1
{
    public function Analyze(SubmissionTSE $submission, array $submissions, $plugin)
    {
        if ($plugin == "systemtap") {

        }
    }
}
