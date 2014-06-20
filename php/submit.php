<?php

require 'PHPMailerAutoload.php';

$username = "";
$date = "";
$expiration = "";
$mail_to = "";

$mail = new PHPMailer();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = sanitizeText($_POST["username"]);
	$date = sanitizeText($_POST["expiration"]);
	$mail_to = sanitizeText($_POST["email"]);
} else {
	exit(header("Location: http://mckatlftp2012/"));
}

$password = generatePassword(12);

list($year, $month, $day) = split('[-]', $date);
$expiration = $month."-".$day."-".$year; 
$command = "cmd.exe /c C:\inetpub\wwwroot\adminSetupFTP.lnk ".$username." ".$password." ".$expiration." ".$mail_to;
$output = shell_exec($command);

if($output!="The command completed successfully.\n\n") {
	echo "<pre>Error: The username you have selected is most likely already taken, please try another. If the problem persists, contact <a href='mailto:ithelpdesk@mckenneys.com'>ithelpdesk@mckenneys.com</a> for assistance.</pre>";
	
	$subject = "FTP Request Failure";
	$body = "An FTP site failed to be created.\r\n";
	$body .= "The username you have selected is most likely already taken, please try another. If the problem persists, contact ithelpdesk@mckenneys.com for assistance.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
} else {
	echo "<pre>Success: The account was created.</pre>";
	
	$subject = "FTP Request Success";
	$body = "An FTP site was successfully created.\r\n";
	$body .= "Navigate to ftp://acsftp.mckenneys.com/ to confirm the username and password are working correctly.\r\n";
	$body .= "Upload files by navigating to P:/".$username."/.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
}

$mail->IsSMTP();
$mail->Host = "192.168.210.123";
$mail->Port = 25;
$mail->Subject = $subject;
$mail->Body = $body;
$mail->ContentType = 'text/plain';
$mail->SetFrom("ithelpdesk@mckenneys.com", "IT Help Desk");
$mail->AddCC("ithelpdesk@mckenneys.com", "IT Help Desk");
$mail->AddAddress($mail_to);

if(!$mail->Send()) {
	echo "<pre>Mailer Error: " .$mail->ErrorInfo."</pre>";
} else {
	echo "<pre>Instructions have been sent to your email.</pre>";
}

function sanitizeText($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function generatePassword($len) {
	$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$password_characters = str_split($characters);
	$password='';

	for($i=0;$i<$len;$i++) {
		$password.=$password_characters[rand(0,count($password_characters)-1)];
	}

	return $password;
}

?>