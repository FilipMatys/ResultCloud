<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::CORLY_DAO_IMPLEMENTATION_SECURITY);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::UTILITIES);

class AuthentizationService	{
	// Daos
	private $UserDao;

	// Init daos
	public function __construct()	{
		$this->UserDao = new UserDao();
	}

	/**
	 * Authorize credentials
	 */
	public function Authorize($credentials)	{
		// Init validations
		$credentialsValidation = new ValidationResult($credentials);

		// First wave of validation
		$credentialsValidation->CheckNotNullOrEmpty('Username', 'Uživatelské jméno musí být zadáno');
		$credentialsValidation->CheckNotNullOrEmpty('Password', 'Heslo musí být zadáno');

		// Check validation result
		if (!$credentialsValidation->IsValid)	{
			return $credentialsValidation;
		}

		// Second wave of validation
		$lUsers = new LINQ($this->UserDao->GetFilteredList(QueryParameter::Where('Username', $credentials->Username)));
		// Check if given user exists
		if ($lUsers->IsEmpty())	{
			$credentialsValidation->AddError("Neexistující uživatel nebo špatné heslo");
			return $credentialsValidation;
		}
		// Check if passwords match
		if ($lUsers->Single()->Password != $credentials->Password)	{
			$credentialsValidation->AddError("Neexistující uživatel nebo špatné heslo");
			return $credentialsValidation;	
		} 

		// Everything passed, so set session variables
        SessionService::SetSession('id', $lUsers->Single()->Id);

		// Return validation
		return $credentialsValidation;
	}
}