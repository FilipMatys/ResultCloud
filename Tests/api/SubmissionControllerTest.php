<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::API, ['SubmissionController.class.php']);
Library::using(Library::CORLY_SERVICE_SESSION);

/**
 * Testing SubmissionController.
 */
class SubmissionControllerTest extends PHPUnit_Framework_TestCase
{
	private  $controller;
	/**
	 * Prepares before every tests
	 */
	protected function setUp()
    {
        $this->controller = new SubmissionController(); 
    }
    /**
     * Testing Get function with "LIST" parameter.
     */
	public function testGetList()
	{
		SessionService::SetSession('id', 1);	//Set user
		$submission = new stdClass;				//Query data
		$submission->ItemId = 1;				//Submission id
		$submission->Type = "LIST";
		$submission->Meta = 1;
		$res = $this->controller->Get($submission);
		$expected = file_get_contents(__DIR__."/../Results/".__CLASS__."/".__FUNCTION__.".json");	//Get excpected data from file
		$this->assertEquals($expected, json_encode($res));	//Check if excpected and actual results equal
	}
	/**
	 * Testing Get function with "GOOGLE_CHART" parameter.
	 */
	public function testGetChart()
	{
		SessionService::SetSession('id', 1);	//Set user
		$submission = new stdClass;				//Query data
		$submission->ItemId = 1;				//Submission id
		$submission->Type = "GOOGLE_CHART";
		$submission->Meta = 1;
		$res = $this->controller->Get($submission);
		$expected = file_get_contents(__DIR__."/../Results/".__CLASS__."/".__FUNCTION__.".json");	//Get excpected data from file
		$this->assertEquals($expected, json_encode($res));	//Check if excpected and actual results equal
	}
	/**
	 * Cleaning up after testing.
	 */
	public static function tearDownAfterClass()
	{
		$project = new stdClass;	//Delete project with submission
		$project->Id = 1;
		FactoryService::ProjectService()->DeleteProject($project);
		DatabaseDriver::connect();
		DatabaseDriver::$db->query("ALTER TABLE `Project` AUTO_INCREMENT = 1");	//Clean auto increments
		DatabaseDriver::$db->query("ALTER TABLE `Submission` AUTO_INCREMENT = 1");
		SessionService::CloseSession();
	}
}
?>