<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
Library::using(Library::CORLY_SERVICE_PLUGIN, ["PluginManagementService.class.php"]);
Library::using(Library::CORLY_DAO_STAT, ['ViewType.enum.php']);
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
    /**
     * Save setting into database
     * @param templateSetting
     * @return 
     */
    public function Save($templateSetting)  {
        // Initialize validation
        $validation = new ValidationResult($templateSetting);

        // Save
        $id = FactoryDao::TemplateSettingsDao()->Save($templateSetting);

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
        return FactoryDao::TemplateSettingsDao()->GetFilteredList($parameter);
    }

    /**
     * Get settings by identifier
     * @param identifier
     * @return template settings
     */
    public function GetByIdentifier($identifier, $projectId)    {
        // Init validation
        $validation = new ValidationResult($identifier);
        $validation->IsTrue(!empty($identifier), "Identifier not set");

        // Check validation
        if (!$validation->IsValid)
            return $validation;

        // Get component
        $component = FactoryService::ComponentService()->GetFilteredList(QueryParameter::Where('Identifier', $identifier))->Single();

        // Get template
        $templateSettings = self::GetFilteredList(QueryParameter::WhereAnd(array('Project', 'Component'), array($projectId, $component->Id)))->Single();

        // Init validation
        $validation = new ValidationResult($templateSettings);

        // Get template items and map them to their identifier
        $items = array();
        foreach (FactoryDao::TemplateSettingsItemDao()->GetFilteredList(QueryParameter::Where('Template', $templateSettings->Id))->ToList() as $item) {
            $items[$item->Identifier] = $item->Value;
        }

        // Return validation
        return new ValidationResult($items);
    }

    /**
     * Initialize settings for project
     * @param project to initialize setting for
     */
    public function InitProjectSettings($project)   {
        // Init general settings
        $this->InitGeneralSettings($project);
        
        // Init components settings
        $this->InitProjectComponents($project);
    }
    
    /**
     * Create component settings
     */
    private function CreateComponentSettingsItems($templateSetting, $templates) {

        if (!$templates)
            return;
        
        // Save each item
        foreach ($templates->children() as $template) {
            // Create new item
            $templateSettingsItem = new TemplateSettingsItem();
            // Assign values
            $templateSettingsItem->Template = $templateSetting->Id;
            $templateSettingsItem->Label = (string)$template['label'];
            $templateSettingsItem->Identifier = (string)$template['identifier'];
            $templateSettingsItem->Value = (string)$template['default'];
            $templateSettingsItem->Type = (int)$template['type'];
            $templateSettingsItem->Required = 1 ? (string)$template['required'] === 'true' : 0; 
            
            // Save item
            FactoryDao::TemplateSettingsItemDao()->Save($templateSettingsItem);
        }
    }
    
    /**
     * Create settings for given component
     */
    private function CreateComponentSettings($project, $component)  {
        // Create new template
        $templateSettings = new TemplateSettings();
        
        // get component meta
        $meta = FactoryService::ComponentService()->GetComponentMetadata($component, array('base', 'setting-templates'));
        
        // Assign values
        $templateSettings->Project = $project->Id;
        $templateSettings->Name = (string)$meta[0]->name;
        $templateSettings->UF = 1;
        $templateSettings->Component = $component->Id;
        $templateSettings->View = $component->ViewType;
        $templateSettings->Type = TemplateSettingsType::COMPONENT;
        
        // Save template
        $templateSettings->Id = FactoryDao::TemplateSettingsDao()->Save($templateSettings);
        // Save template items
        $this->CreateComponentSettingsItems($templateSettings, $meta[1]);
       
        // If view type is project, than save for public as well
        if ($component->ViewType == ViewType::PROJECT)  {
            // Set dashboard view
            unset($templateSettings->Id);
            $templateSettings->View = ViewType::DASHBOARD;
            
            // Save
            $templateSettings->Id = FactoryDao::TemplateSettingsDao()->Save($templateSettings);
            
            // Save template items
            $this->CreateComponentSettingsItems($templateSettings, $meta[1]);
        }
    }
    
    /**
     * Update given project with new component
     */
    public function UpdateProjectSettings($project, $component) {
        $this->CreateComponentSettings($project, $component);
    }
    
    /**
     * Initialize components, that support this project
     */
    private function InitProjectComponents($project)    {
        // Get components, that suppport this project
        $components = FactoryService::ComponentService()->GetSupportedByPlugin($project->Plugin);
        
        // Create template settings for each component
        foreach ($components as $component) {
            $this->CreateComponentSettings($project, $component);
        }
    }
    
    /**
     * Initialize general settings
     */
    private function InitGeneralSettings($project)  {
        
    }

    /**
     * Get project settings
     * @param project to get settings for
     * @return grouped settings
     */
    public function GetProjectSettings($project)    {
        // Get settings for given project
        $templateSettings = FactoryDao::TemplateSettingsDao()->GetFilteredList(QueryParameter::Where('Project', $project->Id))->ToList();

        // Group by type
        foreach ($templateSettings as $templateSetting) {

             // Get settings by sort name
             $templateSetting->Items = FactoryDao::TemplateSettingsItemDao()->GetFilteredList(QueryParameter::Where('Template', $templateSetting->Id))->ToList();

             // Normalize all values
             for ($index = 0; $index < count($templateSetting->Items); $index++)    {
                $templateSetting->Items[$index] = $this->ConvertToInputType($templateSetting->Items[$index]);
             }
             
             // Load component for each template
             $component = new stdClass();
             $component->Id = $templateSetting->Component; 
             $templateSetting->Component = FactoryDao::ComponentDao()->Load($component);
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
                FactoryDao::TemplateSettingsItemDao()->Save($templateSettingItem);
            }
            
            // Remove references
            unset($templateSetting->Component);
            unset($templateSetting->Items);
            FactoryDao::TemplateSettingsDao()->Save($templateSetting);
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
