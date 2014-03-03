<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::COLRY_DBCREATE);
Library::using(Library::COLRY_DAO_BASE);

/**
 * CorlyInstallation short summary.
 *
 * CorlyInstallation description.
 *
 * @version 1.0
 * @author Filip
 */
class CorlyInstallation
{
    // Database
    private $Database;
    
    /**
     * Installation constructor
     */
    public function __construct()   {
        // Initialize database
        $this->Database = new DbDatabase('corly');
    }

    /**
     * Prepare database tables
     */
    public function PrepareDatabase()   {
        // Prepare tables
        // User
        $this->CreateUserTable();
    }
    
    private function CreateUserTable()  {
        $user = new DbTable('User');
        
        // Set pasword property
        $password = new DbProperty('Password');
        $password->SetType(DbType::Varchar(31));
        $password->NotNull();
        // Add Pasword to table
        $user->AddProperty($password);
        
        // Set username property
        $username = new DbProperty('Username');
        $username->SetType(DbType::Varchar(127));
        $username->NotNull();
        // Add Username to table
        $user->AddProperty($username);
        
        // Add TABLE to database
        $this->Database->AddTable($user);
    }
    
    /**
     * Create database
     */
    public function CreateDatabase()    {
    
    }
}
