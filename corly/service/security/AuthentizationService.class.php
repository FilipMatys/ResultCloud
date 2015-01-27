<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SECURITY);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::UTILITIES);

class AuthentizationService	{
	// Daos
	private $UserDao;
	private $TokenDao;

	// Init daos
	public function __construct()	{
		$this->UserDao = new UserDao();
		$this->TokenDao = new TokenDao();
	}

	/**
	 * Authorize credentials
	 */
	public function Authorize($credentials, $api_call = false)	{
		// Init validations
		$credentialsValidation = new ValidationResult($credentials);

		// First wave of validation
		$credentialsValidation->CheckNotNullOrEmpty('Username', 'Username is required');
		$credentialsValidation->CheckNotNullOrEmpty('Password', 'Password is required');

		// Check validation result
		if (!$credentialsValidation->IsValid)	{
			return $credentialsValidation;
		}

		// Second wave of validation
		$lUsers = $this->UserDao->GetFilteredList(QueryParameter::Where('Username', $credentials->Username));
		// Check if given user exists
		if ($lUsers->IsEmpty())	{
			$credentialsValidation->AddError("Invalid user or password");
			return $credentialsValidation;
		}
		// Check if passwords match
		if ($lUsers->Single()->Password != $credentials->Password)	{
			$credentialsValidation->AddError("Invalid user or password");
			return $credentialsValidation;	
		} 

		// Check if method was called from MethodController
		if ($api_call) {
			// Generating token key
			$creation_time = time();
			// Delete all tokens older than 24h
			$this->TokenDao->DeleteFilteredList(QueryParameter::WhereLess('CreationTime', ($creation_time-(24*60*60))));
			// Params to insert into table
			$new_token = new stdClass();
			$new_token->CreationTime = $creation_time;
			$new_token->User = $lUsers->Single()->Id;
			$new_token->TokenKey = md5(uniqid($lUsers->Single()->Id));
			// Insert
			$this->TokenDao->Save($new_token);

			$credentialsValidation->Add("Result", $new_token);
			// Return validation
			return $credentialsValidation;	

		}
		else {
        	SessionService::SetSession('id', $lUsers->Single()->Id);
			// Return validation
			return $credentialsValidation;
		}
	}
    
    /**
     * Deauthorize current user
     */
    public function Deauthorize()   {
        // Destroy session
        SessionService::DestroySession();
        
        // Return true
        return true;
    }
}