<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_DAO_UPDATE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_UPDATE);
Library::using(Library::UTILITIES);

/**
 * @version 1.0
 * @author Filip Matys
 */
class UpdatePatch_6
{
    public $Database;

    public function Update()
    {

        $tAnalyzer = new DbTable('Analyzer');
        
        $pId = new DbProperty('Id');
        $pId->SetType(DbType::Double());
        $pId->NotNull();
        $pId->PrimaryKey();
        $pId->AutoIncrement();
        
        // Set submission property
        $pSubmission = new DbProperty('Submission');
        $pSubmission->SetType(DbType::Double());
        // Add key to table
        $tAnalyzer->AddProperty($pSubmission);
        
        // Set token property
        $pAnalyzer = new DbProperty('Analyzer');
        $pAnalyzer->SetType(DbType::Varchar(255));
        $pAnalyzer->NotNull();
        // Add value to table
        $tAnalyzer->AddProperty($pAnalyzer);

        // Set plugin id property
        $pResult = new DbProperty('Result');
        $pResult->SetType(DbType::Text());
        $pResult->NotNull();
        // Add key to table
        $tAnalyzer->AddProperty($pResult);

        // Set project id property
        $pProject = new DbProperty('Project');
        $pProject->SetType(DbType::Double());
        $pProject->NotNull();
        // Add key to table
        $tAnalyzer->AddProperty($pProject);
        
        $driver = new UpdateDriver();
        $validation = $driver->Update(UpdateDriver::INSERT_TABLE, $tAnalyzer);

        return $validation;
    }
}
