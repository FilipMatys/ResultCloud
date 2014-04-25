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
    
    /**
     * Get database object for each filename
     * @param mixed $pluginId 
     * @return mixed
     */
    public function GetDbObjects($pluginId)  {
        $dbObjects = array();
        // Return entity for each filename
        foreach ($this->Filenames as $filename) {
            // Init object
            $component = new stdClass();
            // Set values
            $component->Plugin = $pluginId;
            $component->Folder = $this->Folder;
            $component->Filename = $filename;
            
            // Add to array
            $dbObjects[] = $component;
        }
        
        // Retrun result
        return $dbObjects;
    }
}
