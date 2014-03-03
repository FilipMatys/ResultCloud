<?php
/* 
 * File: StatementBuilder.php
 * Author: Filip Matys
 * About: Implements basic query statements
 */

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'ObjectPropertyParser.php';

class StatementBuilder  {
    // Constants which are built on 
    // object contruction
    private $SELECT_STATEMENT;
    private $DELETE_STATEMENT;
    
    private $ObjectPropertyParser;
    private $Class;

    // Builder constructor
    function __construct($class) {
        $this->Class = $class;
        $this->ObjectPropertyParser = new ObjectPropertyParser($class);
        $this->buildStatements();
    }
    
    // Get insert statement
    public function getInsertStatement($entity)    {
        return $this->buildInsertStatement($entity);
    }
    
    // Get update statement
    public function getUpdateStatement($entity)    {
        return $this->buildUpdateStatement($entity);
    }
    
    // Get select statement
    public function getSelectStatement()    {
        return $this->SELECT_STATEMENT;
    }
    
    // Get delete statement
    public function getDeleteStatement()    {
        return $this->DELETE_STATEMENT;
    }

    // Build database function statements
    private function buildStatements()  {
        $this->buildDeleteStatement();
        $this->buildSelectStatement();
    }
    
    // Build basic insert operation
    private function buildInsertStatement($entity) {
        $statement = 'INSERT INTO '.get_class($this->Class);
        $statement.= ' ('.implode(',', $this->ObjectPropertyParser->getObjectProperties($entity)).')';
        $statement.= ' VALUES ('.implode(',', $this->ObjectPropertyParser->getObjectPropertiesMarks($entity)).')';
        
        return $statement;
    }
    
    // Build basic select operation
    private function buildSelectStatement() {
        $this->SELECT_STATEMENT = 'SELECT * FROM '.get_class($this->Class);        
    }
    
    // Build basic update operation
    private function buildUpdateStatement($entity) {
        return 'UPDATE '.get_class($this->Class).' SET '.implode(',', $this->ObjectPropertyParser->getObjectPropertiesToUpdate($entity)).' WHERE Id=?';
    }
    
    // Build basic delete operation
    private function buildDeleteStatement() {
        $this->DELETE_STATEMENT = 'DELETE FROM '.get_class($this->Class).' WHERE Id=?';
    }
}

?>