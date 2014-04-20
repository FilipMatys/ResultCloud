<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_ENTITIES);
Library::using(Library::VISUALIZATION);
Library::using(Library::VISUALIZATION_PROJECT);
Library::using(Library::VISUALIZATION_SUBMISSION);
Library::using(Library::VISUALIZATION_COMPONENT_GOOGLECHART);
Library::using(Library::PLUGINS .DIRECTORY_SEPARATOR. 'glibc' .DIRECTORY_SEPARATOR. 'visualization');

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
    public static function VisualizeProject($project)  {
        return new ValidationResult(ProjectVisualization::Visualize($project));
    }
    
    /**
     * Visualize submission
     * @param mixed $submission 
     * @return mixed
     */
    public static function VisualizeSubmission($submission)    {
        return new ValidationResult(SubmissionVisualization::Visualize($submission));
    }
}