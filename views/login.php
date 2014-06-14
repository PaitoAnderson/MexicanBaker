<?php
$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (strlen($email) > 0) {

	$loginstatus = validate($email, $password);

	if ($loginstatus == "FAILED") {
		$update =  "FAILED";
	} else {
		$_SESSION['auth'] = "1";
		$_SESSION['user'] = $loginstatus;
		$update =  "SUCCESSFUL";
		header("Location: /");
	}
}elseif ($_SESSION['auth'] == "1") {
	session_destroy();
	header("Location: /");
}
?>
	<div class="postbody">
	<h1>LOGIN <?php echo($update); ?></h1>
		<form id="myForm" action="#" method="post">
			<p><label for="email">Email</label>
				<input style="height:19;padding:0px;" id="email" type="email" name="email"/>
			
			<label for="password">Password</label>
				<input style="height:19;padding:0px;" id="password" type="password" name="password"/>
			</p>
			<p><input type="submit" value="Login" /></p>
		</form>
	</div>
</div>