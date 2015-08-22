<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileParser
 *
 * @author Jiri Kratochvil
 * @author Filip Matys
 */

class FileParser {

    // File name
    public $Name;
    // Type
    private $Type;
    // Size of file
    private $Size;
    // Path to temp file
    private $Temp;

    public static $MoveUploadedFile = "move_uploaded_file";
    /**
     * File parser contructor
     */
    public function __construct($file) {
        // Get name
        $this->Name = $file['name'];
        // Get type
        $this->Type = $file['type'];
        // Get size
        $this->Size = $file['size'];
        // Get temp path
        $this->Temp = $file['tmp_name'];
    }
    
    /**
     * Movile file to given path
     */
    public function moveFileTo($path)    {
        $func = self::$MoveUploadedFile;
        return $func($this->Temp, $path.basename($this->Name));
    }
    
    /**
     * Get file name
     */
    public function getName()   {
        return $this->Name;
    }
    
    /**
     * Get file type
     */
    public function getType()   {
        return $this->Type;
    }
    
    /**
     * Get file size
     */
    public function getSize()   {
        return $this->Size;
    }
    
    /**
     * Get file temp
     */
    public function getTemp()   {
        return $this->Temp;
    }
}
