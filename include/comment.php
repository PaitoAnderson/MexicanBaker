<?php
date_default_timezone_set('America/Toronto');
if ($_GET) {
	require("dbconnect.php");
	require("elements.php");
	$post_id = strip_tags($_GET['post_id']);
	$type = $_GET['type'];
	if ($type == "hide") {
		session_start();
		if ($_SESSION['auth'] == "1") {
			$query = "UPDATE `Comments` Set `Hidden` = 'Y' Where CID = " . sqlQuotes($post_id);
			mysql_query($query) or die(mysql_error());
			echo "Comment Hidden.";
		} else {
			echo "Unauthorized!";
		}
	}
}

if ($_POST) {
	require("dbconnect.php");
	require("elements.php");
	$name1 = strip_tags($_POST['name']);
	$email = strtolower(strip_tags($_POST['email']));
	$website = strtolower(strip_tags($_POST['website']));
	$comment1 = strip_tags($_POST['comment']);
	$post_id = strip_tags($_POST['post_id']);
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$lowercase = strtolower($website);
	
	$query = "INSERT INTO `Comments` (`CID`,`PostID`,`ComName`,`ComEmail`,`ComWebsite`,`ComBody`,`CommentDate`,`IPAddress`) VALUES (NULL , '" . sqlQuotes($post_id) . "', '" . sqlQuotes($name1) . "', '" . sqlQuotes($email) . "', '" . sqlQuotes($website) . "', '" . sqlQuotes($comment1) . "', NOW(), '$ipaddress');";

	mysql_query($query) or die(mysql_error());

	//Email Paito/Linda about a new comment.
	$to = "XXXX@gmail.com, XXXX@gmail.com";
	$subject = "Mexican Baker - New Comment from " . $name1;
	if (strlen($website) > 3) {
		$theirwebsite = "\r\r\n\r\r\nVisit Their Webite:" . $website;
	}
	$body = "Comment Left:\r\r\n" . $comment1 . $theirwebsite . "\r\r\nVisit Post:http://www.mexicanbaker.com/post/" . $post_id . "#comments";
	$headers = "From: comments@mexicanbaker.com\r\nX-Mailer: php";
	//if (strlen($email) > 3) {
		//$headers = "From: " . $email . "\r\nX-Mailer: php";
	//}
	mail($to, $subject, $body, $headers);

	echo "<li class=\"comment\"><article><img alt=\"\" src=\"http://www.gravatar.com/avatar/" .md5($email). "?s=50&d=mm&r=g\" class=\"avatar\" height=\"50\" width=\"50\"><div class=\"comment-meta\"><h5 class=\"author\"><cite class=\"fn\">";

	if ($lowercase != '') {
		echo "<a class=\"coollink\" target=\"_blank\" href=\"" . $lowercase . "\">" . $name1 ."</a>";
	} else {
		echo $name1;
	}
	echo "</cite></h5><p class=\"date2\"><time pubdate=\"\" datetime=\"" . date('Y-m-d\TH:i:sP') ."\">" . date('F d, Y H:i') . "</time></p></div><div class=\"comment-body\"><p>" . $comment1 . "</p></div></article></li>";
	
}
?>