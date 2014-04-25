<?php

/**
 * ComponentTSE short summary.
 *
 * ComponentTSE description.
 *
 * @version 1.0
 * @author Filip
 */
class ComponentTSE
{
    /**
     * Folder name in components folder
     * @var mixed
     */
    private $Folder;
    
    /**
     * Javascript file
     * @var mixed
     */
    private $Filenames;
    
    /**
     * Component entity constructor
     * @param mixed $folder 
     */
    public function __construct($folder = "")   {
        $this->Folder = $folder;
        $this->Filenames = array();
    }
    
    /**
     * Set folder
     * @param mixed $folder 
     */
    public function SetFolder($folder) {
        $this->Folder = $folder;
    }
    
    /**
     * Summary of GetFolder
     * @return mixed
     */
    public function GetFolder() {
        return $this->Folder;
    }
    
    /**
     * Add filename
     * @param mixed $filename 
     */
    public function AddFilename($filename)  {
        $this->Filenames[] = $filename;
    }
    
    /**
     * Get filenames
     * @return mixed
     */
    public function GetFilenames()  {
        return $this->Filenames;
    }
}
