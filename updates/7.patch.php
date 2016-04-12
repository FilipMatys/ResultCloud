<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_DAO_UPDATE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_UPDATE);
Library::using(Library::UTILITIES);

/**
 * @version 1.0
 * @author Bohdan Iakymets
 */
class UpdatePatch_7
{
    public $Database;

    public function Update()
    {
        $driver = new UpdateDriver();
        $tTemplateSettings = new DbTable('TemplateSettings');

        // Set project property
        $pProject = new DbProperty('Project');
        $pProject->SetType(DbType::Double());
        // Add project to table
        $tTemplateSettings->AddProperty($pProject);

        $driver->Update(UpdateDriver::DROP_FROM_TABLE, $tTemplateSettings); 

        $tTemplateSettings = new DbTable('TemplateSettings');
        
        // Set project property
        $pUser = new DbProperty('User');
        $pUser->SetType(DbType::Double());
        // Add User to table
        $tTemplateSettings->AddProperty($pUser);
        

        // Set project property
        $pProject = new DbProperty('Project');
        $pProject->SetType(DbType::Double());
        // Add project to table
        $tTemplateSettings->AddProperty($pProject);

        $validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tTemplateSettings);

        return $validation;
    }
}
