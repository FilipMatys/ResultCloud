<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_ENTITIES);

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
    // Parent element names
    const SYSTEM_INFO = "systeminfo";
    const SYSTEM_INFO_DATE = "date";
    const SYSTEM_INFO_INDEX = 0;
    
    const COLUMNS = "columns";
    const COLUMNS_INDEX = 1;
    
    const SOURCE_FILE = "sourcefile";
    const SOURCE_FILE_NAME = "name";
    
    const COLUMN = "column";
    const COLUMN_STATUS = "status";
    const COLUMN_CPUTIME = "cputime";
    const COLUMN_WALLTIME = "walltime";
    const COLUMN_MEM_USAGE = "memUsage";
    const VALUE = "value";
    const TITLE = "title";

    /**
     * Parse imported data
     */
    public static function ParseImport($data)   {
        // Load data as xml
        $xmlContent = simplexml_load_file($data);
        
        // Init empty validation
        $validation = new ValidationResult(new stdClass());
        
        // Prepare category
        $Category = new Category("Default");
        
        // GET ELEMENT INDEX
        // First element should be SYSTEM_INFO, second
        // COLUMNS and third+ SOURCE_FILE, starting from
        // 0
        $elementIndex = 0;
        
        // Create submission
        $Submission = new Submission($xmlContent[Parser::SYSTEM_INFO_DATE]);
        
        foreach ($xmlContent as $element)   {
            // Process system info
            if ($elementIndex == Parser::SYSTEM_INFO_INDEX) {
                // TODO
            }
            // Process column definition
            else if ($elementIndex == Parser::COLUMNS_INDEX)    {
                // TODO
            }
            // Process source file (test case)
            else    {
                $sourceFileParseResult = Parser::ParseSourceFile($element);
                // Check validation result
                $validation->Append($sourceFileParseResult);
                if (!$validation->IsValid)  {
                    return $validation;
                }
                // Add result to test case array
                $Category->AddTestCase($sourceFileParseResult->Data);
            }
            
            // Increment index
            $elementIndex++;
        }
        
        // Add category to submission
        $Submission->AddCategory($Category);
        
        // Create validation
        $validation = new ValidationResult($Submission);
        
        // Return validation with data
        return $validation;
    }
    
    /**
     * Parse sourcefile element
     * @param sourcefile element
     * @return object TestCase with
     * - Result (RKey:status)
     * - Result (RKey:cputime)
     * - Result (RKey:walltime)
     * - Result (RKey:memUsage)
     */
    private static function ParseSourceFile($eSourceFile)    {
        
        // Check if element is of type sourcefile
        if (strcmp($eSourceFile->getName(), Parser::SOURCE_FILE) == 0)  {
            // Get metadata    
            $TestCase = new TestCase($eSourceFile[Parser::SOURCE_FILE_NAME]);
            
            // Initialize validation
            $validation = new ValidationResult($TestCase);
            
            // Iterate throught children
            foreach ($eSourceFile as $column)  {
                // Check element name
                if (!strcmp($column->getName(), Parser::COLUMN) == 0)  {
                    $validation->AddError("Wrong element found");
                    return $validation;
                }
                
                // Check for Status
                if (isset($column[Parser::TITLE]))  {
                    $Result = new Result($column[Parser::TITLE], $column[Parser::VALUE]);
                }
                                
                // Add result to test case
                $TestCase->AddResult($Result);
            }
        }
        // if not, return validation with error
        else    {
            $validation = new ValidationResult(new stdClass());
            $validation->AddError("Wrong element found");
        }
        
        // Return validation with data
        return $validation;
    }
}
