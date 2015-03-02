<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES, ['ValidationResult.php', 'DatabaseDriver.php']);
Library::using(Library::CORLY_DAO_IMPLEMENTATION_UPDATE);

/**
* @author Bohdan Iakymets
**/
class UpdateService {
	/**
	*	Check Database version if it's lower than application version start update
	**/
	public function CheckDB() {

		$validation = new ValidationResult(new stdClass());
		//Check Database Version
		$db = new UpdateDao();
		$curr_ver = 0;
		$update_tbl = $db->Check();
		if($update_tbl != 0)
			$curr_ver = $update_tbl->DBVersion;

		//Get current version of application
		$Ver = (int)(DatabaseDriver::$dbConfig->Data['version']);

		//If it's different start update
		for($i = ($curr_ver+1); $i <= $Ver; $i++)
		{
			$filename = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'updates'.DIRECTORY_SEPARATOR."{$i}.patch.php";
			if (file_exists($filename)) {
				//Include needed patch class
				include_once($filename);
				$cls = "UpdatePatch_{$i}";
				$clsObj = new $cls();
				//Update
				$validation->Append($clsObj->Update());
				if (!$validation->IsValid)
					break;
			}
			else
			{
				$validation->AddError("Can't find next patch file.");
				break;
			}
		}
		//If all were fine, update DB version
		if ($validation->IsValid && $curr_ver < $Ver)
		{
			$update_obj = new stdClass();
			$update_obj->Id = 1;
			$update_obj->DBVersion = $Ver;
			$db->Save($update_obj);
		}
		return $validation;
	}
}
?>