<?php
/**
 * File: TemplateSettingsItem.entity.php
 * Author: Filip Matys
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::CORLY_DAO_BASE);

class TemplateSettingsItem extends IndexedEntity	{
	// Template
	public $Template;
	// Identifier
	public $Identifier;
	// Label
	public $Label;
	// Input type
	public $Type;
	// Value
	public $Value;
	// Required
	public $Required;
}