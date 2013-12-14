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
include_once "$_SERVER[DOCUMENT_ROOT]/IBPGit/service/security/UserService.php";

/**
 * Description of ProfileController
 *
 * @author Filip
 */
class ProfileController {
    //put your code here
    //put your code here
    const GET = "get";
    const SAVE = "save";
    
    private $UserService;
    
    function __construct() {
        $this->UserService = new UserService();
    }
    
    /**
     * Get user with detailed info
     * 
     * @return User
     */
    function Get()  {
        return $this->UserService->GetUserDetail($_SESSION['id']);
    }
    
    /**
     * Save user with detailed info
     * 
     * @return Validation result
     */
    function Save($user)  {
        return $this->UserService->Save($user);
    }
}

// Get data
$data = file_get_contents('php://input');
// Decode json data
$user = json_decode($data);

if (isset($_GET["method"]))    {
    
    $ProfileController = new ProfileController();
    
    switch ($_GET["method"]) {
        case ProfileController::GET:
            $result->result = $ProfileController->Get();
            break;

        case ProfileController::SAVE:
            $result->result = $ProfileController->Save($user);
            break;

        default:
            $result->result = false;
            break;
    }
    exit(json_encode($result));
}

?>