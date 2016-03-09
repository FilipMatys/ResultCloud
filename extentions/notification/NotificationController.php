<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class NotificationController
{
    static private $Notifiers = array();
    static public function notify($title, $body, $to)
    {
        $validation = new ValidationResult(array());
        foreach ($to as $notify_id => $adresses) {
            (self::$Notifiers)->notify($title, $body, $adresses);
        }
        return $validation;
    }

    static public function preLoad()
    {
        foreach (glob(dirname(__FILE__).DIRECTORY_SEPARATOR."notifiers".DIRECTORY_SEPARATOR."*.php") as $value) {
            include_once($value);
            $name = str_replace(dirname(__FILE__).DIRECTORY_SEPARATOR."notifiers".DIRECTORY_SEPARATOR, "", str_replace(".php", "", $value));
            self::$Notifiers[$name::NOTIFY_ID] = new $name();
        }
    }

    static public function getNotifyIds()
    {
        return array_keys(self::$Notifiers);
    }
}

NotificationController::preLoad();