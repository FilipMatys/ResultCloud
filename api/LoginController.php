<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/utilities/QueryParameter.php";
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/daoImplementation/security/UserDao.php";
/**
 * Description of LoginController
 *
 * @author Filip
 */
class LoginController {
    //put your code here
    const AUTHORIZE = "authorize";
    const DEAUTHORIZE = "deauthorize";
    private $UserDao;
    private $QueryParameter;
    
    function __construct() {
        $this->UserDao = new UserDao();
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
        
        if ($dbUsers[0]->Password == $user->Password)   {
            $_SESSION['id'] = $dbUsers[0]->Id;
            return true;
        }
        return false;
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
        
        default:
            $result->result = false;
            break;
    }
    exit(json_encode($result));
}
?>