<?php
$allowed = isloggedin();

if ($allowed) {

	if (recipeExistsID($postid) == false) {
		$query = "INSERT INTO `Recipe` (`RID`, `PostID`, `RcpTitle`, `RcpOrder`, `RcpActive`) VALUES (" . $postid . ", '" . $_SESSION["editPostID"] . "', '', 1, 'Y');";
		mysql_query($query) or die(mysql_error());
		$update = "RECIPE ADDED";
	};

	if ($_POST) {
		$sql = "DELETE FROM `RecipeItems` WHERE `RecipeID` = " . $postid;
		$result = mysql_query($sql) or die(mysql_error());

		for ($i = 25; $i >= 0; $i--) {

			$textline = sqlQuotes($_POST["TextLine" . $i]);

			if (strlen($textline) > 0) {
				$sql = "INSERT INTO `RecipeItems` (`RIID`, `RecipeID`, `TextLine`, `ItmActive`) VALUES (NULL, '" . $postid . "', '" . $textline . "', 'Y')";
				$result = mysql_query($sql) or die(mysql_error());
				$update = "SAVED";
			};
		};
		
		$sql = "UPDATE `foodblog`.`Recipe` SET `Difficulty` = '" . sqlQuotes($_POST["difficulty"]) . "', `PrepTime` = '" . sqlQuotes($_POST["preptime"]) . "', `CookTime` = '" . sqlQuotes($_POST["cooktime"]) . "', `Servings` = '" . sqlQuotes($_POST["servings"]) . "', `PrepInstructions` = '" . sqlQuotes($_POST["prepinstructions"]) . "', `RcpTitle` = '" . sqlQuotes($_POST["recipetitle"]) . "' WHERE `Recipe`.`RID` = " . $postid . ";";
		$result = mysql_query($sql) or die(mysql_error());

	};
};
echo "<h1>RECIPE EDITOR " . $update . "</h1>";
echo "<form id='RecipeEditor' action='#' method='post'>";
echo "<table class=postpadding>";

echo "<h2>PREPARATION:</h2>";
$sql = "SELECT `Difficulty`, `PrepTime`, `CookTime`, Servings, `PrepInstructions`, `RcpTitle`  FROM `Recipe` WHERE `RID` = " . $postid;
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($result)) {
	$difficulty = $row["Difficulty"];
	$preptime = $row["PrepTime"];
	$cooktime = $row["CookTime"];
	$servings = $row["Servings"];
	$prepinstructions = $row["PrepInstructions"];
	$recipetitle = $row["RcpTitle"];
}

echo "<table>";
echo "<tr><td>Title (Optional):</td><td><input type='text' name='recipetitle' value='" . $recipetitle . "' size='60' /></td></tr>";
echo "<tr><td>Difficulty:</td><td>" . diffDropDown($difficulty) . "</td></tr>";
echo "<tr><td>Preparation Time:</td><td><input type='text' name='preptime' id='preptime' value='" . $preptime . "' /></td></tr>";
echo "<tr><td>Cook Time:</td><td><input type='text' name='cooktime' id='cooktime' value='" . $cooktime . "' /></td></tr>";
echo "<tr><td>Servings:</td><td>" . servingsDropDown($servings) . "</td></tr>";
echo "</table>";
echo "<p>Preparation Instructions:</p>";
echo "<textarea name='prepinstructions' id='prepinstructions' style='width:99%;height:200px;'>" . $prepinstructions . "</textarea><br />";

echo "<h2>INGREDIENTS:</h2>";
$sql = "SELECT `TextLine` FROM `RecipeItems` WHERE `RecipeID` = " . $postid . " and `ItmActive` = 'Y' Order By RIID Desc";
$result = mysql_query($sql) or die(mysql_error());
$recipeItemCount = 1;
while ($row = mysql_fetch_array($result)) {
	echo "<p><input type='text' size='150' name='TextLine" . $recipeItemCount . "' id='TextLine" . $recipeItemCount . "' value='" . $row["TextLine"] . "' /></p>";
	$recipeItemCount++;
};

for ($i = $recipeItemCount; $i <= 25; $i++) {
	echo "<p><input type='text' size='150' name='TextLine" . $i . "' id='TextLine" . $i . "' /></p>";
}

echo "</table>";
echo "<p><input type='submit' value='Save' /></form></p></div>";
?>