<?php
/**
 * File: Database.php
 * Author: Filip Matys
 */
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Include files
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_DAO_BASE);
Library::using(Library::CORLY_SERVICE_APPLICATION);

abstract class Database  {
    private $db;
    private $class;
    private $statements;
    private $ObjectPropertyParser;
    
    // Database constructor
    function __construct($class) {
    
        // Load configuration
        $dbConfig = ConfigurationService::Database();
        // Create new database handler
        $this->db = new mysqli($dbConfig->Data["hostname"], $dbConfig->Data["username"], $dbConfig->Data["password"], $dbConfig->Data["database"]);
        // Init properties
        $this->class = $class;        
        $this->statements = new StatementBuilder($class);
        $this->ObjectPropertyParser = new ObjectPropertyParser($class);
        // Check database connection
        if ($this->db->connect_errno > 0)   {
            die ('Unable to connect to database[' . $this->db->connect_error . ']');
        }
    }
    
    /**
     * Database destructor
     */
    function __destruct() {
        $this->db->close();
    }
    
    private function refValues($array)	{
        $references = array();

        foreach ($array as $key => $value)	{
            $references[$key] = &$array[$key];
        }

        return $references;
    }

    /**
     * Save or update entity
     * 
     * @param type $entity to save
     * @return inserted id
     */
    public function Save($entity)   {
        // Insert entity if, is 
        if (!isset($entity->Id))    {
            $statement = $this->db->prepare($this->statements->getInsertStatement($entity));

            // Get parameters, plus add double for id
            $params = $this->ObjectPropertyParser->getObjectValuesTypes($entity);

            // Get values
            $values = $this->ObjectPropertyParser->getObjectValues($entity);
            
            array_unshift($values, $params);
            // Now bind parameters
            call_user_func_array(array($statement, 'bind_param'), $this->refValues($values));
        }
        // Update if has Id assigned
        else    {
            $statement = $this->db->prepare($this->statements->getUpdateStatement($entity));

            // Get parameters, plus add double for id
            $params = $this->ObjectPropertyParser->getObjectValuesTypes($entity);
            $params .= 'd';
            // Get values
            $values = $this->ObjectPropertyParser->getObjectValues($entity);
            $values[] = $entity->Id;
            
            array_unshift($values, $params);

            // Now bind parameters
            call_user_func_array(array($statement, 'bind_param'), $this->refValues($values));
        }
        
        // Execute query
        $statement->execute();
        return $this->db->insert_id;
    }
    
    /**
     * Get single entity
     * 
     * @param type $entity
     * @return single entity
     */
    public function Load($entity)   {
        $statement = $this->db->prepare($this->statements->getSelectStatement().' WHERE Id=?');

        $statement->bind_param("d", $entity->Id);
        $statement->execute();

        return ResultParser::parseSingleResult($statement);
    }
    
    /**
     * Delete given entity
     * 
     * @param type $entity
     */
    public function Delete($entity)    {
        $statement = $this->db->prepare($this->statements->getDeleteStatement());
        $statement->bind_param("d", $entity->Id);
        $statement->execute();
    }
    
    /**
     * Get list of all entities of 
     * given type
     * 
     * @return list of entities
     */
    public function GetList()    {
        $statement = $this->db->prepare($this->statements->getSelectStatement());
        $statement->execute();
        
        return ResultParser::parseMultipleResult($statement);
    }
    
    /**
     * Get filtered list of given entity
     * @param type $parameter
     */
    public function GetFilteredList(Parameter $parameter) {
        $statement = $this->db->prepare($this->statements->getSelectStatement()." ".$parameter->Condition);
        print_r($this->db->error);
        $statement->bind_param($this->ObjectPropertyParser->getValueType($parameter->Value), $parameter->Value);
        print_r($this->db->error);
        $statement->execute();
        
        return ResultParser::parseMultipleResult($statement);
    }
}
?>
