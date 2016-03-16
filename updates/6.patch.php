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

	public function Update() {
        // update SUBMISSION
        $tSubmission = new DbTable('Submission');

        // Set sequence number property
        $pSequenceNumber = new DbProperty('SequenceNumber');
        $pSequenceNumber->SetType(DbType::Integer());
        $pSequenceNumber->NotNull();
        // Add key to table
        $tSubmission->AddProperty($pSequenceNumber);

		$driver = new UpdateDriver();
        $validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tSubmission);
        
        
		return $validation;
    }
}
