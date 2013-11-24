<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NameController
 *
 * @author Filip
 */
class NameController {
    //put your code here
}

// Get data
$rawData = file_get_contents('php://input');
// Decode json data
$data = json_decode($rawData);

if (isset($_GET["method"]))    {
    switch ($_GET["method"]) {
        case "none":
            break;
        
        default:
            break;
    }
    exit(json_encode($result));
}
?>
