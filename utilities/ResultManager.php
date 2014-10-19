<?php
	/**
	 * Instruments for easy work with 
	 * result
	 * @author Bohdan Iakymets
	 */
	
	class ResultManager {

		// Map with results
		protected $Results;

		// Constructor
		public function __construct() {
			$this->Results = array();
		}

		// Convert result to JSON format
		public function toJSON() {
			return json_encode($this->Results);
		}

		// Add result
		public function Add($key, $value) {
			$this->Results[$key] = $value;
		}

		// Get list of results
		public function getList() {
			return $this->Results;
		}

		// Get value by key
		public function getValueByKey($key) {
			if (array_key_exists($key, $this->Results))
				return $this->Results[$key];
			else
				return null;
		}
	}
?>