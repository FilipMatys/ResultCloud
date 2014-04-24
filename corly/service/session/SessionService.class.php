<?php

/**
 * SessionService short summary.
 *
 * SessionService description.
 *
 * @version 1.0
 * @author Filip
 */
class SessionService
{
    /**
     * Set session variable
     * @param mixed $sessionKey 
     * @param mixed $value 
     */
    public static function SetSession($sessionKey, $value)  {
        $_SESSION[$sessionKey] = $value;
    }   
    
    /**
     * Get session variable
     * @param mixed $sessionKey 
     * @return mixed
     */
    public static function GetSession($sessionKey)  {
        return $_SESSION[$sessionKey];
    }
    
    /**
     * Close session
     */
    public static function CloseSession()   {
        session_write_close();
    }
    
    /**
     * Destroy session
     */
    public static function DestroySession() {
        session_destroy();
    }
}
