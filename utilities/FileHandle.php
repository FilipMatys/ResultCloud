<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileHandle
 *
 * @author Filip
 */
class FileHandle {

    /**
     * Deletes folder with its content
     * 
     * @param type $dir
     * @return boolean
     */
    public static function DeleteFolder($dir) {
        if (!FileHandle::DeleteFolderContent($dir)) {
            return;
        }
        rmdir($dir);
        return true;
    }
    
    /**
     * Delete file
     */
    public static function DeleteFile($file) {
        return unlink($file);
    }


    /**
     * Get all file names from folder
     * 
     * @param type $dir
     * @return array
     */
    public static function GetFilesNameFromFolder($dir) {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                $folders = array();
                while (($file = readdir($dh)) !== false) {
                    if (strpos($file, ".php")) {
                        $file = substr($file, 0, -4); 
                        array_push($folders, $file);
                    }
                }
                closedir($dh);
            }
        }
        return $folders;
    }
    
    /**
     * Get all subfolders
     * 
     * @param type $dir
     * @return type
     */
    public static function GetSubfolders($dir)  {
        $dirs = glob($dir . '/*' , GLOB_ONLYDIR);
        $result = array();
        
        foreach ($dirs as $directory) {
            $result[] = basename($directory);
        }
        return $result;
    }
    
    /**
     * Delete folder content, but keep the folder
     * 
     * @param type $dir
     */
    public static function DeleteFolderContent($dir)  {
        if (!is_dir($dir)) {
            return false;
        }
        if (substr($dir, strlen($dir) - 1, 1) != '/') {
            $dir .= '/';
        }
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        return true;
    }

}
