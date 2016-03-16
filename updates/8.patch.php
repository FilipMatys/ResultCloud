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

        // Set Extention property
        $pExtention = new DbProperty('Extention');
        $pExtention->SetType(DbType::Varchar(255));
        // Add Extention to table
        $tTemplateSettings->AddProperty($pExtention);

        $validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tTemplateSettings);

        return $validation;
    }
}
