<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_SETTINGS, ['TemplateSettings.entity.php']);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE, ["Database.php"]);

/**
 * TemplateSettingsDao
 *
 * @version 1.0
 * @author Filip
 */
class TemplateSettingsDao extends Database
{
    // Parent constructor
	function __construct()	{
		parent::__construct(new TemplateSettings());
	}
}
