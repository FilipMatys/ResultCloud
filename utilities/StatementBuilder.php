<?php
/* 
 * File: StatementBuilder.php
 * Author: Filip Matys
 * About: Implements basic query statements
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/ObjectPropertyParser.php";

class StatementBuilder  {
    // Constants which are built on 
    // object contruction
    private $INSERT_STATEMENT;
    private $SELECT_STATEMENT;
    private $UPDATE_STATEMENT;
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
    public function getInsertStatement()    {
        return $this->INSERT_STATEMENT;
    }
    
    // Get update statement
    public function getUpdateStatement()    {
        return $this->UPDATE_STATEMENT;
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
        $this->buildInsertStatement();
        $this->buildUpdateStatement();
        $this->buildDeleteStatement();
        $this->buildSelectStatement();
    }
    
    // Build basic insert operation
    private function buildInsertStatement() {
        $this->INSERT_STATEMENT = 'INSERT INTO '.get_class($this->Class);
        $this->INSERT_STATEMENT.= ' ('.implode(',', $this->ObjectPropertyParser->getObjectProperties()).')';
        $this->INSERT_STATEMENT.= ' VALUES ('.implode(',', $this->ObjectPropertyParser->getObjectPropertiesMarks()).')';
    }
    
    // Build basic select operation
    private function buildSelectStatement() {
        $this->SELECT_STATEMENT = 'SELECT * FROM '.get_class($this->Class);        
    }
    
    // Build basic update operation
    private function buildUpdateStatement() {
        $this->UPDATE_STATEMENT = 'UPDATE '.get_class($this->Class).' SET '.implode(',', $this->ObjectPropertyParser->getObjectPropertiesToUpdate()).' WHERE Id=?';
    }
    
    // Build basic delete operation
    private function buildDeleteStatement() {
        $this->DELETE_STATEMENT = 'DELETE FROM '.get_class($this->Class).' WHERE Id=?';
    }
}

?>