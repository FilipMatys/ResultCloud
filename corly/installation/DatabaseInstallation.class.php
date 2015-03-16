<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_DAO_BASE);
Library::using(Library::UTILITIES, ['DatabaseDriver.php']);

/**
 * DatabaseInstallation short summary.
 *
 * DatabaseInstallation description.
 *
 * @version 1.0
 * @author Filip Matys
 */
class DatabaseInstallation
{
    // Database
    private $Database;
    
    /**
     * Installation constructor
     * @param name - database name
     */
    public function __construct($name)   {
        // Initialize database
        $this->Database = new DbDatabase($name);
    }

    /**
     * Prepare database tables
     */
    private function PrepareTables()   {
        // Prepare tables
        
        // User
        $this->CreateTb_User();
        // Person
        $this->CreateTb_Person();
        // Plugin
        $this->CreateTb_Plugin();
        // Project
        $this->CreateTb_Project();
        // Submission
        $this->CreateTb_Submission();
        // Category
        $this->CreateTb_Category();
        // Test case
        $this->CreateTb_TestCase();
        // Result
        $this->CreateTb_Result();
        // Component
        $this->CreateTb_Component();
        // Token
        $this->CreateTb_Token();
        // ImportSession
        $this->CreateTb_ImportSession();
        // TemplateSettings
        $this->CreateTb_TemplateSettings();
        // TemplateSettingsItem
        $this->CreateTb_TemplateSettingsItem();
        // Update
        $this->CreateTb_UpdateItem();
    }
    
    /**
     * Create COMPONENT table
     * - Id [double]
     * - Plugin [double]
     * - Folder [varchar(63)]
     * - Filename [varchar(255)]
     */
    private function CreateTb_Component()   {
        $tComponent = new DbTable('Component');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tComponent->AddProperty($pId);
        
        // Set plugin property
        $pPlugin = new DbProperty('Plugin');
        $pPlugin->SetType(DbType::Double());
        $pPlugin->NotNull();
        // Add id to table
        $tComponent->AddProperty($pPlugin);
        
        // Set Folder property
        $pFolder = new DbProperty('Folder');
        $pFolder->SetType(DbType::Varchar(63));
        $pFolder->NotNull();
        // Add Folder to table
        $tComponent->AddProperty($pFolder);
        
        // Set Filename property
        $pFilename = new DbProperty('Filename');
        $pFilename->SetType(DbType::Varchar(255));
        $pFilename->NotNull();
        // Add Filename to table
        $tComponent->AddProperty($pFilename);
        
        // Add component to table
        $this->Database->AddTable($tComponent);
    }

    private function CreateTb_UpdateItem() {
        $tUpdate = new DbTable('Update');

        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tUpdate->AddProperty($pId);

        $pDBver = new DbProperty('DBVersion');
        $pDBver->SetType(DbType::Double());
        $pDBver->NotNull();
        // Add id to table
        $tUpdate->AddProperty($pDBver);

        $this->Database->AddTable($tUpdate);
    }

    /**
     * Create TemplateSettings table
     * - Id [double]
     * - Project [double]
     * - Identifier [varchar(255)]
     * - Label [varchar(255)]
     * - Type [double]
     */
    private function CreateTb_TemplateSettings()    {
        $tTemplateSettings = new DbTable('TemplateSettings');

        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tTemplateSettings->AddProperty($pId);

        // Set project property
        $pProject = new DbProperty('Project');
        $pProject->SetType(DbType::Double());
        $pProject->NotNull();
        // Add project to table
        $tTemplateSettings->AddProperty($pProject);

        // Set Identifier property
        $pIdentifier = new DbProperty('Identifier');
        $pIdentifier->SetType(DbType::Varchar(255));
        $pIdentifier->NotNull();
        // Add Identifier to table
        $tTemplateSettings->AddProperty($pIdentifier);

        // Set Name property
        $pName = new DbProperty('Name');
        $pName->SetType(DbType::Varchar(255));
        $pName->NotNull();
        // Add name to table
        $tTemplateSettings->AddProperty($pName);

        // Set type property
        $pType = new DbProperty('Type');
        $pType->SetType(DbType::Double());
        $pType->NotNull();
        // Add type to table
        $tTemplateSettings->AddProperty($pType);

        // Add template settings to database
        $this->Database->AddTable($tTemplateSettings);
    }

