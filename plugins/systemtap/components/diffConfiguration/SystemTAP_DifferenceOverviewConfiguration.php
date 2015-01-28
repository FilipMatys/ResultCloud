<?php

/**
 * SystemTAP_DifferenceOverviewConfiguration short summary.
 *
 * SystemTAP_DifferenceOverviewConfiguration description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_DifferenceOverviewConfiguration
{
    public static function GetDifferenceOverviewConfiguration($submissions) {
        // Get entity handler
        $configurationHandler = DbUtil::GetEntityHandler(new SystemTAP_Configuration);
        
        // Initialize view
        $diffConfigurationView = new SystemTAP_DiffConfigurationView();
        
        // Initialize rows
        $hostRow = new SystemTAP_DiffConfigurationViewRow('Host');
        $snapshotRow = new SystemTAP_DiffConfigurationViewRow('Snapshot');
        $gccRow = new SystemTAP_DiffConfigurationViewRow('GCC');
        $distroRow = new SystemTAP_DiffConfigurationViewRow('Distro');
        $selinuxRow = new SystemTAP_DiffConfigurationViewRow('SElinux');
        
        // Iterate through array of submissions
        foreach ($submissions as $submission) {
            // Set header 
            $diffConfigurationView->AddHeader($submission->GetDateTime());
            
            // Load configuration for given submission
            $lConfiguration = $configurationHandler->GetFilteredList(QueryParameter::Where('DateTime', $submission->GetDateTime()));
            $configuration = $lConfiguration->Single();
            
            // Set values
            $hostRow->AddCell($configuration->Host);
            $snapshotRow->AddCell($configuration->Snapshot); 
            $gccRow->AddCell($configuration->GCC);
            $distroRow->AddCell($configuration->Distro);
            $selinuxRow->AddCell($configuration->SElinux); 
            
        }
        
        // Add rows to view
        $diffConfigurationView->AddRow($hostRow);
        $diffConfigurationView->AddRow($snapshotRow);
        $diffConfigurationView->AddRow($gccRow);
        $diffConfigurationView->AddRow($distroRow);
        $diffConfigurationView->AddRow($selinuxRow);
        
        // Return result
        return $diffConfigurationView->ExportObject();
    }
}
