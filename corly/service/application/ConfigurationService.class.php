<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);

/**
 * ConfigurationService short summary.
 *
 * ConfigurationService description.
 *
 * @version 1.0
 * @author Filip
 */
class ConfigurationService
{
    /**
     * Get database configuration
     */
    public static function Database()   {
        // Initialize validation
        $validation = new ValidationResult(new StdClass());
        // Check if file exits
        $validation->FileExists(Library::path(Library::CORLY_DAO_BASE, "Config.xml"), "Configuration file was not found");
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        // Load database config
        $dbConfig = simplexml_load_file(Library::path(Library::CORLY_DAO_BASE, "Config.xml"));
        
        // Get configuration data
        $validation->Data = $dbConfig->db->attributes();
        
        return $validation;
    }    
}
