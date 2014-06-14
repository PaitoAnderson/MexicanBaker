<?php
$allowed = isloggedin();

if ($allowed) {
	if ($_POST) {
		$IngredientName = $_POST['IngredientName'];
		$query = "INSERT INTO `Ingredients` (`IID`,`IngName`,`IngDescription`,`IngActive`) VALUES (NULL, '$IngredientName','','Y');";
		mysql_query($query) or die(mysql_error());
		$update = " - ADDED";
	}
}

echo "<h1>INGREDIENTS " . $update . "</h1>";
echo "<form id='PostBuilder' action='#' method='post'>";

echo "<table class=postpadding>";
echo "<input type='text' name='IngredientName' size='60' placeholder='Ingredient Name'>";

echo "</table>";
echo "<input type='submit' value='Add' /></form><br />";
?>