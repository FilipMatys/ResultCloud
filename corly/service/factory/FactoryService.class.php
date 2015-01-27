<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::CORLY_SERVICE_SUITE);
Library::using(Library::CORLY_SERVICE_PLUGIN);
Library::using(Library::CORLY_SERVICE_SETTINGS);
Library::using(Library::CORLY_SERVICE_SECURITY);
Library::using(Library::CORLY_SERVICE_APPLICATION);
Library::using(Library::CORLY_SERVICE_FACTORY, ['Factory.class.php']);

class FactoryService extends Factory	{

	/**
	 * Get test case service
	 * @return test case service
	 */
	public static function &TestCaseService()	{
		return self::GetFactory('TestCaseService');
	}

	/** 
	 * Get category service
	 * @return category service
	 */
	public static function &CategoryService()	{
		return self::GetFactory('CategoryService');
	}

	/** 
	 * Get result service
	 * @return result service
	 */
	public static function &ResultService()	{
		return self::GetFactory('ResultService');
	}

	/** 
	 * Get submission service
	 * @return submission service
	 */
	public static function &SubmissionService()	{
		return self::GetFactory('SubmissionService');
	}

	/** 
	 * Get plugin service
	 * @return plugin service
	 */
	public static function &PluginService()	{
		return self::GetFactory('PluginService');
	}

	/** 
	 * Get project service
	 * @return project service
	 */
	public static function &ProjectService()	{
		return self::GetFactory('ProjectService');
	}

	/** 
	 * Get plugin management service
	 * @return plugin management service
	 */
	public static function &PluginManagementService()	{
		return self::GetFactory('PluginManagementService');
	}

	/** 
	 * Get user service
	 * @return user service
	 */
	public static function &UserService()	{
		return self::GetFactory('UserService');
	}

	/** 
	 * Get template settings service
	 * @return template settings service
	 */
	public static function &TemplateSettingsService()	{
		return self::GetFactory('TemplateSettingsService');
	}
}

// Initialize factory service
FactoryService::init();

?>