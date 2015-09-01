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
    
        DatabaseDriver::connect();
        $this->db = DatabaseDriver::$db;
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
        // Reset time limit
        set_time_limit(30);

        // Insert entity if, is 
        if (!isset($entity->Id) || $entity->Id === 0)    {
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

        // Return id of inserted entity
        return $this->db->insert_id != 0 ? $this->db->insert_id : $entity->Id;
    }
    
    /**
     * Get single entity
     * 
     * @param type $entity
     * @return single entity
     */
    public function Load($entity)   {
        // Reset time limit
        set_time_limit(30);

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
        // Reset time limit
        set_time_limit(30);

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
        // Reset time limit
        set_time_limit(30);

        $statement = $this->db->prepare($this->statements->getSelectStatement());
        $statement->execute();
        
        return new LINQ(ResultParser::parseMultipleResult($statement));
    }

    public function DeleteFilteredList(Parameter $parameter) {
        // Reset time limit
        set_time_limit(30);

        $statement = $this->db->prepare($this->statements->getBasicDeleteStatement()." ".$parameter->Condition);
        $statement->bind_param($this->ObjectPropertyParser->getValueType($parameter->Value), $parameter->Value);
        $statement->execute();
    }
    
    /**
     * Get filtered list of given entity
     * @param type $parameter
     */
    public function GetFilteredList(Parameter $parameter, QueryPagination $pagination = null) {
        // Reset time limit
        set_time_limit(30);

        // Build query
        $statementQuery = $this->statements->getSelectStatement()." ".$parameter->Condition;

        // Check if pagination is set
        if (isset($pagination)) {
            $statementQuery = $statementQuery . ' ' .  $this->statements->getPaginationPostfix($pagination);
        }

        // Get records
        $statement = $this->db->prepare($statementQuery);
        $statement->bind_param($this->ObjectPropertyParser->getValueType($parameter->Value), $parameter->Value);
        $statement->execute();
        
        $lResult = new LINQ(ResultParser::parseMultipleResult($statement));

        // Get meta data for pagination
        if (isset($pagination)) {
            // Create statement
            $statement = $this->db->prepare($this->statements->GetCountStatement()." ".$parameter->Condition);
            $statement->bind_param($this->ObjectPropertyParser->getValueType($parameter->Value), $parameter->Value);
            $statement->execute();

            // Set number of results without pagination and page
            $lResult->SetTotalCount(ResultParser::parseCountResult($statement));
            $lResult->SetPage($pagination->GetPage());
        }
        else {
            // Otherwise total count is the number of results
            $lResult->SetTotalCount($lResult->Count());
            $lResult->SetPage(1);
        }

        // Return result
        return $lResult;
    }

    //Check existing table into Database
    public function Check() {
        $statement = $this->db->prepare($this->statements->getSelectStatement());
        if (!$statement) {
            return 0;
        }
        $statement->execute();
        return (new LINQ(ResultParser::parseMultipleResult($statement)))->Last();
    }
}
?>
