<?php
include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Library.utility.php');

Library::using(Library::UTILITIES);
Library::using(Library::CORLY_SERVICE_FACTORY, ['FactoryService.class.php']);

class NotificationController
{
    static private $Notifiers = array();
    static public function notify($title, $body, $bodyShort, $to)
    {
        $validation = new ValidationResult(array());
        foreach ($to as $notify_id => $adresses) {
            $notifier = self::$Notifiers[$notify_id];
            $notifier->notify($title, $body, $bodyShort, $adresses);
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

    static public function getPrivateNotifiers()
    {
        $private = array();
        foreach (self::$Notifiers as $key => $value) {
            if (!$value::NOTIFIER_PUBLIC)
                $private[] = $key;
        }

        return $private;
    }

    static public function getNotifierById($id)
    {
        if (!isset(self::$Notifiers[$id]))
            return null;
        return self::$Notifiers[$id];
    }
}

NotificationController::preLoad();