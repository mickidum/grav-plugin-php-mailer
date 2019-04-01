<?php
namespace Grav\Plugin\PHPemail;

use Grav\Common\Config\Config;
use Grav\Common\Grav;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

class PHPemail
{
    function __construct($message = null)
    {
        $this->message = $message;
    }

    public function send()
    {
        if ($this->message && is_array($this->message)) {

            $to = $this->message['to']['mail'];
            $from = $this->message['from']['mail'];
            $from_name = $this->message['from']['name'];
            $subject = $this->message['subject'] ? $this->message['subject'] : 'New message from your website';
            $body = $this->message['body'];

            $message_header = "<table style='border: dotted 1px #bfbfbf;'><tr><th colspan='2'><h2 style='margin:0;'><strong>{$subject}</strong></h2></th></tr>";
            $message_footer = "</table>";     
            $message = "";

            if (!$body) {
                die("error while sending mail");
            }

            $headers = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From:"'.$from_name.'" <'.$from.'>';

            // echo $headers;
            // echo $to;

            $message .= "<tr><th style='padding: 10px;border-top:dotted 1px #000;border-left:dotted 1px #000;'><strong>Details</strong></th><td style='padding:10px;border-top:dotted 1px #000;'>{$body}</td>";
            $message = $message_header.$message.$message_footer;
            // echo $message;
            // echo 'sent successful';
            try {
                mail($to, $subject, $message, $headers);
            } catch (Exception $e) {
                echo "error sending mail";
            }
            
        }
    }

}