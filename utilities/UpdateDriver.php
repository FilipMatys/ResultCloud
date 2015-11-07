<?php

include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');
Library::using(Library::CORLY_DAO_BASE);
Library::using(Library::CORLY_DBCREATE);
Library::using(Library::CORLY_SERVICE_APPLICATION);
Library::using(Library::UTILITIES, ['ValidationResult.php', 'DatabaseDriver.php']);

/**
*	@author Bohdan Iakymets
**/

class UpdateDriver {
	public $DB;
	const INSERT_TABLE = 1;
	const ADD_TO_TABLE = 2;
	const CLEAR_TABLE = 3;
	const DROP_FROM_TABLE = 4; 

	function __construct() {
		DatabaseDriver::connect();
        $this->DB = DatabaseDriver::$db;
        if ($this->DB->connect_errno > 0)   {
            die ('Unable to connect to database[' . $this->DB->connect_error . ']');
        }
	}
	/**
	* Function which add to DB new tables
	**/
	public function Update($type, $Database) {
		$validation = new ValidationResult(new stdClass());
		switch ($type) {
			case self::INSERT_TABLE:
				foreach ($Database->GetTables() as $table) {
					if (!($statement = $this->DB->prepare($table->GetTableDefinition()))) {
				        $validation->AddError("Failed to create table: {$table->GetName()}");
				        // Return validation
				        return $validation;
				    }
				    $statement->execute();
				}
				break;
				
			case self::ADD_TO_TABLE:
				if (!($statement = $this->DB->prepare($Database->GetAdd2TableDefinition()))) {
					$validation->AddError("Failed to update table: {$Database->GetName()}");
					// Return validation
					return $validation;
				}
				$statement->execute();
				break;
			
			case self::CLEAR_TABLE:
				if (!($statement = $this->DB->prepare($Database->GetClearTableDefinition())))	{
					$validation->AddError("Failed to delete table: {$Database->GetName()}");
					// Return validation
					return $validation;
				}
				$statement->execute();
				break;
				
			case self::DROP_FROM_TABLE:
				if (!($statement = $this->DB->prepare($Database->GetDropColumnDefinition())))	{
					$validation->AddError("Failed to delete table: {$Database->GetName()}");
					// Return validation
					return $validation;
				}
				$statement->execute();
				break;
		}
        return $validation;
	}
}
?>