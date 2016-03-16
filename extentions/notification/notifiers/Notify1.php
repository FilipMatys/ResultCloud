<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::EXTENTIONS_NOTIFICATION);

class Notify1 extends BaseNotifier
{
    const NOTIFY_ID = "notify1";
    const NOTIFIER_PUBLIC = false;
    public function notify($title, $body, $bodyShort, $to)
    {
    	error_log("//----------------------------------------\nwork notify1");
        
    }
}
