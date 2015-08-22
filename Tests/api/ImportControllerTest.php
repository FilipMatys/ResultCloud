<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::API, ['ImportController.class.php']);
Library::using(Library::CORLY_SERVICE_SESSION);

/**
 * Testing ImportController.
 */
class ImportControllerTest extends PHPUnit_Framework_TestCase
{
	private  $controller;
	/**
	 * Prepare for testing.
	 */
	public static function setUpBeforeClass() 
	{
		SessionService::SetSession('id', 1);	//Set user
		DatabaseDriver::connect();				//Connect to Database and cleaning up tables
		DatabaseDriver::$db->query("ALTER TABLE `Project` AUTO_INCREMENT = 1");
		DatabaseDriver::$db->query("ALTER TABLE `Submission` AUTO_INCREMENT = 1");
		$project = new stdClass;
		$project->Name = "TestProject";
		$project->Plugin = 1;
		FactoryService::ProjectService()->Save($project);	//Create new Project
	}
	/**
	 * Before every test preparing.
	 */
	protected function setUp()
    {
        $this->controller = new ImportController(); 
        FileParser::$MoveUploadedFile = "moveUploadedFile";		//Setting function for move_uploaded_file
        														//use only for testing.
    }
    /**
     * Testing Import function.
     */
	public function testImport()
	{
		SessionService::SetSession('id', 1);	//Set user
		$import = new stdClass;					//Set import data
		$import->Plugin = 1;
		$import->Project = 1;
		$_FILES = array(
            'file' => array(
                'name' => 'binutils-2015-02-25.sum',
                'type' => 'text/plain',
                'size' => 5072,
                'tmp_name' => __DIR__ . '/../TestFiles/binutils-2015-02-25.sum',	//Path to imported file
                'error' => 0
            )
        );
		$res = $this->controller->Import($import);				//Import
		$this->assertTrue($res->IsValid, $res->Errors[0]);		//Check if everything is alight	
		SessionService::CloseSession();						
	}
}
?>