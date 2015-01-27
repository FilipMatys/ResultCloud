<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SETTINGS, ['TemplateSettingsDao.class.php']);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SETTINGS, ['TemplateSettingsItemDao.class.php']);
Library::using(Library::CORLY_SERVICE_PLUGIN, ["PluginManagementService.class.php"]);
Library::using(Library::CORLY_DAO_STAT, ['TemplateSettingsType.enum.php']);
Library::using(Library::CORLY_DAO_STAT, ['TemplateSettingsItemType.enum.php']);
Library::using(Library::UTILITIES);

/**
 * Template settings service
 *
 * @version 1.0
 * @author Filip
 */
class TemplateSettingsService
{
    // Dao
    private static $TemplateSettingsDao;
    private static $TemplateSettingsItemDao;

    /**
     * Initialize static variables
     */
    public static function init()  {
        self::$TemplateSettingsDao = new TemplateSettingsDao();
        self::$TemplateSettingsItemDao = new TemplateSettingsItemDao();
    }

    /**
     * Save setting into database
     * @param templateSetting
     * @return 
     */
    public function Save($templateSetting)  {
        // Initialize validation
        $validation = new ValidationResult($templateSetting);

        // Save
        $id = self::$TemplateSettingsDao->Save($templateSetting);

        // Set id for validation result
        if ($id != 0)
            $validation->Data->Id = $id;
        
        // Return validation
        return $validation;
    }

    /**
     * Summary of GetFilteredList
     * @param QueryParameter $queryParameter 
     * @return Filtered list of template settings
     */
    public function GetFilteredList(Parameter $parameter)   {
        return self::$TemplateSettingsDao->GetFilteredList($parameter);
    }

    /**
     * Get settings by identifier
     * @param identifier
     * @return template settings
     */
    public function GetByIdentifier($identifier)    {
        // Init validation
        $validation = new ValidationResult($identifier);
        $validation->IsTrue(!empty($identifier), "Identifier not set");

        // Check validation
        if (!$validation->IsValid)
            return $validation;

        // Get template
        $templateSettings = self::GetFilteredList(QueryParameter::Where('Identifier', $identifier))->ToList();

        // Init validation
        $validation = new ValidationResult($templateSettings);

        // Get template items and map them to their identifier
        $templateSettings->Items = array();
        foreach (self::$TemplateSettingsItemDao->GetFilteredList(QueryParameter::Where('Template', $templateSettings->Id))->ToList() as $item) {
            $templateSettings->Items[$item->Identifier] = $item;
        }

        // Return validation
        return new ValidationResult($templateSettings);
    }

    /**
     * Initialize settings for project
     * @param project to initialize setting for
     */
    public function InitProjectSettings($project)   {
        // Get templates file
        $templatesFile = PluginManagementService::GetPluginTemplates($project->Plugin);

        // Create templates
        foreach ($templatesFile as $template) {
            // Create new template
            $templateSettings = new TemplateSettings();

            // Assign values
            $templateSettings->Project = $project->Id;
            $templateSettings->Type = (int)$template['type'];
            $templateSettings->Name = (string)$template['name'];
            $templateSettings->Identifier = (string)$template['identifier'];

            // Save template
            $templateSettings->Id = self::$TemplateSettingsDao->Save($templateSettings);

            // Save items
            foreach ($template->items->item as $item) {
                // Create new item
                $templateSettingsItem = new TemplateSettingsItem();

                // Assign values
                $templateSettingsItem->Template = $templateSettings->Id;
                $templateSettingsItem->Label = (string)$item['label'];
                $templateSettingsItem->Identifier = (string)$item['identifier'];
                $templateSettingsItem->Value = (string)$item['default'];
                $templateSettingsItem->Type = (int)$item['type'];
                $templateSettingsItem->Required = 1 ? (string)$item['required'] === 'true' : 0; 

                // Save item
                self::$TemplateSettingsItemDao->Save($templateSettingsItem);
            }
        }
    }

    /**
     * Get project settings
     * @param project to get settings for
     * @return grouped settings
     */
    public function GetProjectSettings($project)    {
        // Get settings for given project
        $templateSettings = self::$TemplateSettingsDao->GetFilteredList(QueryParameter::Where('Project', $project->Id))->ToList();

        // Group by type
        foreach ($templateSettings as $templateSetting) {

             // Get settings by sort name
             $templateSetting->Items = self::$TemplateSettingsItemDao->GetFilteredList(QueryParameter::Where('Template', $templateSetting->Id))->ToList();

             // Normalize all values
             for ($index = 0; $index < count($templateSetting->Items); $index++)    {
                $templateSetting->Items[$index] = $this->ConvertToInputType($templateSetting->Items[$index]);
             }
         }

         // Return result
         return $templateSettings;
    }

    /**
     * Save project settings
     * @param $project settings
     * @return validation result
     */
    public function SaveProjectSettings($templateSettings)   {
        // Initialize validation
        $validation = new ValidationResult($templateSettings);

        // Validate all before trying to save
        foreach ($templateSettings as $templateSetting) {

            // Iterate through sort names
            foreach ($templateSetting->Items as $templateSettingItem) {

                // Check, if is required, if so, check if is set
                if ($templateSettingItem->Required) {
                    $validation->IsTrue(!empty($templateSettingItem->Value), $templateSettingItem->Label . " is required");
                }
            }
        }

        // Check validation
        if (!$validation->IsValid)  {
            return $validation;
        }

        // First iterate through types
        foreach ($templateSettings as $templateSetting) {

            // Iterate through sort names
            foreach ($templateSetting->Items as $templateSettingItem) {
                self::Save($templateSettingItem);
            }
        }

        // Return validation
        return $validation;
    }

    /**
     * Converts template setting to input type
     * @param templateSetting
     * @return templateSetting
     */
    private function ConvertToInputType($templateSetting)   {
        // Check input type
        switch($templateSetting->Type)    {
            // String values
            case TemplateSettingsItemType::TEXT_INPUT:
            case TemplateSettingsItemType::TEXT_AREA:
            case TemplateSettingsItemType::DATE:
                break;
            // Number
            case TemplateSettingsItemType::NUMBER:
                $templateSetting->Value = intval($templateSetting->Value);
                break;
            // Boolean
            case TemplateSettingsItemType::CHECKBOX:
                // TODO 
                break;
            default: 
                break;
        }

        // Return result
        return $templateSetting;
    }
}

// Initialize class
TemplateSettingsService::init();