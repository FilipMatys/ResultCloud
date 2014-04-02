<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);

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
    const SYSTEM_INFO_INDEX = 0;
    
    const COLUMNS = "columns";
    const COLUMNS_INDEX = 1;
    
    const SOURCE_FILE = "sourcefile";
    
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
        
        // Prepare category
        $Category = new stdClass();
        $Category->TestCases = array();
        
        // Initialize validation
        $validation = new ValidationResult($Category);
        
        // GET ELEMENT INDEX
        // First element should be SYSTEM_INFO, second
        // COLUMNS and third+ SOURCE_FILE, starting from
        // 0
        $elementIndex = 0;
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
                $Category->TestCases[] = $sourceFileParseResult->Data;
            }
            
            // 
            $elementIndex++;
        }
        
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
        // Initialize validation
        $TestCase = new stdClass();
        $TestCase->Results = array();
        $validation = new ValidationResult($TestCase);
        
        // Check if element is of type sourcefile
        if (strcmp($eSourceFile->getName(), Parser::SOURCE_FILE) == 0)  {
            // Get metadata    
            // TODO
            // Iterate throught children
            foreach ($eSourceFile as $column)  {
                // Check element name
                if (!strcmp($column->getName(), Parser::COLUMN) == 0)  {
                    $validation->AddError("Wrong element found");
                    return $validation;
                }
                
                // Initialize result
                $Result = new stdClass();
                
                // Check for Status
                if (isset($column[Parser::TITLE]))  {
                    $Result->RKey = $column[Parser::TITLE];
                    $Result->RValue = $column[Parser::VALUE];
                }
                                
                // Add result to test case
                $TestCase->Results[] = $Result;
            }
        }
        // if not, return validation with error
        else    {
            $validation->AddError("Wrong element found");
            return $validation;
        }
        
        // Return validation with data
        return $validation;
    }
}
