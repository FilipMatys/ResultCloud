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
		if ($type == self::INSERT_TABLE) {
			foreach ($Database->GetTables() as $table) {
				if (!($statement = $this->DB->prepare($table->GetTableDefinition()))) {
					echo $table->GetTableDefinition();
			        $validation->AddError("Failed to create table: {$table->GetName()}");
			        // Return validation
			        return $validation;
			    }
			    $statement->execute();
			}
		}
        return $validation;
	}
}
?>