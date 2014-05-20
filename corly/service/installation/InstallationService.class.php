<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_DAO_STAT);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SECURITY);
Library::using(Library::CORLY_SERVICE_SECURITY);

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
            $validation->Data = InstallationState::NOT_INSTALLED;
            return $validation;
        }
        
        // Create configuration files
        $configInstallation = new ApplicationConfiguration();
        $validation->Append($configInstallation->GenerateInstallationConfiguration($data));
                
        // Return validation
        $validation->Data = InstallationState::DATABASE_CREATED;
        $validation->IsValid = false;
        return $validation;
    }
    
    /**
     * Check if application is installed
     * @return mixed
     */
    public function CheckInstallation() {
        // Initialize validation
        $validation = new ValidationResult(new stdClass());
        
        // Initialize application configuration
        $applicationConfiguration = new ApplicationConfiguration();
        
        // Validate configuration file
        $validation->IsTrue($applicationConfiguration->DatabaseConfigurationFileExists(), "Application is not installed");
        // Check validation
        if (!$validation->IsValid)  {
            $validation->Data = InstallationState::NOT_INSTALLED;
            return $validation;
        }
        
        // Validate users
        $validation->IsTrue($this->AnyUserExists(), "There are no users");
        // Check validation
        if (!$validation->IsValid)  {
            $validation->Data = InstallationState::DATABASE_CREATED;
            return $validation;
        }
        
        // Return result
        $validation->Data = InstallationState::INSTALLED;
        return $validation;
    }
    
    /**
     * Return list of users, as condition
     * gets false for empty array
     * @return mixed
     */
    private function AnyUserExists()    {
        // Initialize dao
        $userDao = new UserDao();
     
        // Return list of users
        return $userDao->GetList(); 
    }
    
    /**
     * Register user
     * @param mixed $user 
     * @return mixed
     */
    public function RegisterUser($user) {
        // Init validation
        $validation = new ValidationResult($user);
        
        // Validate
        $validation->CheckNotNullOrEmpty('Username', 'Username is required');
        $validation->CheckNotNullOrEmpty('Password', 'Password is required');
        $validation->CheckNotNullOrEmpty('PasswordCheck', 'Password Check is required');
        $validation->IsTrue(isset($user->Person->Name), 'Name is required');
        
        // Check validation result
        if (!$validation->IsValid)  {
            $validation->Data = InstallationState::DATABASE_CREATED;
            return $validation;
        }
        
        // Continue validation
        $validation->IsTrue($user->Password === $user->PasswordCheck, 'Passwords do not match');
        
        // Check validation result
        if (!$validation->IsValid)  {
            $validation->Data = InstallationState::DATABASE_CREATED;
            return $validation;
        }
            
        // Initialize user service
        $userService = new UserService();
        unset($user->PasswordCheck);
        
        // Save user
        $user->Role = "admin";
        $userValidation = $userService->Save($user);
        // Check user validation
        if (!$userValidation->IsValid)    {
            // Merge validations
            $validation->Append($userValidation);
            $validation->Data = InstallationState::DATABASE_CREATED;
            return $validation;
        }
        
        // Set installation state
        $validation->Data = InstallationState::INSTALLED;
        return $validation;
    }
}
