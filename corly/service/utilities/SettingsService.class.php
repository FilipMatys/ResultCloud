<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

/**
 * DbUtil short summary.
 *
 * DbUtil description.
 *
 * @version 1.0
 * @author Filip
 */
class SettingsService
{
    /**
     * Get template settings by given identifier
     * @param identifier
     * @return template with items
     */
    public static function GetTemplateByIdentifier($identifier) {
        return FactoryService::TemplateSettingsService()->GetByIdentifier($identifier);
    }
}