<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Security
 *
 * @author Jiri Kratochvil
 * @author Filip Matys
 */
class Security {

    //put your code here
    private static $SESSION = 'id';

    /**
     * Check if given session variable is set
     * @return boolean
     */
    public static function CheckSession() {
        if (isset($_SESSION[Security::$SESSION])) {
            return true;
        }
        
        return false;
    }

}
