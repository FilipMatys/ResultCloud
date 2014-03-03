<?php
/**
 * Description of ValidationResult
 * Object carrying main object, whose validation
 * it represents. Sets object validity and fills
 * itself with error messages if there are any.
 *
 * @author Filip Matys
 * @author Jiri Kratochvil
 */

class ValidationResult {
    
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
        if (!isset($this->Data->{$property}) || $this->Data->{$property} == "") {
            $this->AddInvalid($property." is required");
        }
    }
    
    /**
     * Check if file is of text format
     * 
     * @param type $property
     */
    public function CheckIsTextFile()  {
        if (strpos($this->Data['type'], ValidationResult::FORMAT_TEXT) === FALSE)    {
            $this->AddInvalid($this->Data['type']." is not supported format");
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
}
