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
	exit(header("Location: http://acsftp.mckenneys.com/changePassword.html"));
}

$password = generatePassword(12);

list($year, $month, $day) = split('[-]', $date);
$expiration = $month."-".$day."-".$year; 
$command = "cmd.exe /c C:\inetpub\wwwroot\links\adminChangePass.lnk ".$username." ".$password." ".$expiration." ".$mail_to;
$output = shell_exec($command);

if($output!="The command completed successfully.\n\nThe command completed successfully.\n\n") {
	echo "<pre>Error: Problem changing password, please contact <a href='mailto:ithelpdesk@mckenneys.com'>ithelpdesk@mckenneys.com</a> for assistance.</pre>";
	
	$subject = "FTP Password Change Failure";
	$body .= "Problem changing password for an FTP site, please contact ithelpdesk@mckenneys.com for assistance.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
	$body .= "Email: $mail_to\r\n";
} else {
	echo "<pre>Success: The password was changed.</pre>";
	
	$subject = "FTP Password Change Success";
	$body = "The password for an FTP site was successfully changed.\r\n";
	$body .= "Navigate to ftp://acsftp.mckenneys.com/ to confirm the username and password are working correctly.\r\n";
	$body .= "Navigate to http://acsftp.mckenneys.com/changePassword.html#username=$username&email=$mail_to to change your password.\r\n";
	$body .= "Upload files by navigating to P:/".$username."/.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
	$body .= "Email: $mail_to\r\n";
}

echo sendEmail($mail_to, $subject, $body);

?>