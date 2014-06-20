<?php

require 'PHPMailerAutoload.php';

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

function sendEmail($mail_to, $subject, $body) {
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = "192.168.210.123";
	$mail->Port = 25;
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->ContentType = 'text/plain';
	$mail->SetFrom("ftprequest@mckenneys.com", "FTP Request");
	$mail->AddCC("ithelpdesk@mckenneys.com", "IT Help Desk");
	$mail->AddAddress($mail_to);

	if(!$mail->Send()) {
		return "<pre>Mailer Error: " .$mail->ErrorInfo."</pre>";
	} else {
		return "<pre>Instructions have been sent to your email.</pre>";
	}
}

?>