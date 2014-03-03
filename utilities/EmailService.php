<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 2.2.14
 * Time: 18:11
 */

class EmailService {

    private $To;
    private $From;
    private $Subject;
    private $Message;

    /**
     * Init mail service
     */
    public function __construct($to, $from, $subject, $message)   {
        $this->To = $to;
        $this->From = $from;
        $this->Subject = $subject;
        $this->Message = $message;
    }

    /**
     * Send email
     */
    public function Send()  {
        mail($this->To,
            $this->Subject,
            $this->Message,
            "From: $this->From");
    }
} 