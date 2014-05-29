<?php
$username = "";
$password = "";
$date = "";
$expiration = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = sanitizeText($_POST["username"]);
	$password = sanitizeText($_POST["password"]);
	$date = sanitizeText($_POST["expiration"]);
} else {
	exit(header("Location: http://mckatlftp2012/"));
}

list($year, $month, $day) = split('[-]', $date);
$expiration = $month."-".$day."-".$year; 
$command = "cmd.exe /c C:\inetpub\wwwroot\adminSetupFTP.lnk ".$username." ".$password." ".$expiration;
$output = shell_exec($command);

if($output!="The command completed successfully.\n\n") {
	echo "<pre>Error: The username you have selected is most likely already taken, please try another. If the problem persists, contact <a href='mailto:ithelpdesk@mckenneys.com'>ithelpdesk@mckenneys.com</a> for assistance.</pre>";
	
	$subject = "FTP Request Failure";
	$body = "An FTP site failed to be created.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
} else {
	echo "<pre>Username: $username</pre>";
	echo "<pre>Password: $password</pre>";
	echo "<pre>Expiration: $expiration</pre>";
	echo "<pre>Navigate to <a href='ftp://acsftp.mckenneys.com/' target='_blank'>ftp://acsftp.mckenneys.com/</a> to confirm the username and password are working correctly.</pre>";
	echo "<pre>Upload files by navigating to <a href='P:/".$username."/'>P:/".$username."/</a>.</pre>";
	
	$subject = "FTP Request Success";
	$body = "An FTP site was successfully created.\r\n";
	$body .= "Username: $username\r\n";
	$body .= "Password: $password\r\n";
	$body .= "Expiration: $expiration\r\n";
}

$mail_to = "ithelpdesk@mckenneys.com";
$mail_from = "ithelpdesk@mckenneys.com";

$headers = "From: ".$mail_from."\r\n";

$mail_status = mail($mail_to, $subject, $body, $headers);

function sanitizeText($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>