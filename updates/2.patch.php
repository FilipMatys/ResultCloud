<?php

/**
* @author Bohdan Iakymets
**/
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_DAO_UPDATE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_UPDATE);
Library::using(Library::UTILITIES);


/**
* Patch 1, Add to Database version controll
**/
class UpdatePatch_2 {
	public $Database;

	public function Update() {

		$tSub = new DbTable('Submission');

		$pProp = new DbProperty('Good');
		$pProp->SetType(DbType::Double());
		$pProp->NotNull();
		// Add Good to table
		$tSub->AddProperty($pProp);

		$pProp = new DbProperty('Bad');
		$pProp->SetType(DbType::Double());
		$pProp->NotNull();
		// Add Bad to table
		$tSub->AddProperty($pProp);

		$pProp = new DbProperty('Strange');
		$pProp->SetType(DbType::Double());
		$pProp->NotNull();
		// Add Strange to table
		$tSub->AddProperty($pProp);

		$driver = new UpdateDriver();
		$validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tSub);
		return $validation;
	}
}
?>