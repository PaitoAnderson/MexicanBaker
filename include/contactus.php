<?php
date_default_timezone_set('America/Toronto');

if ($_POST) {
	$name1 = strip_tags($_POST['name']);
	$email = strtolower(strip_tags($_POST['email']));
	$subject = strtolower(strip_tags($_POST['subject']));
	$comment1 = strip_tags($_POST['comment']);
	

	//Email Paito/Linda about a new comment.
	$to = "pj.paito@gmail.com, lindadyckenns@gmail.com";
	$subject = "Mexican Baker - " . $subject;
	$theirname = "From: " . $name1 . "\r\r\n\r\r\n";
	$theiremail = "\r\r\n\r\r\nE-Mail them at: " . $email;
	$theirip = "\r\r\n\r\r\nIP Address: " . $_SERVER['REMOTE_ADDR'];
	
	$body = $theirname . "Message Left: \r\r\n" . $comment1 . $theiremail . $theirip;
	$headers = "From: contactus@mexicanbaker.com\r\nX-Mailer: php";

	//Send EMail
	mail($to, $subject, $body, $headers);

	echo "Message Send Successfully!";
}
?>