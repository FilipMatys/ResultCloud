<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author Filip Matys
 */
class UserController {
    //put your code here
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