<?php
class ProjectControllerTest extends PHPUnit_Framework_TestCase
{
	public function testGet()
	{
		$params = new stdClass();
		$params->ItemId = "3";
		$params->Type = "LIST";
		$resp = json_decode('{"Data":{"Submissions":[{"Submission":{"Id":25,"DateTime":"Fri Mar 14 18:14:24 2014\r","ImportDateTime":"2015-06-07T00:58:51+00:00","User":{"Id":1,"Username":"bond95","Role":"admin","Person":{"Id":1,"Name":"Bohdan","Email":"","User":1}},"Good":0,"Bad":0,"Strange":0},"NumberOfTestCases":null}]},"IsValid":true,"Errors":[]}');
		$controller = new ProjectController();
		$this->assertEquals($resp, $controller->Get($params));
	}
}