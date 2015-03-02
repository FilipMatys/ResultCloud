<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

/**
 * ApplicationConfiguration short summary.
 *
 * ApplicationConfiguration description.
 *
 * @version 1.0
 * @author Filip
 */
class ApplicationConfiguration
{
    /**
     * Generate basic configuraton files after installation
     */
    public function GenerateInstallationConfiguration($data)    {
        // Configuration file for database
        return $this->GenerateConfig_Database($data);
    }
    
    /**
     * Generate database configuration file
     */
     private function GenerateConfig_Database($data) {
        // Initialize validation
        $validation = new ValidationResult($data);
     
        // Create xml configuration
        $rConfig = new SimpleXMLElement("<Config></Config>");
     
        // Add database element
        $eDatabase = $rConfig->addChild("db");
        
        // Set database attributes
        $eDatabase->addAttribute("hostname", $data->Hostname);
        $eDatabase->addAttribute("username", $data->Username);
        $eDatabase->addAttribute("password", $data->Password);
        $eDatabase->addAttribute("database", $data->Database);
        $eDatabase->addAttribute("version", $data->Version);
        
        // Save XML file
        $rConfig->asXML(Library::path(Library::CORLY_DAO_BASE, "Config.xml"));
        
        // Return validation
        return $validation;
     }
     
     /**
      * Check if database configuration file exists
      * @return mixed
      */
     public function DatabaseConfigurationFileExists() {
         return file_exists(Library::path(Library::CORLY_DAO_BASE, "Config.xml"));
     }
}
