<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Get data
$rawData = file_get_contents('php://input');
// Decode json data
$data = json_decode($rawData);

/**
 * Description of ImportController
 *
 * @author Filip
 */
class ImportController {
    // Client requests
    const UPLOAD = "upload";
    
    // Class constants
    const PATH = "../temp/";
    
    /**
     * Upload file
     * 
     * @return boolean
     */
    public function Upload()    {
        
        // Generate path to save file to
        $targetPath = ImportController::PATH . basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetPath))   {    
            return true;
        }
        else    {
            return false;
        }
    }
}

/**
 * Client requests
 */
if (isset($_GET["method"]))    {
    
    $ImportController = new ImportController();
    
    switch ($_GET["method"]) {
        case ImportController::UPLOAD:
            $result->result = $ImportController->Upload();
            break;

        default:
            $result->result = false;
            break;
    }
    exit(json_encode($result));
}

?>
