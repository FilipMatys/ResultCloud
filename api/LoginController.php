<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/QueryParameter.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/UserDao.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/NameDao.php";
/**
 * Description of LoginController
 *
 * @author Filip
 */
class LoginController {
    //put your code here
    const AUTHORIZE = "authorize";
    const DEAUTHORIZE = "deauthorize";
    const USERSNAME = "usersname";
    private $UserDao;
    private $NameDao;
    private $QueryParameter;
    
    function __construct() {
        $this->UserDao = new UserDao();
        $this->NameDao = new NameDao();
        $this->QueryParameter = new QueryParameter();
    }
    
    /**
     * Authorize user 
     * @param User $user
     * @return boolean
     */
    function Authorize($user)    {
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
    
    function GetUsersName() {
        $user = $this->UserDao->GetFilteredList($this->QueryParameter->Where("Id", $_SESSION['id']));
        $name = $this->NameDao->GetFilteredList($this->QueryParameter->Where("Id", $user[0]->Name));
        return $name[0];
    }
    
    /**
     * Deathorize user
     * @param type $user
     */
    function Deathorize()  {
        $_SESSION['id'] = null;
        return true;
    }
}

// Get data
$data = file_get_contents('php://input');
// Decode json data
$user = json_decode($data);

if (isset($_GET["method"]))    {
    
    $LoginController = new LoginController();
    
    switch ($_GET["method"]) {
        case LoginController::AUTHORIZE:
            $result->result = $LoginController->Authorize($user);
            break;

        case LoginController::DEAUTHORIZE:
            $result->result = $LoginController->Deathorize();
            break;
        
        case LoginController::USERSNAME:
            $result->result = $LoginController->GetUsersName();
            break;
            
        default:
            $result->result = false;
            break;
    }
    exit(json_encode($result));
}
?>