    /**
     * Create TemplateSettings table
     * - Id [double]
     * - Template [double]
     * - Identifier [varchar(255)]
     * - Label [varchart(255)]
     * - Value [text]
     * - Type [double]
     * - Required [double]
     */
    private function CreateTb_TemplateSettingsItem()    {
        $tTableSettingsItem = new DbTable('TemplateSettingsItem');

        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tTableSettingsItem->AddProperty($pId);

        // Set template property
        $pTemplate = new DbProperty('Template');
        $pTemplate->SetType(DbType::Double());
        $pTemplate->NotNull();
        // Add template to table
        $tTableSettingsItem->AddProperty($pTemplate);

        // Set Identifier property
        $pIdentifier = new DbProperty('Identifier');
        $pIdentifier->SetType(DbType::Varchar(255));
        $pIdentifier->NotNull();
        // Add Identifier to table
        $tTableSettingsItem->AddProperty($pIdentifier);

        // Set label property
        $pLabel = new DbProperty('Label');
        $pLabel->SetType(DbType::Varchar(255));
        $pLabel->NotNull();
        // Add label to table
        $tTableSettingsItem->AddProperty($pLabel);

        // Set value property
        $pValue = new DbProperty('Value');
        $pValue->SetType(DbType::Text());
        $pValue->NotNull();
        // Add value to table
        $tTableSettingsItem->AddProperty($pValue);

        // Set type property
        $pType = new DbProperty('Type');
        $pType->SetType(DbType::Double());
        $pType->NotNull();
        // Add type to table
        $tTableSettingsItem->AddProperty($pType);

        // Set required property
        $pRequired = new DbProperty('Required');
        $pRequired->SetType(DbType::Double());
        $pRequired->NotNull();
        // Add type to table
        $tTableSettingsItem->AddProperty($pRequired);

        // Add template settings item to database
        $this->Database->AddTable($tTableSettingsItem);
    }
    
    /**
     * Create USER table
     * - Id [double]
     * - Password [varchar(31)]
     * - Username [varchar(127)]
     * - Role [varchar(15)]
     */
    private function CreateTb_User()  {
        $tUser = new DbTable('User');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tUser->AddProperty($pId);
        
        // Set pasword property
        $pPassword = new DbProperty('Password');
        $pPassword->SetType(DbType::Varchar(31));
        $pPassword->NotNull();
        // Add Pasword to table
        $tUser->AddProperty($pPassword);
        
        // Set username property
        $pUsername = new DbProperty('Username');
        $pUsername->SetType(DbType::Varchar(127));
        $pUsername->NotNull();
        // Add Username to table
        $tUser->AddProperty($pUsername);
        
        // Set role property
        $pRole = new DbProperty('Role');
        $pRole->SetType(DbType::Varchar(15));
        $pRole->NotNull();
        // Add role to table
        $tUser->AddProperty($pRole);
        
        // Add TABLE to database
        $this->Database->AddTable($tUser);
    }
    
