<?php 

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);



class ComponentService {
	
	const CONFIG_FILE = "config.xml";
	
	/**
	 * Get component by identifier
	 */
	public function GetByIdentifier($identifier)	{
		// Load component by identifier
		return FactoryDao::ComponentDao()->GetFilteredList(QueryParameter::Where('Identifier', $identifier))->Single();
	}
	
	/**
	 * Load components folder
	 */
	public function LoadComponent($component)	{
		Library::usingComponent($component->Folder);
	}
	
	/**
	 * Get filtered list of components
	 */
	public function GetFilteredList(Parameter $parameter)	{
		return FactoryDao::ComponentDao()->GetFilteredList($parameter);
	}
	
	/**
	 * Get list of components for given project and view
	 */
	public function GetListForViewByProject($project, $view)	{
		return FactoryService::ComponentService()->GetFilteredList(QueryParameter::Query('JOIN TemplateSettings ON Component.Id=TemplateSettings.Component WHERE TemplateSettings.Project=? AND TemplateSettings.UF=? AND TemplateSettings.View=?', array($project->Id, 1, $view)))->ToList();
	}
	
	/**
	 * Get list of components
	 */
	public function GetList()	{
		return FactoryDao::ComponentDao()->GetList();
	}
	
	/**
	 * Get list of component folders
	 */
	private function GetFolders()	{
		$componentDirectoryNames = array();
		
		// Go through components folder
		foreach(glob(Library::path(Library::VISUALIZATION_COMPONENTS, "*"), GLOB_ONLYDIR) as $folder)	{
			$componentDirectoryNames[] = basename($folder);
		}
		
		return $componentDirectoryNames;
	}
	
	/**
	 * Load configuration file for component
	 */
	private function GetConfiguration($componentFolder)	{
		return simplexml_load_file(Library::path(Library::VISUALIZATION_COMPONENTS . DIRECTORY_SEPARATOR . $componentFolder, self::CONFIG_FILE));
	}
	
	/**
	 * Install component
	 */
	public function Install($component)	{
		// Get configuration of component
		$componentConfiguration = $this->GetConfiguration($component->Folder);
		
		// Create object, that will be saved into database
		$component = new stdClass();
		$component->Identifier = (string)$componentConfiguration->base->identifier;
		$component->Folder = (string)$componentConfiguration->base->folder;
		$component->Filename = (string)$componentConfiguration->base->js;
		$component->ViewType = (int)$componentConfiguration->base->{'view-type'};
		$component->Description = (string)$componentConfiguration->base->description;
		
		// Save component and get id
		$component->Id = FactoryDao::ComponentDao()->Save($component);
		
		// Now load all supported plugins and save each entity
		$supportedPluginIdentifiers = array();
		foreach	($componentConfiguration->{'supported-plugins'}->children() as $plugin)	{
			// Create new class
			$componentSupportedPlugin = new stdClass();
			
			// Fill with data
			$componentSupportedPlugin->Component = $component->Id;
			$componentSupportedPlugin->PluginIdentifier = (string)$plugin['identifier'];
			
			// Add to array
			$supportedPluginIdentifiers[] = $componentSupportedPlugin->PluginIdentifier;
			
			// Save
			FactoryDao::ComponentSupportedPluginDao()->Save($componentSupportedPlugin);
		}
		
		// Update existing supported projects
		$this->UpdateExistingSupportedProjects($component, $supportedPluginIdentifiers);
		
		// Return saved component
		return new ValidationResult($component);
	}
	
	/**
	 * Update all supported existing projects
	 */
	private function UpdateExistingSupportedProjects($component, $supportedPluginIdentifiers)	{
		// Check, if component supports all plugins
		if (count($supportedPluginIdentifiers) == 1 && $supportedPluginIdentifiers[0] == "*")	{
			// Load each project and its plugin
			foreach (FactoryService::ProjectService()->GetList()->ToList() as $project) {
				FactoryService::TemplateSettingsService()->UpdateProjectSettings($project, $component);
			}
		}
		// Load projects for each supported plugin and update them
		else {
			// Iterate through identifiers
			foreach ($supportedPluginIdentifiers as $identifier) {
				// Get supported plugin
				$plugin = FactoryService::PluginService()->GetFilteredList(QueryParameter::Where('Identifier', $identifier))->Single();
				
				// If plugin was found, get all its projects and update them
				if (!is_null($plugin))	{
					foreach (FactoryService::ProjectService()->GetFilteredList(QueryParameter::Where('Plugin', $plugin->Id))->ToList() as $project) {
						FactoryService::TemplateSettingsService()->UpdateProjectSettings($project, $component);
					}	
				}
			}
		}
	}
	
	/**
	 * Get components that support given plugin
	 */
	public function GetSupportedByPlugin($plugin)	{
		// Get components, that are supported
		$componentSupportedPlugins = FactoryDao::ComponentSupportedPluginDao()->GetFilteredList(QueryParameter::Query("WHERE PluginIdentifier=? OR PluginIdentifier=?", array($plugin->Identifier, '*')))->ToList();
		
		// Load each component
		$components = array();
		foreach ($componentSupportedPlugins as $supportedPluginEntity) {
			// Init component object
			$component = new stdClass();
			$component->Id = $supportedPluginEntity->Component;
			
			// Add entity to list
			$components[] = FactoryDao::ComponentDao()->Load($component);
		}		
		
		// Return result
		return $components;
	}
	
	/**
	 * Get metadata of given component
	 */
	public function GetComponentMetadata($component, $metas)	{
		// Init result
		$result = array();
		
		// Load configuration
		$componentConfiguration = $this->GetConfiguration($component->Folder);
		
		// Load each desired meta into result
		foreach ($metas as $meta) {
			$result[] = $componentConfiguration->{$meta};
		}
		
		// Return result
		return $result;
	}
	
	/**
	 * Get components, that are not installed
	 */
	public function GetComponents()	{
		// Get component folders
		$componentDirectoryNames = $this->GetFolders();
		
		// Get installed components
		$installedComponentsFolders = FactoryDao::ComponentDao()->GetList()->Select('Folder')->ToList();
		
		// Iterate through component folders
		$components = array();
		foreach ($componentDirectoryNames as $directoryName)	{
				
			// Get component configuration
			$componentConfiguration = $this->GetConfiguration($directoryName);
			
			// Create component entity
			$component = new ComponentTSE();
			
			// Set values
			$component->Name = (string)$componentConfiguration->base->name;
			$component->Identifier = (string)$componentConfiguration->base->identifier;
			$component->Author = (string)$componentConfiguration->base->author;
			$component->Folder = (string)$componentConfiguration->base->folder;
			$component->Filename = (string)$componentConfiguration->base->js;
			$component->ViewType = (int)$componentConfiguration->base->{'view-type'};
			$component->Description = (string)$componentConfiguration->base->description;
			
			// Get supported plugins
			foreach	($componentConfiguration->{'supported-plugins'}->children() as $plugin)	{
				$component->SupportedPlugins[] = (string)$plugin['identifier'];
			}
			
			// If component is installed, mark it
			if (in_array($directoryName, $installedComponentsFolders))
				$component->Installed = true;
				
			// Add component to array
			$components[] = $component;
		}
		
		return $components;
	}
}

?>