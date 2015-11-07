<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::CORLY_ENTITIES, ['PaginatedTSE.entity.php']);

/**
 * PluginTSE short summary.
 *
 * PluginTSE description.
 *
 * @version 1.0
 * @author Filip
 */
class PluginTSE extends PaginatedTSE
{
    /**
     * Plugin name
     * @var mixed
     */
    private $Name;
    
    /**
     * Plugin version
     * @var mixed
     */
    private $Version;
    
    /**
     * Author
     * @var mixed
     */
    private $Author;
    
    /**
     * Root
     * @var mixed
     */
    private $Root;
    
    /**
     * About
     * @var mixed
     */
    private $About;
    
    /**
     * Entity
     * @var mixed
     */
    private $Entity;
    
    private $Identifier;
    
    /**
     * Components
     * @var mixed
     */
    private $Components;
    
    /**
     * Plugin entity constructor
     * @param mixed $name 
     */
    public function __construct($name = "")   {
        $this->Name =  $name;
        $this->Components = array();
    }
    
    /**
     * Set name
     * @param mixed $name 
     */
    public function SetName($name)  {
        $this->Name = $name;
    }
    
    /**
     * Get name
     * @return mixed
     */
    public function GetName()   {
        return $this->Name;
    }
    
    public function SetIdentifier($identifier)  {
        $this->Identifier = $identifier;
    }
    
    /**
     * Set version
     * @param mixed $version 
     */
    public function SetVersion($version)    {
        $this->Version = $version;
    }
    
    /**
     * Get version
     * @return mixed
     */
    public function GetVersion()    {
        return $this->Version;
    }
    
    /**
     * Set author
     * @param mixed $author 
     */
    public function SetAuthor($author) {
        $this->Author = $author;
    }
    
    /**
     * Get author
     * @return mixed
     */
    public function GetAuthor() {
        return $this->Author;
    }
    
    /**
     * Set root
     * @param mixed $root 
     */
    public function SetRoot($root)   {
        $this->Root = $root;
    }
    
    /**
     * Get root
     * @return mixed
     */
    public function GetRoot()   {
        return $this->Root;
    }
    
    /**
     * Set about
     * @param mixed $about 
     */
    public function SetAbout($about)    {
        $this->About = $about;
    }
    
    /**
     * Get about
     * @return mixed
     */
    public function GetAbout()  {
        return $this->About;
    }
    
    /**
     * Set entity
     * @param DbTable $entity 
     */
    public function SetEntity(DbTable $entity)  {
        $this->Entity = $entity;
    }
    
    /**
     * Get entity
     * @return mixed
     */
    public function GetEntity() {
        return $this->Entity;
    }
    
    /**
     * Add component
     * @param ComponentTSE $component 
     */
    public function AddComponent(ComponentTSE $component)   {
        $this->Components[] = $component;
    }
    
    /**
     * Get components
     * @return mixed
     */
    public function GetComponents() {
        return $this->Components;
    }
    
    /**
     * Export object for serialization
     * @return mixed
     */
    public function ExportObject()  {
        // Init object
        $plugin = new stdClass();
        // Set values
        $plugin->Name = $this->Name;
        $plugin->Version = $this->Version;
        $plugin->Author = $this->Author;
        $plugin->About = $this->About;
        $plugin->Root = $this->Root;
        $plugin->Identifier = $this->Identifier;
        
        // Return result
        return $plugin;
    }
    
    /**
     * Maps object into plugin entity
     * @param mixed $plugin 
     */
    public function MapObject($plugin) {
        // Map values
        $this->Name = $plugin->Name;
        $this->About = $plugin->About;
        $this->Author = $plugin->Author;
        $this->Version = $plugin->Version;
        $this->Root = $plugin->Root;
    }
    
    /**
     * Get db object to save to database
     * @return mixed
     */
    public function GetDbObject()   {
        // Init object
        $plugin = new stdClass();
        // Set values
        $plugin->Name = $this->Name;
        $plugin->Version = $this->Version;
        $plugin->Author = $this->Author;
        $plugin->About = $this->About;
        $plugin->Root = $this->Root;
        $plugin->Identifier = $this->Identifier;
        
        // Return result
        return $plugin;
    }
}
