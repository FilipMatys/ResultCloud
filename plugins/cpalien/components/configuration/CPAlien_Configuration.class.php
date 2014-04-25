<?php

/**
 * CPAlien_Configuration short summary.
 *
 * CPAlien_Configuration description.
 *
 * @version 1.0
 * @author Filip
 */
class CPAlien_Configuration
{
    /**
     * Date time
     * @var mixed
     */
    public $DateTime;
    
    /**
     * Hostname
     * @var mixed
     */
    public $Hostname;
    
    /**
     * OSName
     * @var mixed
     */
    public $OSName;
    
    /**
     * CPUModel
     * @var mixed
     */
    public $CPUModel;
    
    /**
     * CPUFrequency
     * @var mixed
     */
    public $CPUFrequency;
    
    /**
     * CPUCores
     * @var mixed
     */
    public $CPUCores;
    
    /**
     * RAMSize
     * @var mixed
     */
    public $RAMSize;
        
    public function __construct($configuration)   {
        // Map values
        $this->DateTime = new CPAlien_ConfigurationProperty('Time of execution', $configuration->DateTime);
        $this->Hostname = new CPAlien_ConfigurationProperty('Hostname', $configuration->Hostname);
        $this->OSName = new CPAlien_ConfigurationProperty('OS Name', $configuration->OS_Name);
        $this->CPUCores = new CPAlien_ConfigurationProperty('CPU Cores', $configuration->CPU_Cores);
        $this->CPUFrequency = new CPAlien_ConfigurationProperty('CPU Frequency', $configuration->CPU_Frequency);
        $this->CPUModel = new CPAlien_ConfigurationProperty('CPU Model', $configuration->CPU_Model);
        $this->RAMSize = new CPAlien_ConfigurationProperty('RAM Size', $configuration->RAM_Size);
    }
}
