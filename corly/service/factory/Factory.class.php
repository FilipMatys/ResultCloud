<?php
abstract class Factory	{
	// Array of factories
	private static $factories;

	/**
	 * Constructor
	 */
	public static function init()	{
		// Initialize array
		self::$factories = array();
	}

	/**
	 * Get factory by name
	 * @param factory name
	 * @return reference to factory
	 */
	protected static function &GetFactory($factoryName)	{
		// Check if factory is already created, if not, create it
		if (!array_key_exists ($factoryName , self::$factories))	{
			self::$factories[$factoryName] = new $factoryName;
		}	

		// Return factory
		return self::$factories[$factoryName];
	}
}

?>