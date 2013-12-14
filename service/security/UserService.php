<?php
/*
 * File: UserService.php 
 * Author: Filip Matys
 * About: Implements user service
 */

include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/dao/security/User.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/UserDao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/NameDao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/QueryParameter.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/ValidationResult.php";

class UserService   {
    private $UserDao;
    private $NameDao;
    private $QueryParameter;
    
    function __construct() {
        $this->UserDao = new UserDao();
        $this->NameDao = new NameDao();
        $this->QueryParameter = new QueryParameter();
    }
    
    /**
     * Authorize user and return basic information
     * to keep him logged in.
     * 
     * @param User $user
     * @return Found user or null
     */
    public function AuthorizeUser($user) {
        $dbUsers = $this->UserDao->GetFilteredList($this->QueryParameter->Where("Username", $user->Username));

        if (!isset($dbUsers))   {
            return false;
        }
        
        // Check given password
        if ($dbUsers[0]->Password == $user->Password)   {
            $_SESSION['id'] = $dbUsers[0]->Id;
            return true;
        }
        return false;
    }
    
    /**
     * Get user with his name (and no password)
     * 
     * @param type $id
     * @return boolean
     */
    public function GetUserDetail($id)   {
        // Fetch user
       $dbUsers = $this->UserDao->GetFilteredList($this->QueryParameter->Where("Id", $id));

       // Check if user was found
        if (!isset($dbUsers))   {
            return false;
        }
        
        // Fetch users name
        $dbNames = $this->NameDao->GetFilteredList($this->QueryParameter->Where("Id", $dbUsers[0]->Name));
        
        // Check if users name was found
        if (!isset($dbNames))   {
            return false;
        }
        
        // Merge objects, reset password and return result
        unset($dbUsers[0]->Password);
        $dbUsers[0]->Name = $dbNames[0];
        
        return $dbUsers[0];
    }
    
    /**
     * Save modified user
     * 
     * @param User $user
     * @return null
     */
    public function Save($user)  {
        // Validate object
        $validation = new ValidationResult($user);
        $validation->CheckNotNull('Email');
        $validation->CheckNotNull('Username');
        
        // Check validation result
        if (!$validation->IsValid)  {
            return $validation;
        }
        
        // Check if entity is already with Id
        if (isset($user->Id))   {
            // Load entities from database
            $dbUser = $this->UserDao->Load($user);
            $dbName = $this->NameDao->Load($user->Name);
            
            // Update values for name
            $dbName->FirstName = $user->Name->FirstName;
            $dbName->LastName = $user->Name->LastName;
            // Update values for user
            $dbUser->Email = $user->Email;
            $dbUser->Username = $user->Username;
            if (isset($user->Password)) {
                $dbUser->Password = $user->Password;
            }
            
            $this->NameDao->Save($dbName);
            $this->UserDao->Save($dbUser);
        }
        else    {
            $nameId = $this->NameDao->Save($user->Name);
            $user->Name->Id = $nameId;
            $validation->Data->Name->Id = $nameId;
            $validation->Data->Id = $this->UserDao->Save($user);
        }
    
        return $validation;
    }
}

?>