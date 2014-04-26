<?php

/**
 * SystemTAP_ConfigurationView short summary.
 *
 * SystemTAP_ConfigurationView description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_ConfigurationView
{
    /**
     * Date time
     * @var mixed
     */
    public $DateTime;
    
    /**
     * Host
     * @var mixed
     */
    public $Host;
    
    /**
     * Snapshot
     * @var mixed
     */
    public $Snapshot;
    
    /**
     * GCC
     * @var mixed
     */
    public $GCC;
    
    /**
     * Distro
     * @var mixed
     */
    public $Distro;
    
    /**
     * SElinux
     * @var mixed
     */
    public $SElinux;
    
    /**
     * Configuration view costructor
     * @param mixed $configuration 
     */
    public function __construct($configuration)   {
        // Map values
        $this->DateTime = new SystemTAP_ConfigurationViewProperty('Test Run on', $configuration->DateTime);
        $this->Host = new SystemTAP_ConfigurationViewProperty('Host', $configuration->Host);
        $this->Snapshot = new SystemTAP_ConfigurationViewProperty('Snapshot', $configuration->Snapshot);
        $this->GCC = new SystemTAP_ConfigurationViewProperty('GCC', $configuration->GCC);
        $this->Distro = new SystemTAP_ConfigurationViewProperty('Distribution', $configuration->Distro);
        $this->SElinux = new SystemTAP_ConfigurationViewProperty('SElinux', $configuration->SElinux);
    }
}
