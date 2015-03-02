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
class UpdatePatch_1 {
	public $Database;

	public function Update() {

		
		//Create needed table
		$this->Database = new DbDatabase("");

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

		$driver = new UpdateDriver();
		$validation = $driver->Update(UpdateDriver::INSERT_TABLE, $this->Database);
		if ($validation->IsValid)
		{
			//Put default information into
			$update_obj = new Update();
			$update_obj->DBVersion = "1";
			$update_obj->Id = 0;
			
			$update_dao = new UpdateDao();
			$update_dao->Save($update_obj);
            if (DatabaseDriver::$db->errno > 0)
            {
            	$validation->AddError("Can't insert information into Table");
            }
		}
		return $validation;

	}
}
?>