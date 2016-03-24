<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

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
    public function Import($data, $file, $api_call = false)    {
        // Init validation
        $validation = new ValidationResult($data);
        
        // Validate data properties
        $validation->CheckNotNullOrEmpty('Plugin', "Plugin has to be set");
        $validation->CheckNotNullOrEmpty('Project', "Project has to be set");
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }


        // Close session so other requests are allowed
        SessionService::CloseSession();
        
        // Initialize file parser
        $fileParser = new FileParser($file);
        
        // Get the right plugin to import
        FactoryService::PluginService()->LoadPlugin($validation->Data->Plugin);
        
        // Check if importer was included
        if (!class_exists('Importer'))  {
            $validation->AddError("Importer for given plugin was not found");
            return $validation;
        }
        

        // Import file by given plugin
        $importValidation = Importer::Import($validation, $fileParser);
        // Set Git hash if is set
        if (isset($validation->Data->GitHash) && !empty($validation->Data->GitHash))
            $importValidation->Data->SetGitHash($validation->Data->GitHash);

        // Check import validation
        if (!$importValidation->IsValid)    {
            $validation->Append($importValidation);
            return $validation;
        }
        

        // Set user and import date time and save imported data into database
        if ($api_call)
            $idUser = $validation->Data->Id;
        else
            $idUser = SessionService::GetSession('id');

        $importValidation->Data->SetUser($idUser);
        $importValidation->Data->SetImportDateTime(TimeService::DateTime());

        $validation->Append(FactoryService::SubmissionService()->Save($importValidation->Data, $validation->Data->Project));

        // Return validation
        return $validation;
    }
}