    /**
     * Create PERSON table
     * - Id [double]
     * - Name [varchar(127)]
     * - Email [varchar(127)]
     * - User [double]
     */
    private function CreateTb_Person()  {
        $tPerson = new DbTable('Person');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tPerson->AddProperty($pId);
        
        // Set name property
        $pName = new DbProperty('Name');
        $pName->SetType(DbType::Varchar(127));
        $pName->NotNull();
        // Add name to table
        $tPerson->AddProperty($pName);
        
        // Set email property
        $pEmail = new DbProperty('Email');
        $pEmail->SetType(DbType::Varchar(127));
        $pEmail->NotNull();
        // Add email to table
        $tPerson->AddProperty($pEmail);
        
        // Set user property
        $pUser = new DbProperty('User');
        $pUser->SetType(DbType::Double());
        $pUser->NotNull();
        // Add id to table
        $tPerson->AddProperty($pUser);
        
        // Add table to database
        $this->Database->AddTable($tPerson);
    }
    
    /**
     * Create PLUGIN table
     * - Id [double]
     * - Name [varchar(127)]
     * - Author [varchar(127)]
     * - Version [varchar(127)]
     * - Root [varchar(127)]
     */
    private function CreateTb_Plugin()  {
        $tPlugin = new DbTable('Plugin');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tPlugin->AddProperty($pId);
        
        // Set name property
        $pName = new DbProperty('Name');
        $pName->SetType(DbType::Varchar(127));
        $pName->NotNull();
        // Add name to table
        $tPlugin->AddProperty($pName);
        
        // Set author property
        $pAuthor = new DbProperty('Author');
        $pAuthor->SetType(DbType::Varchar(127));
        $pAuthor->NotNull();
        // Add author to database
        $tPlugin->AddProperty($pAuthor);
        
        // Set Version property
        $pVersion = new DbProperty('Version');
        $pVersion->SetType(DbType::Varchar(127));
        $pVersion->NotNull();
        // Add Version to database
        $tPlugin->AddProperty($pVersion);
        
        // Set Root property
        $pRoot = new DbProperty('Root');
        $pRoot->SetType(DbType::Varchar(127));
        $pRoot->NotNull();
        // Add Root to database
        $tPlugin->AddProperty($pRoot);
        
        // Set About property
        $pAbout = new DbProperty('About');
        $pAbout->SetType(DbType::LongText());
        $pAbout->NotNull();
        // Add About to database
        $tPlugin->AddProperty($pAbout);
        
        // Add table to database
        $this->Database->AddTable($tPlugin);
    }
    
    /**
     * Create Project table
     * - Id [double]
     * - Name [varchar(127)]
     * - Author [varchar(127)]
     * - DateCreated [varchar(63)]
     * - Plugin [double]
     */
    private function CreateTb_Project() {
        $tProject = new DbTable('Project');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tProject->AddProperty($pId);
        
        // Set name property
        $pName = new DbProperty('Name');
        $pName->SetType(DbType::Varchar(127));
        $pName->NotNull();
        // Add name to table
        $tProject->AddProperty($pName);
        
        // Set author property
        $pAuthor = new DbProperty('Author');
        $pAuthor->SetType(DbType::Double());
        $pAuthor->NotNull();
        // Add author to table
        $tProject->AddProperty($pAuthor);
        
        // Set datecreated property
        $pDateCreated = new DbProperty('DateCreated');
        $pDateCreated->SetType(DbType::Varchar(63));
        $pDateCreated->NotNull();
        // Add datecreated to table
        $tProject->AddProperty($pDateCreated);
        
        // Set plugin property
        $pPlugin = new DbProperty('Plugin');
        $pPlugin->SetType(DbType::Double());
        $pPlugin->NotNull();
        // Add plugin to table
        $tProject->AddProperty($pPlugin);
        
        // Add table to database
        $this->Database->AddTable($tProject);
    }
    
