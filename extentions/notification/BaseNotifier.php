<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::CORLY_DAO_STAT);

class BaseNotifier
{
    public function getSettings()
    {
    	$settings = array();
    	$settingsItem = array();
        $settingsItem['label'] = "Get notifications by this way";
        $settingsItem['identifier'] = "get-notify";
        $settingsItem['default'] = "1";
        $settingsItem['type'] = TemplateSettingsItemType::RADIOBOX;
        $settingsItem['required'] = 'true';
        $settings[] = $settingsItem;

        return $settings; 
    }
}