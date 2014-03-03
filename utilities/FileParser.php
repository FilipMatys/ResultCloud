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
    
    // Supported files
    private $MediaFiles = array(
        "audio" => array(
            "audio/basic",
            "audio/L24",
            "audio/mp4",
            "audio/mp3",
            "audio/mpeg",
            "audio/ogg",
            "audio/opus",
            "audio/vorbis",
            "audio/vnd",
            "audio/webm",
        ),
        "video" => array(
            "video/mpeg",
            "video/mp4",
            "video/ogg",
            "video/quicktime",
            "video/webm",
            "video/x-matroska",
            "video/x-ms-wmv",
            "video/x-flv",
        ),
        "image" => array(
            "image/gif",
            "image/jpeg",
            "image/pjpeg",
            "image/png",
            "image/svg+xml"
        ),
        "logo" => array(
            "image/png",
            "image/svg+xml"
        ),
    );

    public function __construct($file) {
        // Get name
        $this->Name = $file['name'];
        // Get type
        $this->Type = $file['type'];
        // Get size
        $this->Size = $file['size'];
        // Get tem path
        $this->Temp = $file['tmp_name'];
    }
    
    public function moveFileTo($path)    {
        return move_uploaded_file($this->Temp, $path.basename($this->Name));
    }
    
    /**
     * 
     * @return type
     */
    public function isMediaFile()   {
        return $this->isAudio() || $this->isImage() || $this->isVideo();
    }
    
    /**
     * 
     * @return boolean
     */
    public function isVideo()   {
        return in_array($this->Type, $this->MediaFiles['video']);
    }
    
    /**
     * 
     * @return type
     */
    public function isLogo()    {
        return in_array($this->Type, $this->MediaFiles['logo']);
    }

        /**
     * 
     * @return boolean
     */
    public function isAudio()   {
        return in_array($this->Type, $this->MediaFiles['audio']);
    }
    
    /**
     * 
     * @return boolean
     */
    public function isImage()   {
        return in_array($this->Type, $this->MediaFiles['image']);
    }
    
    /**
     * 
     * @return string
     */
    public function getGeneralType()    {
        if ($this->isImage())   {
            return 'image';
        }
        elseif ($this->isAudio())   {
            return 'audio';
        }
        elseif ($this->isVideo())   {
            return 'video';
        }
    }
}
