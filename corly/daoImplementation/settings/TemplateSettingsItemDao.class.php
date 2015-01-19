<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_SETTINGS, ['TemplateSettingsItem.entity.php']);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_BASE, ["Database.php"]);

/**
 * TemplateSettingsItemDao
 *
 * @version 1.0
 * @author Filip
 */
class TemplateSettingsItemDao extends Database
{
    // Parent constructor
	function __construct()	{
		parent::__construct(new TemplateSettingsItem());
	}
}
