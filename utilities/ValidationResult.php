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
}
