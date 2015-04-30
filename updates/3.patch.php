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
class UpdatePatch_3
{
    public $Database;

	public function Update() {

        $tTestCase = new DbTable('TestCase');

		$pProp = new DbProperty('Status');
		$pProp->SetType(DbType::Double());
		$pProp->NotNull();
		// Add Good to table
		$tTestCase->AddProperty($pProp);

		$driver = new UpdateDriver();
		$validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tTestCase);
		return $validation;
    }
}
