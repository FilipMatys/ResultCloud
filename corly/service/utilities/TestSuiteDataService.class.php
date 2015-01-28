<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class TestSuiteDataService	{

	/**
	 * Load submissions into given project
	 * @param projectTSE
	 * @param data depth
	 * @param query pagination (not required)
	 * @return projectTSE with loaded submissions
	 */
	public static function LoadSubmissions($projectTSE, $dataDepth, QueryPagination $queryPagination = null)	{
		FactoryService::SubmissionService()->LoadSubmissions($projectTSE, $dataDepth);
	}

	/**
	 * Load categories into given submission
	 * @param submissionTSE
	 * @param data depth
	 * @param query pagination (not required)
	 * @return submissionTSE with loaded categories
	 */
	public static function LoadCategories($submissionTSE, $dataDepth, QueryPagination $queryPagination = null)	{
		FactoryService::CategoryService()->LoadCategories($submissionTSE, $dataDepth);
	} 
}

?>