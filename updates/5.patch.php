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
class UpdatePatch_5
{
    public $Database;

	public function Update() {

        // update PROJECT
        $tProject = new DbTable('Project');

		// Set GitRepository property
        $pGitRepository = new DbProperty('GitRepository');
        $pGitRepository->SetType(DbType::Varchar(512));
        // Add GitRepository to table
        $tProject->AddProperty($pGitRepository);

        // update SUBMISSION
        $tSubmission = new DbTable('Submission');

        // Set GitHash property
        $pGitHash = new DbProperty('GitHash');
        $pGitHash->SetType(DbType::Varchar(512));
        // Add GitHash to table
        $tSubmission->AddProperty($pGitHash);

		$driver = new UpdateDriver();
		$validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tProject);
        $validation = $driver->Update(UpdateDriver::ADD_TO_TABLE, $tSubmission);
        
        
		return $validation;
    }
}
