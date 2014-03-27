<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DBCREATE);


/**
 * InstallationService short summary.
 *
 * InstallationService description.
 *
 * @version 1.0
 * @author Filip Matys
 */
class InstallationService
{
    /**
     * Install application
     */
    public function Install($data)  {
        // Initialize validation
        $validation = new ValidationResult($data);
        
        // Validate input data
        $validation->CheckNotNullOrEmpty("Hostname", "Hostname is required");
        $validation->CheckNotNullOrEmpty("Username", "Username is required");
        $validation->CheckNotNullOrEmpty("Password", "Password is required");
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        // Set database
        $data->Database = "corly";
        
        // Attempt to create database
        $dbInstallation = new DatabaseInstallation($data->Database);
        $validation->Append($dbInstallation->CreateDatabase($data));
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        // Create configuration files
        $configInstallation = new ApplicationConfiguration();
        $validation->Append($configInstallation->GenerateInstallationConfiguration($data));
        
        // Return validation
        return $validation;
    }
}
