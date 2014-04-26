<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::usingProject(dirname(__FILE__));

/**
 * Parser short summary.
 *
 * Parser description.
 *
 * @version 1.0
 * @author Filip
 */
class Parser
{
    static $RESULT_CODES;
    
    /**
     * Initializes class variables
     */
    public static function Init()   {
        // Initialzie result codes
        self::$RESULT_CODES = array(
                "PASS",
                "XPASS",
                "FAIL",
                "XFAIL",
                "KFAIL",
                "UNTESTED",
                "ERROR",
                "UNSUPPORTED"
            );
    }
    
    /**
     * Parse uploaded data for import
     */
    public static function ParseImport($data)    {
        // Load uploaded file as string
        $fileRows = file($data);
        
        $Category = new CategoryTSE("Default");
        
        // Init configuration
        $configuration = new SystemTAP_Configuration();
        $configSet = false;
        
        // Iterate through array (rows)
        foreach ($fileRows as $row) {
            
            // Check for date and time
            if (!isset($Submission) && preg_match("/Test Run By (.*) on (.*)/", $row, $headerMatch))    {
                $Submission = new SubmissionTSE($headerMatch[2]);
                $configuration->DateTime = $headerMatch[2];
            }
            
            // Check for configuration
            if (!$configSet)    {
                if (preg_match("/Host: (.*)/", $row, $configMatch))
                    $configuration->Host = $configMatch[1];
                else if (preg_match("/Snapshot: (.*)/", $row, $configMatch))
                    $configuration->Snapshot = $configMatch[1];
                else if (preg_match("/GCC: (.*)/", $row, $configMatch))
                    $configuration->GCC = $configMatch[1];
                else if (preg_match("/Distro: (.*)/", $row, $configMatch))
                    $configuration->Distro = $configMatch[1];
                else if (preg_match("/SElinux: (.*)/", $row, $configMatch))  {
                    $configuration->SElinux = $configMatch[1];
                    $configSet = true;
                }
            }
        
            // Check for test case header
            if (preg_match("/Running (\.+\/.*) \.{3}/", $row, $testCaseMatches))   {
                
                // If test case was set, add it to category,
                // because we are creating new test case
                if (isset($TestCase))   {
                    $Category->AddTestCase($TestCase);
                }
                
                // Create new test case
                $TestCase = new TestCaseTSE($testCaseMatches[1]);
            }
            // Check for result
            else if (preg_match("/([A-Z]+): (.*)/", $row, $resultMatches))  {
                if (!in_array($resultMatches[1], Parser::$RESULT_CODES))
                    continue;
                
                // Create result object
                $Result = new ResultTSE($resultMatches[2], $resultMatches[1]);
                
                // Add result to test case, if there is any
                if (isset($TestCase))   {
                    $TestCase->AddResult($Result);
                }
            }
        }
        
        // Add category to submission
        $Submission->AddCategory($Category);
        
        // Save configuration
        $systemInfoHandler = DbUtil::GetEntityHandler(new SystemTAP_Configuration);
        $systemInfoHandler->Save($configuration);
        
        $validation = new ValidationResult($Submission);
        return $validation;
    }   
}

// Call initialize function to set static variables
Parser::Init();
