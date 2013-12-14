<?php
/**
 * Description of ValidationResult
 * Object carrying main object, whose validation
 * it represents. Sets object validity and fills
 * itself with error messages if there are any.
 *
 * @author Filip
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
    public function CheckNotNull($property)  {
        if (!isset($this->Data->{$property})) {
            $this->AddInvalid($property." is required");
        }
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
