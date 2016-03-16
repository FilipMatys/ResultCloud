<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::UTILITIES);

class UserService	{
    /**
     * Get current user detail
     * @return mixed
     */
    public function GetCurrent()    {
        // Init user object
        $user = new stdClass();
        // Get current user id if is set
		if (SessionService::IsSessionSet('id'))	{
        	$user->Id = SessionService::GetSession('id');
			
			// Load user detail
        	$user = $this->GetDetail($user);
		}
        
        // Return result
        return $user;
    }
    
	/**
	 * Get list of all users
	 */
	public function GetList()	{
		return FactoryDao::UserDao()->GetList();
	}
    
    /**
     * Get list of users with detail
     * @return mixed
     */
    public function GetDetailedList()   {
        // Get list of users
        $users = $this->GetList()->ToList();
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
		$user = FactoryDao::UserDao()->Load($user);
        // Unset password
        unset($user->Password);
        
        // Load person
        $lPerson = FactoryDao::PersonDao()->GetFilteredList(QueryParameter::Where('User', $user->Id));
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
			$lUsers = FactoryDao::UserDao()->GetFilteredList(QueryParameter::Where('Username', $user->Username));
			
			// Check if user of given username already exists
			if (!$lUsers->IsEmpty())	{
				$userValidation->AddError("User with given username already exists");
			}
		}

		// Check validation result
		if (!$userValidation->IsValid)	{
			return $userValidation;
		}

		// Get person entity
		$person = $user->Person;
        unset($user->Person);

		// Save user
		$insertedUserId = FactoryDao::UserDao()->Save($user);
		if ($insertedUserId != 0) {
			$person->User = $insertedUserId;
			$user->Id = $insertedUserId;
		}
		else
			$person->User = $user->Id;
		FactoryService::TemplateSettingsService()->InitUserSettings($user);

		// Save person
		FactoryDao::PersonDao()->Save($person);

		// Return validation
		return $userValidation;
	}
}