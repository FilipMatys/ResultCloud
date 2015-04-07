<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_SESSION);
Library::using(Library::CORLY_SERVICE_UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryDao.class.php']);

/**
 * DashboardService short summary.
 *
 * DashboardService description.
 *
 * @version 1.0
 * @author Filip
 */
class DashboardService
{
    /**
     * Calculate dashboard data for last two submissions
     * @param mixed $project
     */
    public function CalculateLastTwo($projectId)  {
        // Get last two submissions
        $submissions = FactoryDao::SubmissionDao()->GetFilteredList(
            QueryParameter::Where("Project", $projectId),
            new QueryPagination(1, 2, "desc")
            )->ToList();

        // Init array of TSE submissions
        $tseSubmissions = array();

        // Load data foreach submission
        foreach ($submissions as $dbSubmission)
        {
            // Create new TSE entity
            $tseSubmission = new SubmissionTSE();
            $tseSubmission->MapDbObject($dbSubmission);

            // Load data
            FactoryService::CategoryService()->LoadCategories($tseSubmission, 10);

            // Add submission to list
            $tseSubmissions[] = $tseSubmission;
        }

        // Parse last two submissions and save results
        foreach (DashboardParser::ParseSubmissions($tseSubmissions) as $submission)    {
            FactoryService::SubmissionService()->Save($submission, $projectId);
        }
    }
}
