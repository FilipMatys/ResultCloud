<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SECURITY);
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
     * Get list of users with detail
     * @return mixed
     */
    public function GetDetailedList()   {
        // Get list of users
        $users = $this->GetList();
        // Load each users detail
        foreach ($users as $user)   {
            $user->Person = $this->GetDetail($user)->Person;
        }
        
        // Return result
        return $users;
    }

	/**
	 * Get user detail
	 * @param mixed $user 
	 * @return mixed
	 */
	public function GetDetail($user)	{
        // Load user from database
		$user = $this->UserDao->Load($user);
        // Unset password
        unset($user->Password);
        
        // Load person
        $lPerson = new LINQ($this->PersonDao->GetFilteredList(QueryParameter::Where('User', $user->Id)));
        $user->Person = $lPerson->Single();
        
        // Return user
        return $user;
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