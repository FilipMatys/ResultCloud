<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::CORLY_ENTITIES, ['PaginatedTSE.entity.php']);

/**
 * ProjectTSE short summary.
 *
 * ProjectTSE description.
 *
 * @version 1.0
 * @author Filip
 */
class ProjectTSE extends PaginatedTSE
{
    private $Id;
    private $Name;
    private $Author;
    private $DateCreated;
    private $Submissions;
    private $Plugin;

    
    /**
     * Project test suite entity constructor
     */
    public function __construct($projectEntity = null)   {
        $this->Submissions = array();
        $this->Id = 0;
        if ($projectEntity !== null) {
            $this->MapDbObject($projectEntity);
        }
    }

    /**
     * Get id
     * @return id
     */
    public function GetId() {
        return $this->Id;
    }
    
    /**
     * Get project name
     * @return mixed
     */
    public function GetName()   {
        return $this->Name;
    }
    
    /**
     * Get project author
     * @return mixed
     */
    public function GetAuthor() {
        return $this->Author;
    }
    
    /**
     * Get project date creation
     * @return mixed
     */
    public function GetDateCreated()    {
        return $this->DateCreated;
    }
    
    /**
     * Get project plugin
     */
    public function GetPlugin() {
        return $this->Plugin;
    }
    
    /**
     * Set plugin
     */
    public function SetPlugin($plugin) {
        $this->Plugin = $plugin;
    }
    
    /**
     * Get project submissions
     * @return mixed
     */
    public function &GetSubmissions()    {
        return $this->Submissions;
    }
    
    /**
     * Add submission to project
     * @param mixed $submission 
     */
    public function AddSubmission($submission)  {
        $this->Submissions[] = $submission;
    }

    /**
     * Reverse submissions
     */
    public function ReverseSubmissions() {
        $this->Submissions = array_reverse($this->Submissions);
    }
    
    /**
     * Summary of MapDbObject
     * @param mixed $dbProject 
     */
    public function MapDbObject($dbProject) {
        // Map values
        $this->Id = $dbProject->Id;
        $this->Name = $dbProject->Name;
        $this->Author = $dbProject->Author;
        $this->DateCreated = $dbProject->DateCreated;
        $this->GitRepository = $dbProject->GitRepository;
        
        // Map plugin
        $this->Plugin = new stdClass();
        $this->Plugin->Id = $dbProject->Plugin;
    }
}
