<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_DAO_UPDATE);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_UPDATE);
Library::using(Library::UTILITIES);

/**
 * @version 1.0
 * @author Filip Matys
 */
class UpdatePatch_4
{
	private $Database;
        private $Driver;
	
	public function Update() {
		// Init database
		$this->Database = new DbDatabase("");
                $this->Driver = new UpdateDriver();
                
                
                // Create component supported plugin table
                $this->CreateTb_ComponentSupportedPlugin();

                // Clear components and settings tables
                $this->ClearComponentsAndSettings();

                // Update template settings table
                $this->UpdateTemplateSettingsTable();

                // Update component table
                $this->UpdateComponentTable();
                
                // Update plugin table
                $this->UpdatePluginTable();

                // Remove Plugin from component
                $this->DeletePluginFromComponentTable();

                // Remove identifier from template settings
                $this->DeleteIdentifierFromTemplateSettingsTable();

		return new ValidationResult();
        }
        
        /**
         * Delete identifier from template settings table
         */
        private function DeleteIdentifierFromTemplateSettingsTable()     {
                // Prepare template settings table
                $tTemplateSettings = new DbTable('TemplateSettings');
                
                // Set Identifier property to be dropped
                $pIdentifier = new DbProperty('Identifier');
                $tTemplateSettings->AddProperty($pIdentifier);
                
                // Drop attribute
                $this->Driver->Update(UpdateDriver::DROP_FROM_TABLE, $tTemplateSettings);
        }
        
        /**
         * Delete plugin from component table
         */
        private function DeletePluginFromComponentTable()       {
                // Prepare component table
                $tComponent = new DbTable('Component');
                
                // Set Plugin property to be dropped
                $pPlugin = new DbProperty('Plugin');
                $tComponent->AddProperty($pPlugin);
                
                // Drop attribute
                $this->Driver->Update(UpdateDriver::DROP_FROM_TABLE, $tComponent); 
        }
        
        /**
         * Update plugin table
         */
        private function UpdatePluginTable()    {
                $tPlugin = new DbTable('Plugin');
                
                // Set Identifier property
                $pIdentifier = new DbProperty('Identifier');
                $pIdentifier->SetType(DbType::Varchar(255));
                $pIdentifier->NotNull();
                // Add Identifier to database
                $tPlugin->AddProperty($pIdentifier);
                
                // Update table
                $this->Driver->Update(UpdateDriver::ADD_TO_TABLE, $tPlugin);
        }
        
        /**
         * Update template settings table
         */
        private function UpdateTemplateSettingsTable()       {
                $tTemplateSettings = new DbTable('TemplateSettings');
                
                // Set Usage property
                $pUF = new DbProperty('UF');
                $pUF->SetType(DbType::Integer());
                $pUF->NotNull();
                // Add usage to table
                $tTemplateSettings->AddProperty($pUF);
                
                // Set Component property
                $pComponent = new DbProperty('Component');
                $pComponent->SetType(DbType::Double());
                $pComponent->NotNull();
                // Add Component to table
                $tTemplateSettings->AddProperty($pComponent);
                
                // Set View property
                $pView = new DbProperty('View');
                $pView->SetType(DbType::Integer());
                $pView->NotNull();
                // Add view to table
                $tTemplateSettings->AddProperty($pView);
                
                // Update table
                $this->Driver->Update(UpdateDriver::ADD_TO_TABLE, $tTemplateSettings);
        }
        
        /**
         * Update component table
         */
        private function UpdateComponentTable() {
                // Prepare component table
                $tComponent = new DbTable('Component');
                
                // Set Description property
                $pDescription = new DbProperty('Description');
                $pDescription->SetType(DbType::LongText());
                $pDescription->NotNull();
                // Add Description to table
                $tComponent->AddProperty($pDescription);
                
                // Set Identifier property
                $pIdentifier = new DbProperty('Identifier');
                $pIdentifier->SetType(DbType::Varchar(128));
                $pIdentifier->NotNull();
                // Add Identifier to table
                $tComponent->AddProperty($pIdentifier);
                
                // Set ViewType property
                $pViewType = new DbProperty('ViewType');
                $pViewType->SetType(DbType::Integer());
                $pViewType->NotNull();
                // Add ViewType to table
                $tComponent->AddProperty($pViewType);
                        
                // Update table
                $this->Driver->Update(UpdateDriver::ADD_TO_TABLE, $tComponent);
        }
        
        /**
         * Clear components and settings tables
         */
        private function ClearComponentsAndSettings()   {
                // Clear component table
                $this->Driver->Update(UpdateDriver::CLEAR_TABLE, new DbTable('Component'));
                // Clear template settings table
                $this->Driver->Update(UpdateDriver::CLEAR_TABLE, new DbTable('TemplateSettings'));
                // Clear template settings item table
                $this->Driver->Update(UpdateDriver::CLEAR_TABLE, new DbTable('TemplateSettingsItem'));
        }
	
	/**
         * Create new table
         */
	private function CreateTb_ComponentSupportedPlugin()	{
		// Init table
                $tComponentSupportedPlugin = new DbTable('ComponentSupportedPlugin');
                
                // Set id property
                $pId = new DbProperty('Id');
                $pId->SetType(DbType::Integer());
                $pId->NotNull();
                $pId->PrimaryKey();
                $pId->AutoIncrement();
                // Add id to table
                $tComponentSupportedPlugin->AddProperty($pId);
                
                // Set Component property
                $pComponent = new DbProperty('Component');
                $pComponent->SetType(DbType::Integer());
                $pComponent->NotNull();
                // Add Component to table
                $tComponentSupportedPlugin->AddProperty($pComponent);
                
                // Set PluginIdentifier property
                $pPluginIdentifier = new DbProperty('PluginIdentifier');
                $pPluginIdentifier->SetType(DbType::Varchar(256));
                $pPluginIdentifier->NotNull();
                // Add PluginIdentifier to table
                $tComponentSupportedPlugin->AddProperty($pPluginIdentifier);
                
                // Add ComponentSupportedPlugin to database
                $this->Database->AddTable($tComponentSupportedPlugin);
                
                // Execute changes
                $this->Driver->Update(UpdateDriver::INSERT_TABLE, $this->Database);
	}
}

?>