    /**
     * Create Submission table
     * - Id [double]
     * - DateTime [varchar(63)]
     * - ImportDateTime [varchar(63)]
     * - User [double]
     * - Project [double]
     */
    private function CreateTb_Submission()  {
        $tSubmission = new DbTable('Submission');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tSubmission->AddProperty($pId);
        
        // Set datetime property
        $pDateTime = new DbProperty('DateTime');
        $pDateTime->SetType(DbType::Varchar(63));
        $pDateTime->NotNull();
        // Add datetime to table
        $tSubmission->AddProperty($pDateTime);
        
        // Set importdatetime property
        $pImportDateTime = new DbProperty('ImportDateTime');
        $pImportDateTime->SetType(DbType::Varchar(63));
        $pImportDateTime->NotNull();
        // Add importdatetime to table
        $tSubmission->AddProperty($pImportDateTime);
        
        // Set user property
        $pUser = new DbProperty('User');
        $pUser->SetType(DbType::Double());
        $pUser->NotNull();
        // Add user to table
        $tSubmission->AddProperty($pUser);
        
        // Set project property
        $pProject = new DbProperty('Project');
        $pProject->SetType(DbType::Double());
        $pProject->NotNull();
        // Add project to table
        $tSubmission->AddProperty($pProject);
        
        $pGood = new DbProperty('Good');
        $pGood->SetType(DbType::Double());
        $pGood->NotNull();
        // Add Good to table
        $tSubmission->AddProperty($pGood);

        $pBad = new DbProperty('Bad');
        $pBad->SetType(DbType::Double());
        $pBad->NotNull();
        // Add Bad to table
        $tSubmission->AddProperty($pBad);

        $pStrange = new DbProperty('Strange');
        $pStrange->SetType(DbType::Double());
        $pStrange->NotNull();
        // Add Strange to table
        $tSubmission->AddProperty($pStrange);

        // Add table to database
        $this->Database->AddTable($tSubmission); 
    }
    
    /**
     * Create Category table
     * - Id [double]
     * - Name [varchar(127)]
     * - Submission [double]
     */
    private function CreateTb_Category()    {
        $tCategory = new DbTable('Category');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tCategory->AddProperty($pId);
        
        // Set name property
        $pName = new DbProperty('Name');
        $pName->SetType(DbType::Varchar(127));
        $pName->NotNull();
        // Add name to table
        $tCategory->AddProperty($pName);
        
        // Set submission property
        $pSubmission = new DbProperty('Submission');
        $pSubmission->SetType(DbType::Double());
        $pSubmission->NotNull();
        // Add submission to table
        $tCategory->AddProperty($pSubmission);
        
        // Add table to database
        $this->Database->AddTable($tCategory);
    }
    
    /**
     * Create test case table
     * - Id [double]
     * - Category [double]
     * - Name [varchar(255)]
     */
    private function CreateTb_TestCase()    {
        $tTestCase = new DbTable('TestCase');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tTestCase->AddProperty($pId);
        
        // Set category property
        $pCategory = new DbProperty('Category');
        $pCategory->SetType(DbType::Double());
        $pCategory->NotNull();
        // Add category to table
        $tTestCase->AddProperty($pCategory);
        
        // Set name property
        $pName = new DbProperty('Name');
        $pName->SetType(DbType::Varchar(255));
        $pName->NotNull();
        // Add name to table
        $tTestCase->AddProperty($pName);
        
        // Add table to database
        $this->Database->AddTable($tTestCase);
    }
    
    /**
     * Create result table
     * - Id [double]
     * - RKey [varchar(511)]
     * - RValue [varchar(511)]
     * - TestCase [double]
     */
    private function CreateTb_Result()  {
        $tResult = new DbTable('Result');
        
        // Set id property
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        // Add id to table
        $tResult->AddProperty($pId);
        
        // Set key property
        $pKey = new DbProperty('RKey');
        $pKey->SetType(DbType::Varchar(255));
        $pKey->NotNull();
        // Add key to table
        $tResult->AddProperty($pKey);
        
        // Set value property
        $pValue = new DbProperty('RValue');
        $pValue->SetType(DbType::Varchar(255));
        $pValue->NotNull();
        // Add value to table
        $tResult->AddProperty($pValue);
        
        // Set test case property
        $pTestCase = new DbProperty('TestCase');
        $pTestCase->SetType(DbType::Double());
        $pTestCase->NotNull();
        // Add test case to table
        $tResult->AddProperty($pTestCase);
        
        // Add table to database
        $this->Database->AddTable($tResult);
    }

