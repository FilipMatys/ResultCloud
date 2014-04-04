<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);

/**
 * ImportService short summary.
 *
 * ImportService description.
 *
 * @version 1.0
 * @author Filip
 */
class ImportService
{
    /**
     * Import file with given plugin
     */
    public function Import($data, $file)    {
        // Init validation
        $validation = new ValidationResult($data);
        
        // Validate data properties
        //$validation->CheckNotNullOrEmpty('Plugin', "Plugin has to be set");
        //$validation->CheckNotNullOrEmpty('Project', "Project has to be set");
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        // Initialize file parser
        $fileParser = new FileParser($file);
        
        // Get the right plugin to import
        $this->GetImportPlugin($validation);
        
        // Check if importer was included
        if (!class_exists('Importer'))  {
            $validation->AddError("Importer for given plugin was not found");
            return $validation;
        }
        
        // Import file by given plugin
        $importValidation = Importer::Import($validation, $fileParser);
        
        // Check import validation
        if (!$importValidation->IsValid)    {
            $validation->Append($importValidation);
            return $validation;
        }
        
        print_r($importValidation->Data);
        
        // Save imported data into database
        // TODO
        
        // Return validation
        return $validation;
    }
    
    /**
     * Get given plugin to import data
     */
    private function GetImportPlugin(ValidationResult $validation)  {
    
        // Todo - test is name of the plugin
        Library::using(Library::PLUGINS .DIRECTORY_SEPARATOR. 'cpalien');
    }
}
