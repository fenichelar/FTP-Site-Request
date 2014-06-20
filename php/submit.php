<?php

require 'functions.php';

$username = "";
$date = "";
$expiration = "";
$mail_to = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = sanitizeText($_POST["username"]);
	$date = sanitizeText($_POST["expiration"]);
	$mail_to = sanitizeText($_POST["email"]);
} else {
	exit(header("Location: http://acsftp.mckenneys.com/"));
}

$password = generatePassword(12);

list($year, $month, $day) = split('[-]', $date);
$expiration = $month."-".$day."-".$year; 
$command = "cmd.exe /c C:\inetpub\wwwroot\links\adminSetupFTP.lnk ".$username." ".$password." ".$expiration." ".$mail_to;
$output = shell_exec($command);

if($output!="The command completed successfully.\n\n") {
	echo "<pre>Error: The username you have selected is most likely already taken, please try another. If the problem persists, contact <a href='mailto:ithelpdesk@mckenneys.com'>ithelpdesk@mckenneys.com</a> for assistance.</pre>";
	
	$subject = "FTP Request Failure";
	$body = "An FTP site failed to be created.\r\n";
	$body .= "The username you have selected is most likely already taken, please try another. If the problem persists, contact ithelpdesk@mckenneys.com for assistance.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
	$body .= "Email: $mail_to\r\n";
} else {
	echo "<pre>Success: The account was created.</pre>";
	
	$subject = "FTP Request Success";
	$body = "An FTP site was successfully created.\r\n";
	$body .= "Navigate to ftp://acsftp.mckenneys.com/ to access the FTP Site.\r\n";
	$body .= "Navigate to http://acsftp.mckenneys.com/changePassword.html#username=$username&email=$mail_to to change your password.\r\n";
	$body .= "Upload files by navigating to P:/".$username."/.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
	$body .= "Email: $mail_to\r\n";
}

echo sendEmail($mail_to, $subject, $body);

?>