    /**
     * Create token table
     * - TokenKey [varchar(255)]
     * - User [int(11)]
     * - CreationTime [int(11)]
     */
    private function CreateTb_Token()  {
        $tResult = new DbTable('Token');
        
        // Set token property
        $pToken = new DbProperty('TokenKey');
        $pToken->SetType(DbType::Varchar(255));
        $pToken->NotNull();
        // Add id to table
        $tResult->AddProperty($pToken);
        
        // Set user id property
        $pUser = new DbProperty('User');
        $pUser->SetType(DbType::Integer());
        $pUser->NotNull();
        // Add key to table
        $tResult->AddProperty($pUser);
        
        // Set creation time property
        $pTime = new DbProperty('CreationTime');
        $pTime->SetType(DbType::Integer());
        $pTime->NotNull();
        // Add value to table
        $tResult->AddProperty($pTime);
        
        // Add table to database
        $this->Database->AddTable($tResult);
    }

    /**
     * Create import session table
     * - SessionId [varchar(255)]
     * - User [int(11)]
     * - CreationTime [int(11)]
     * - Plugin [double]
     * - Project [double]
     */
    private function CreateTb_ImportSession()  {
        $tResult = new DbTable('ImportSession');
        
        // Set token property
        $pToken = new DbProperty('SessionId');
        $pToken->SetType(DbType::Varchar(255));
        $pToken->NotNull();
        // Add id to table
        $tResult->AddProperty($pToken);
        
        // Set user id property
        $pUser = new DbProperty('User');
        $pUser->SetType(DbType::Integer());
        $pUser->NotNull();
        // Add key to table
        $tResult->AddProperty($pUser);
        
        // Set creation time property
        $pTime = new DbProperty('CreationTime');
        $pTime->SetType(DbType::Integer());
        $pTime->NotNull();
        // Add value to table
        $tResult->AddProperty($pTime);

        // Set plugin id property
        $pPlugin = new DbProperty('Plugin');
        $pPlugin->SetType(DbType::Double());
        $pPlugin->NotNull();
        // Add key to table
        $tResult->AddProperty($pPlugin);

        // Set project id property
        $pProject = new DbProperty('Project');
        $pProject->SetType(DbType::Double());
        $pProject->NotNull();
        // Add key to table
        $tResult->AddProperty($pProject);
        
        // Add table to database
        $this->Database->AddTable($tResult);
    }
    
    /**
     * Create database
     */
    public function CreateDatabase($credentials)    {
        // Initialize validation
        $validation = new ValidationResult(new stdClass());
        
        // Initialize mysqli
        @$mysqli = new mysqli($credentials->Hostname, $credentials->Username, $credentials->Password);

        // Check connection
        if ($mysqli->connect_error) {
            $validation->AddError("Failed to connect to database server");
            // Return validation result
            return $validation;
        }
        
        // Create database
        if (!($statement = $mysqli->prepare("CREATE DATABASE {$this->Database->GetName()}"))) {
            $validation->AddError("Failed to create database");
            // Return validation result
            return $validation;
        }
        // Execute statement
        $statement->execute();
        
        // Prepare tables
        $this->PrepareTables();
        
        // Select database to create tables in
        $mysqli->select_db($this->Database->GetName());
        
        //Set connection in DatabaseDriver
        DatabaseDriver::ConnectExisting($mysqli);

        // Create tables
        foreach ($this->Database->GetTables() as $table) {
            if (!($statement = $mysqli->prepare($table->GetTableDefinition()))) {
                $validation->AddError("Failed to create table: {$table->GetName()}");
                // Return validation
                return $validation;
            }
            $statement->execute();
        }
        
        // Return validation
        return $validation;
    }
}
