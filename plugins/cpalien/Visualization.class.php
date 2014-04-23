<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::VISUALIZATION);
Library::using(Library::VISUALIZATION_DIFFERENCE);
Library::using(Library::VISUALIZATION_PROJECT);
Library::using(Library::VISUALIZATION_SUBMISSION);
Library::using(Library::VISUALIZATION_COMPONENT_GOOGLECHART);
Library::using(Library::PLUGINS .DIRECTORY_SEPARATOR. 'cpalien' .DIRECTORY_SEPARATOR. 'visualization');

/**
 * Visualization short summary.
 *
 * Visualization description.
 *
 * @version 1.0
 * @author Filip
 */
class Visualization
{
    /**
     * Visualize project
     * @param mixed $project 
     * @return mixed
     */
    public static function VisualizeProject(ProjectTSE $project, $type)  {
        return new ValidationResult(ProjectVisualization::Visualize($project, $type));
    }
    
    /**
     * Get data depth for project components
     * @param mixed $type 
     * @return mixed
     */
    public static function GetProjectDataDepth($type)   {
        return ProjectVisualization::GetDataDepth($type);
    }
    
    /**
     * Get project view components
     * @return mixed
     */
    public static function GetProjectViewComponents()   {
        return new ValidationResult(ProjectVisualization::GetViewComponents());
    }
    
    /**
     * Visualize submission
     * @param mixed $submission 
     * @return mixed
     */
    public static function VisualizeSubmission(SubmissionTSE $submission, $type, $meta)    {
        return new ValidationResult(SubmissionVisualization::Visualize($submission, $type, $meta));
    }
    
    /**
     * Get data depth for submission view
     * @param mixed $type 
     * @return mixed
     */
    public static function GetSubmissionDataDepth($type)   {
        return SubmissionVisualization::GetDataDepth($type);
    }
    
    /**
     * Get submission view components
     * @return mixed
     */
    public static function GetSubmissionViewComponents()    {
        return new ValidationResult(SubmissionVisualization::GetViewComponents());
    }
    
    /**
     * Visualize submissions difference
     * @param mixed $submissions 
     * @return mixed
     */
    public static function VisualizeDifference($submissions)    {
        return new ValidationResult(DifferenceVisualization::Visualize($submissions));
    }
    
    /**
     * Get difference view components
     * @return mixed
     */
    public static function GetDifferenceViewComponents()    {
        return new ValidationResult(DifferenceVisualization::GetViewComponents());
    }
    
    /**
     * Get data depth for difference view component
     * @param mixed $type 
     * @return mixed
     */
    public static function GetDifferenceDataDepth($type)   {
        return DifferenceVisualization::GetDataDepth($type);
    }
}