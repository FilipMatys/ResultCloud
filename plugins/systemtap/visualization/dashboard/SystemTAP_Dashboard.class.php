<?php

/**
 * SystemTAP_Dashboard short summary.
 *
 * SystemTAP_Dashboard description.
 *
 * @version 1.0
 * @author Filip
 */
class SystemTAP_Dashboard
{
    /**
     * Colors to be set for each status
     * @var mixed
     */
    private static $StatusColors;

    /**
     * Initialize class static variables
     */
    public static function Init()   {
        // Initialize array of colors
        self::$StatusColors = array(
                SystemTAP_TestCaseStatus::FIX => "background-color:#27ae60",
                SystemTAP_TestCaseStatus::STAYS_POSITIVE => "background-color:#2ecc71",
                SystemTAP_TestCaseStatus::REGRESSION => "background-color:#e74c3c",
                SystemTAP_TestCaseStatus::STAYS_BUGGY => "background-color:#c0392b",
                SystemTAP_TestCaseStatus::NEUTRAL => "background-color:#ecf0f1",
                SystemTAP_TestCaseStatus::PARTIAL_FIXES => "background-color:#e67e22",
                SystemTAP_TestCaseStatus::WIERD => "background-color:#ecf0f1"
            );
    }

    /**
     * Get dashboard
     * @param ProjectTSE $project
     * @return MultiTable
     */
    public static function GetDashboard(ProjectTSE $project)
    {
        // Initialize multitable
        $multiTable = new MultiTable();
        $multiTable->Header = "SystemTAP " . $project->GetName();

        // Load submissions for given project
        TestSuiteDataService::LoadSubmissions($project, DataDepth::TEST_CASE, new QueryPagination(1, 10, 'asc'));

        // Get template of dashboard
        $template = self::GetTemplate($project);

        // Build tables
        $multiTable->Tables = self::Build($project, $template);

        // Return result
        return $multiTable;
    }

    /**
     * Build tables for dashboard
     * @param ProjectTSE $project
     * @param mixed $template
     * @return array
     */
    private static function Build(ProjectTSE $project, $template)
    {
        // Iterate through tables
        foreach ($template as &$table)
        {
            // Iterate through submissions
		foreach ($project->GetSubmissions() as $submission)
            {
                // Get category by table header
                $subCategory = $submission->GetCategoryByName($table->Header);
                $table->HeaderRow->Cells[] = new TableCell($submission->GetDateTime());

                // Iterate through rows (test cases)
                foreach ($table->Rows as &$row)
                {
			// Get test case value
                    $tcVal = $subCategory->GetTestCaseByName($row->Cells[0]->Data);

                    // Check value
                    if (is_null($tcVal))
                        $row->Cells[] = new TableCell("");
                    else
                        $row->Cells[] = new TableCell("", self::$StatusColors[$tcVal->GetStatus()]);
                }
            }
        }

        // Return result
        return $template;
    }

    /**
     * Get template for dashboard
     * @param ProjectTSE $project
     * @return array
     */
    private static function GetTemplate(ProjectTSE $project)
    {
        // Init list of categories and tables
        $categories = array();
        $tables = array();

        // Iterate through submissions
        foreach ($project->GetSubmissions() as $submission)
        {
		// Iterate through categories
            foreach ($submission->GetCategories() as $category)
            {
		// Add category to array, if it doesnt already exists
                if (!array_key_exists($category->GetName(), $categories))
                    $categories[$category->GetName()] = array();

                // Iterate through test cases
                foreach ($category->GetTestCases() as $testCase)
                {
			// Add test case, if not present
                    if (!in_array($testCase->GetName(), $categories[$category->GetName()]))
                        $categories[$category->GetName()][] = $testCase->GetName();
                }
            }
        }

        // Fill table with data
        foreach ($categories as $category => $testCases)
        {
            // Create new table
		$table = new Table();
            $table->Header = $category;

            // Create empty header cell for test cases
            $table->HeaderRow =  new TableRow();
            $table->HeaderRow->Cells = array();
            $table->HeaderRow->Cells[] = new TableCell("");

            // Iterate through test cases
            foreach ($testCases as $testCase)
            {
                // Create new row
		$row = new TableRow();
                $row->Cells = array();

                // Create cell, that holds test case name
                $row->Cells[] = new TableCell($testCase);

                // Add row to table
                $table->Rows[] = $row;
            }

            // Add table to array
            $tables[] = $table;
        }

        // Return result
        return $tables;
    }
}

// Init array of colors
SystemTAP_Dashboard::Init();
