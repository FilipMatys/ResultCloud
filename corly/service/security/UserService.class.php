<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::DAO_IMPLEMENTATION_SECURITY);
Library::using(Library::UTILITIES);

class UserService	{
	// Daos
	private $UserDao;
	private $PersonDao;

	// Init daos
	public function __construct()	{
		$this->UserDao = new UserDao();
		$this->PersonDao = new PersonDao();
	}

	/**
	 * Get list of all users
	 */
	public function GetList()	{
		return $this->UserDao->GetList();
	}

	/**
	 * Get user detail
     */
	public function GetDetail($user)	{
		return $this->UserDao->Load($user);
	}

	/**
	 * Save user
	 */
	public function Save($user)	{
		// Init validations
		$userValidation = new ValidationResult($user);
		$personValidation = new ValidationResult($user->Person);

		// Validate
		if (!isset($user->Id))	{
			$lUsers = new LINQ($this->UserDao->GetFilteredList(QueryParameter::Where('Username', $user->Username)));
			
			// Check if user of given username already exists
			if (!$lUsers->IsEmpty())	{
				$userValidation->AddError("Uživatel s daným uživatelským jménem již existuje.");
			}
		}

		// Check validation result
		if (!$userValidation->IsValid)	{
			return $userValidation;
		}

		// Get person entity
		$person = $user->Person;

		// Save person
		$insertedPersonId = $this->PersonDao->Save($person);
		if ($insertedPersonId != 0)
			$user->Person = $insertedPersonId;
		else
			$user->Person = $person->Id;

		// Save user
		$this->UserDao->Save($user);

		// Return validation
		return $userValidation;
	}
}