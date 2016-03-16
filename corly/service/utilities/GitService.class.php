<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

// Get libraries
Library::using(Library::UTILITIES);

/**
 * GitService short summary.
 *
 * GitService description.
 *
 * @version 1.0
 * @author Filip
 */
class GitService
{
    // TODO: --mirror
    // Clone repo
    // Remove repo

    /**
     * Open git repository
     *
     * Opens git repostitory and returns git wrapper object
     * @param string repository folder
     * @return Git git wrapper
     */
    public static function Open($repo)
    {
        // For windows enviroment Git::windows_mode();   
        return Git::open(Library::path(Library::CORLY_REPOSITORIES, $repo));       
    }


}