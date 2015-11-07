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
    public $Name;
    public $Folder;
    public $Filename;
    public $Author;
    public $Description;
    public $Identifier;
    public $ViewType;
    public $SupportedPlugins;
    public $Installed;
    
    /**
     * Component entity constructor
     * @param mixed $folder 
     */
    public function __construct()   {
        $this->SupportedPlugins = array();
        $this->Installed = false;
    }
}
