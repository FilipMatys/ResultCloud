<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::CORLY_SERVICE_FACTORY, ['Factory.class.php']);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SUITE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_PLUGIN);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SECURITY);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SETTINGS);

class FactoryDao extends Factory	{

	/**
	 * Get gategory dao
	 * @return category dao
	 */
	public static function &CategoryDao()	{
		return self::GetFactory('CategoryDao');
	}

	/**
	 * Get template settings dao
	 * @return template settings dao
	 */
	public static function &TemplateSettingsDao()	{
		return self::GetFactory('TemplateSettingsDao');
	}

	/**
	 * Get template settings item dao
	 * @return template settings item dao
	 */
	public static function &TemplateSettingsItemDao()	{
		return self::GetFactory('TemplateSettingsItemDao');
	}

	/**
	 * Get result dao
	 * @return result dao
	 */
	public static function &ResultDao()	{
		return self::GetFactory('ResultDao');
	}

	/**
	 * Get submission dao
	 * @return submission dao
	 */
	public static function &SubmissionDao()	{
		return self::GetFactory('SubmissionDao');
	}

	/**
	 * Get project dao
	 * @return project dao
	 */
	public static function &ProjectDao()	{
		return self::GetFactory('ProjectDao');
	}

	/**
	 * Get plugin dao
	 * @return plugin dao
	 */
	public static function &PluginDao()	{
		return self::GetFactory('PluginDao');
	}

	/**
	 * Get test case dao
	 * @return test case dao
	 */
	public static function &TestCaseDao()	{
		return self::GetFactory('TestCaseDao');
	}

	/**
	 * Get token dao
	 * @return token dao
	 */
	public static function &TokenDao()	{
		return self::GetFactory('TokenDao');
	}

	/**
	 * Get person dao
	 * @return person dao
	 */
	public static function &PersonDao()	{
		return self::GetFactory('PersonDao');
	}

	/**
	 * Get user dao
	 * @return user dao
	 */
	public static function &UserDao()	{
		return self::GetFactory('UserDao');
	}

	/**
	 * Get component dao
	 * @return component dao
	 */
	public static function &ComponentDao()	{
		return self::GetFactory('ComponentDao');
	}
}

// Initialize factory service
FactoryDao::init();

?>