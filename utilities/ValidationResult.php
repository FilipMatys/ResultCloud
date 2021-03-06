<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

/**
 * Description of ValidationResult
 * Object carrying main object, whose validation
 * it represents. Sets object validity and fills
 * itself with error messages if there are any.
 *
 * @author Filip Matys
 * @author Jiri Kratochvil
 * @author Bohdan Iakymets
 */

//Include Library
Library::using(Library::UTILITIES, ['ResultManager.php']);

class ValidationResult extends ResultManager {
    
    // Data object
    public $Data;
    // Validity
    public $IsValid;
    // Array of errors
    public $Errors;
    
    /**
     * Initializes validation
     * - data as object
     * - validity to true
     * - errors to array
     * 
     * @param type $object
     */
    public function __construct($object) {
        parent::__construct();
        $this->Data = $object;
        $this->IsValid = true;
        $this->Errors = array();
    }
    
    /**
     * Check if given property of the object is 
     * set.
     * 
     * @param type $property
     */
    public function CheckNotNullOrEmpty($property, $error)  {
        if ((!isset($this->Data->{$property}) || $this->Data->{$property} == "") && $this->Data->{$property} != 0) {
            $this->AddInvalid($error);
        }
    }
    
    /**
     * Check condition is true
     * @param mixed $condition 
     * @param mixed $error 
     */
    public function IsTrue($condition, $error)  {
        if (!$condition)
            $this->AddInvalid($error);
    }
    
    /**
     * Check if validated data are not null
     */
    public function CheckDataNotNull($error)    {
        if (!isset($this->Data))    {
            $this->AddInvalid($error);
        }
    }
    
    /**
     * Append another validation to this
     * one
     * 
     * @param type $validation
     */
    public function Append($validation)    {
        $this->IsValid = $validation->IsValid && $this->IsValid;
        $this->Errors = array_merge($this->Errors, $validation->Errors);
        $this->Results = array_merge($this->Results, $validation->Results);
    }
    
    /**
     * Check if file exists
     * @param file - path to file
     * @param message - message in case of error
     */
    public function FileExists($file, $message)   {
        if (!file_exists($file))    {
            $this->AddInvalid($message);
        }
    }
    
    /**
     * Add custom error to validation
     * 
     * @param type $error
     */
    public function AddError($error)    {
        $this->AddInvalid($error);
    }

        /**
     * Make object invalid and add error
     * to error list.
     * 
     * @param type $error
     */
    private function AddInvalid($error) {
        $this->IsValid = false;
        $this->Errors[] = $error;
    }
    /**
     * Overloading parent's function
     * @return JSON string with results
     */
    public function toJSON() {
        if (!$this->IsValid)
            $this->Results['Errors'] = $this->Errors;
        $this->Results['IsValid'] = $this->IsValid;
        return parent::toJSON();
    }
}
