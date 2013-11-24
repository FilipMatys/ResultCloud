<?php

/* 
 * File: Database.php
 * Author: Filip Matys
 * About: Implements basic database connection
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/base/Config.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/StatementBuilder.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/ResultParser.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/ObjectPropertyParser.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/QueryParameter.php";

abstract class Database  {
    private $db;
    private $class;
    private $statements;
    private $ObjectPropertyParser;
    
    // Database constructor
    function __construct($class) {
        // Create new database handler
        $this->db = new mysqli(Config::HOSTNAME, Config::USERNAME, Config::PASSWORD, Config::DATABASE);
        // Init properties
        $this->class = $class;        
        $this->statements = new StatementBuilder($class);
        $this->ObjectPropertyParser = new ObjectPropertyParser($class);
        // Check database connection
        if ($this->db->connect_errno > 0)   {
            die ('Unable to connect to database[' . $this->db->connect_error . ']');
        }
    }
    
    function __destruct() {
        $this->db->close();
    }
    
    // Save entity
    public function Save($entity)   {
        $statement = $this->db->prepare($this->statements->getInsertStatement());
        $statement->bind_param($this->ObjectPropertyParser->getObjectValuesTypes(), $this->ObjectPropertyParser->getObjectValues($entity));
        $statement->execute();
        return $this->db->insert_id;
    }
    
    // Load entity
    public function Load($entity)   {
        $statement = $this->db->prepare($this->statements->getSelectStatement().' WHERE Id=?');
        $statement->bind_param("d", $entity->Id);
        $statement->execute();

        return ResultParser::parseSingleResult($statement);
    }
    
    // Delete given entity
    public function Delete($entity)    {
        $statement = $this->db->prepare($this->statements->getDeleteStatement());
        $statement->bind_param("d", $entity->Id);
        $statement->execute();
    }
    
    // Get list of given entities
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
        $statement->bind_param($this->ObjectPropertyParser->getValueType($parameter->Value), $parameter->Value);
        $statement->execute();
        
        return ResultParser::parseMultipleResult($statement);
    }
}
?>
