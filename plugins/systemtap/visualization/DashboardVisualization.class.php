<?php

/**
 * Dashboard Visualization.
 *
 * @version 1.0
 * @author Filip
 */
class DashboardVisualization
{
    /**
     * Visualize dashboard
     * @param ProjectTSE $project
     * @return MultiTable
     */
    public static function Visualize($data) {
        // Return result
        return SystemTAP_Dashboard::GetDashboard($data->Project);
    }

    /**
     * Get view components for project view
     * @return mixed
     */
    public static function GetViewComponents()  {
        return array(
                ComponentProvider::Multitable(ViewType::DASHBOARD),
            );
    }
}
