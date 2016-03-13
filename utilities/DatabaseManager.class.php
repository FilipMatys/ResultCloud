<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DBCREATE);

/**
 * Class to manage some database operations like table checking and table creation
 */
class DatabaseManager
{
    // Property values
    const NAME = "name";
    const TYPE = "type";
    const VALUE = "value";
    const VARCHAR = "varchar";
    const DOUBLE = "double";
    const LONGTEXT = "longtext";

    function __construct()   {
        DatabaseDriver::connect();
        $this->db = DatabaseDriver::$db;
    }

    /**
     * Create table from xml definition
     */
    function CreateTableFromXMLSchema($xml)    {
        $table = $this->ParseXMLSchema($xml);
        $statement = $this->db->prepare($table->GetTableDefinition());
        $statement->execute();
    }

    /**
     * Parse xml schema of table
     */
    private function ParseXMLSchema($xmlEntity)   {
        // Create new table
        $dbTable = new DbTable((string)$xmlEntity[DatabaseManager::NAME]);
        
        // Iterate through properties
        foreach ($xmlEntity->property as $property) {
            // Create new property
            $dbProperty = new DbProperty((string)$property['name']);
            
            // Check property type
            switch((string)$property[DatabaseManager::TYPE])    {
                // Double
                case DatabaseManager::DOUBLE:
                    $dbProperty->SetType(DbType::Double());
                    break;
                    
                // Long text    
                case DatabaseManager::LONGTEXT:
                    $dbProperty->SetType(DbType::LongText());
                    break;
                    
                // Varchar
                case DatabaseManager::VARCHAR:
                    $dbProperty->SetType(DbType::Varchar((string)$property[DatabaseManager::VALUE]));
                    break;
            }
            
            // Add property to table
            $dbTable->AddProperty($dbProperty);
        }
        
        // Return result
        return $dbTable;
    }
}

?>