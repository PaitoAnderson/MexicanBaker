<?php
$allowed = isloggedin();

if ($allowed) {
	if ($_POST) {
		$formPublished = $_POST['selPublished'];
		$formAuthor = $_POST['selAuthor'];
		$formPostDate = date('Y-m-d H:i:s',strtotime($_POST['inputDate']));
		$formPostTitle = $_POST['postTitle'];
		$formPostTitle = str_replace("'","\'",$formPostTitle);
		$formPostDescription = $_POST['postDescription'];
		$formPostDescription = str_replace("'","\'",$formPostDescription);
		$formPostUrl = $_POST['postUrl'];
		$formPostBody = $_POST['postBody'];
		$formPostBody = str_replace("'","\'",$formPostBody);
		$formHomepage = $_POST['selHomepage'];
		$formMetatags = $_POST['metaTags'];
		$formCat = $_POST['selCat'];
		$formCredit = $_POST['selCredit'];
		$formCreditName = $_POST['creditName'];
		$formCreditUrl = $_POST['creditUrl'];
		$toppostcount = newPostNumber() - 1;
		if ($postid > $toppostcount) {
			$newpost = True;
			$sqlcolumns = "`PstTitle`,`PstBody`,`PstActive`,`AuthorID`,`PstDate`,`PstHomePage`,`PstDescription`,`PstURL`,`CreditID`,`CreditName`,`CreditURL`,`Metatags`,`PostCat`";
			$query = "INSERT INTO `Post` (`PID`," . $sqlcolumns . ") VALUES (NULL, '" . sqlQuotes($formPostTitle) . "', '$formPostBody', '$formPublished', $formAuthor, '$formPostDate', '$formHomepage', '$formPostDescription', '$formPostUrl', '$formCredit', '$formCreditName', '$formCreditUrl', '$formMetatags', $formCat);";
			//echo $query;
			mysql_query($query) or die(mysql_error());
			$update = "POST ADDED";
		} else {
			$newpost = False;
			$query = "UPDATE `Post` SET `PstTitle`='$formPostTitle',`PstBody`='$formPostBody',`PstActive`='$formPublished',`AuthorID`='$formAuthor',`PstDate`='$formPostDate',`PstHomePage`='$formHomepage',`PstDescription`='$formPostDescription',`PstURL`='$formPostUrl',`CreditID`='$formCredit',`CreditName`='$formCreditName',`CreditURL`='$formCreditUrl',`Metatags`='$formMetatags',`PostCat`='$formCat' WHERE `PID`=" . $postid . ";";
			//echo $query;
			mysql_query($query) or die(mysql_error("ERROR"));
			$update = "SAVED";
		}
		

		//Re-Read Data from DB
		$postdetails = post($postid);
		$postdetails = explode("|", $postdetails);
	}
}
$pagetitle = $postdetails[0];
$postdate = date('m/d/Y',strtotime($postdetails[4]));
$postdescription = $postdetails[5];
$posturl = $postdetails[6];
$creditname = $postdetails[8];
$crediturl = $postdetails[9];
$metatags = $postdetails[10];
$aid = $postdetails[11];
$cid = $postdetails[12];
$active = $postdetails[13];
$homepage = $postdetails[14];
$catid = $postdetails[15];

$_SESSION['editPostID'] = $postid;

echo "<h1>POST BUILDER " . $update . "</h1>";
echo "<form id='PostBuilder' action='#' method='post'>";

echo "<table class=postpadding>";
//echo "<tr><td>Internal Post ID:</td><td>" . $postid . "</td></tr>";
//echo "<tr><td>Next Post ID:</td><td>" . newpostnum() . "</td></tr>";
echo "<tr><td>Preview Post:</td><td><a class=\"link\" target=\"_blank\" href=\"/post/" . $postid . "/" . $posturl . "\">Preview Post</a></td></tr>";
echo "<tr><td><label for='selPublished'>Published:</label></td><td>" . yesno($active, "selPublished") . "</td></tr>";
echo "<tr><td><label for='selAuthor'>Author:</label></td><td>" . authoroption($aid) . "</td></tr>";
echo "<tr><td><label for='inputDate'>Publish Date:</label></td><td><input type='text' style='padding:0px;height:19px;width:100px;' class='inputDate' name='inputDate' id='inputDate' value='" . $postdate . "' /></td></tr>";
echo "<tr><td><label for='postTitle'>Post Title:</label></td><td><input type='text' style='padding:0px;height:19px;width:200px;' name='postTitle' id='postTitle' value = '" . $pagetitle . "' /></td></tr>";
echo "<tr><td><label for='postDescription'>Post Description:</label></td><td><input type='text' style='padding:0px;height:19px;width:600px;' name='postDescription' id='postDescription' value = '" . $postdescription . "' /></td></tr>";
echo "<tr><td><label for='postUrl'>Post URL:</label></td><td><input type='text' style='padding:0px;height:19px;width:300px;' name='postUrl' id='postUrl' value = '" . $posturl . "' /> (Example: 'chicken-is-delicious')</td></tr>";
echo "<tr><td><label for='selHomepage'>Feature on Homepage:</label></td><td>" . yesno($homepage, "selHomepage");
if (presentationPic($postid)) {
	echo " <font color=\"green\"><b>PIC FOUND</b></font>";
} else {
	echo " <font color=\"red\"><b>PIC NOT FOUND</b></font>";
};
echo "</td></tr>";
echo "<tr><td><label for='selCat'>Categories:</label></td><td>" . catoption($catid) . "</td></tr>";
echo "<tr><td><label for='metaTags'>Meta tags:</label></td><td><input type='text' style='padding:0px;height:19px;width:600px;' name='metaTags' id='metaTags' value = '" . $metatags . "' /></td></tr>";
echo "<tr><td><label for='selCredit'>Credit Type:</label></td><td>" . creditoption($cid) . "</td></tr>";
echo "<tr><td><label for='creditName'>Display Credit As:</label></td><td><input type='text' style='padding:0px;height:19px;width:300px;' name='creditName' id='creditName' value = '" . $creditname . "' /></td></tr>";
echo "<tr><td><label for='creditUrl'>Link Credit To:</label></td><td><input type='text' style='padding:0px;height:19px;width:600px;' name='creditUrl' id='creditUrl' value = '" . $crediturl . "' /></td></tr>";
echo "</table>";

echo "<textarea name='postBody' id='postBody' style='width:99%;height:500px;'>" . $postdetails[1] . "</textarea><br />";

for ($i = 1; $i <= 25; $i++) {
	if (strpos($postdetails[1],"%img". $i . "%") !== false) {
		if (postPic($postid, $i)) {
			echo "<font color=\"green\"><b>IMAGE " . $i . " FOUND</b></font><br />";
		} else {
			echo "<font color=\"red\"><b>IMAGE " . $i . " NOT FOUND</b></font><br />";
		};
	};
};

echo "<br />";

for ($i = 1; $i <= 25; $i++) {
	if (strpos($postdetails[1],"%recipe". $i . "%") !== false) {
		$result = recipeExists($postid, $i);
		if ($result == "FALSE") {
			echo "<font color=\"red\"><b>RECIPE " . $i . " NOT FOUND - <a href=\"../recipe/" . newRecipeNumber() . "\">CREATE</a></b></font><br />";
		} else {
			echo "<font color=\"green\"><b>RECIPE " . $i . " FOUND - <a href=\"../recipe/" . $result . "\">EDIT</a></b></font><br />";
		};
	};
};

echo "<p><input type='submit' value='Save' /></form></p></div>";
?>