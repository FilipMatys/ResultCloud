<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * Controller for summary extenstions
 */
class SummaryController
{
    /**
     * Summarize given submission
     */
    static public function Summarize(SubmissionTSE $submission)
    {
        $validation = new ValidationResult(array());
        // Get all summarizers
        foreach (glob(dirname(__FILE__).DIRECTORY_SEPARATOR."summarizers".DIRECTORY_SEPARATOR."*.php") as $value) {
            include_once($value);

            // Get name of the class
            $name = str_replace(dirname(__FILE__).DIRECTORY_SEPARATOR."summarizers".DIRECTORY_SEPARATOR, "", str_replace(".php", "", $value));
            $summarizer = new $name();

            // Use the summarizer
            $res = $summarizer->Summarize($submission);
            $validation->Append($res);

            // Check if finished with valid result
            if (!$validation->IsValid) {
                return $validation;
            }

            // Save data
            self::Save($name, $res->Data);
        }

        // Return validation
        return $validation;
    }

    private static function Save($name, $data) {
        // Save summarize data
        $summarizationEntityHandler = DbUtil::GetEntityHandler(new $name());

        // Check if table exists
        if ($summarizationEntityHandler->Check() == 0) {
            // Create the table
            $xmlSchema = simplexml_load_file(Library::path(Library::EXTENTIONS_SUMMARIZERS . DIRECTORY_SEPARATOR . "summarizers", $name . ".xml"));
            $dbManager = new DatabaseManager();
            $dbManager->CreateTableFromXMLSchema($xmlSchema->entity);
        }

        // Save entity
        foreach ($data as $entity)
        {
            // Save entity
            $summarizationEntityHandler->Save($entity);	
        }
    }
}

?>