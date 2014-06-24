<?php

require 'C:\inetpub\wwwroot\php\functions.php';

$username = $argv[1];
$mail_to = $argv[2];
$expiration = $argv[3];

$subject = "FTP Site Expiration Notice";
$body = "An FTP site is about to expire.\r\n";
$body .= "Navigate to http://acsftp.mckenneys.com/changePassword.html#username=$username&email=$mail_to to change your password.\r\n";
$body .= "Username: $username\r\n";
$body .= "Expiration: $expiration\r\n";
$body .= "Email: $mail_to\r\n";

sendEmail($mail_to, $subject, $body);

?>
