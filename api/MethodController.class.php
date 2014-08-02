<?php
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

	// Include files
	Library::using(Library::UTILITIES, ['ValidationResult.php']);

	class MethodController {
			// Propreties
			private $registred_classes = array();
			private $class_dir = "";

			// Constroctor
			function __construct($dir) {
				// Check if directory exist 
				if (!file_exists($dir) && !is_dir($dir)) {
					return false;
				}
				//Save directory
				$this->class_dir = $dir;
				return true;	
			}

			/**
			 * Include file with needed class
			 * @param string $cls name of needed class
			 */
			public function IncludePackage($cls) {
				$file_name = "/".$this->class_dir."/".$cls.".class.php";
				//Check if file exist
				if(file_exists($file_name))
				{
					//Include file
					if(include($file_name)) {
						$this->registred_classes[$cls] = new $cls();
						return true;
					}
				}
				return false;
			}

			/**
			 * Return instance of interested class
			 * @param string $cls 
			 * @return mixed
			 */
			public function GetPackage($cls) {
				//Check if class exist 
				if(array_key_exists($cls, $this->registred_classes)) {
					return $this->registred_classes[$cls];
				}
				return false;
			}

			/**
			 * Call method of interested class
			 * @param string $cls    name of class
			 * @param string $method name of method
			 * @param mixed $params array with params
			 */
			public function CallMethod($cls, $method, $params) {
				$pckg = $this->GetPackage($cls);
				//Check if method exist
				if (method_exists($pckg, $method)) {
					return $pckg->$method($params); 
				}
				else {
					return false;
				}
			}
	};


	$controller = new MethodController(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'webapi');
	$methodValid = new ValidationResult(new stdClass());

	//Check if cotroller was created
	if(!$controller) {
	
		error_log("Directory was not found");
		exit();
	
	}
	elseif(!$controller->IncludePackage($_GET['method'])) {

		$methodValid->AddError("Method was not found");
	
	}
	elseif($result = $controller->CallMethod($_GET['method'], $_GET['function'], $_GET)) {
	
		exit($result);
	
	}
	else {
	
		$methodValid->AddError("Function was not found.");
	
	}
	
	exit($methodValid->toJSON());
?>
