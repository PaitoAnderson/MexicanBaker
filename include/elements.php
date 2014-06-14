<?php
function post($postid) {
	$pagetitle = "Post Title #" . $postid;
	$postbody = "";
	$postdesc = "";

	$post = "SELECT Post.PstTitle, Post.PstBody, Authors.AthFirstName, Authors.AthLastName, Post.PstDate, Post.PstDescription, Post.PstUrl, Credits.CreditType, Post.CreditName, Post.CreditURL, Post.Metatags, Authors.AID, Credits.CID, Post.PstActive, Post.PstHomePage, Post.PostCat FROM Post, Authors, Credits WHERE PID = " . $postid . " and Post.AuthorID = Authors.AID  and Post.CreditID = Credits.CID";

	$result = mysql_query($post) or die(mysql_error());

	if(mysql_num_rows($result) == 0){
		$error = "1";
	};
	
	while ($row = mysql_fetch_array($result)) {
		$postdata = $row["PstTitle"] . "|" . $row["PstBody"] . "|" . $row["RecipeID"] . "|" . $row["AthFirstName"] . " " . $row["AthLastName"] . "|" . $row["PstDate"] . "|" . $row["PstDescription"] . "|" . $row["PstUrl"] . "|" . $row["CreditType"] . "|" . $row["CreditName"] . "|" . $row["CreditURL"] . "|" . $row["Metatags"] . "|" . $row["AID"] . "|" . $row["CID"] . "|" . $row["PstActive"] . "|" . $row["PstHomePage"] . "|" . $row["PostCat"];
	};
	
	return $postdata;
};

function posts($thispage, $perpage) {
	//Pagination Logic
	$pageend = ($thispage * $perpage);
	$pagestart = $pageend - $perpage;

	$postdata = "";
	$posts = "SELECT Post.PstTitle, Post.PstBody, Authors.AthFirstName, Authors.AthLastName, Post.PstDate, Post.PstDescription, Post.PstUrl, Credits.CreditType, Post.CreditName, Post.CreditURL, Post.Metatags, Authors.AID, Credits.CID, Post.PID FROM Post, Authors, Credits WHERE Post.AuthorID = Authors.AID  and Post.CreditID = Credits.CID and Post.PstActive = 'Y' ORDER BY Post.PstDate DESC LIMIT " . $pagestart . "," . $pageend;

	$result = mysql_query($posts) or die(mysql_error());
	
	while ($row = mysql_fetch_array($result)) {
		$postdata = $postdata . $row["PstTitle"] . "|" . $row["PstBody"] . "|" . $row["RecipeID"] . "|" . $row["AthFirstName"] . " " . $row["AthLastName"] . "|" . $row["PstDate"] . "|" . $row["PstDescription"] . "|" . $row["PstUrl"] . "|" . $row["CreditType"] . "|" . $row["CreditName"] . "|" . $row["CreditURL"] . "|" . $row["Metatags"] . "|" . $row["AID"] . "|" . $row["CID"] . "|" . $row["PID"] . "|-|";	
	};
	
	return $postdata;
};

function getSlides() {
	$slides = "SELECT `PID`, `PstTitle`, `PstURL` FROM `Post` WHERE `PstActive` = 'Y' and `PstHomePage` = 'Y' ORDER BY `PID` DESC";

	$result = mysql_query($slides) or die(mysql_error());
	
	$slidedata = "<div id=\"slides\">";

	while ($row = mysql_fetch_array($result)) {
		//$slidedata = $slidedata . "<a href=\"/post/" . $row["PID"] . "/" . $row["PstURL"] . "\" title=\"\"><img src=\"/images/posts/" . $row["PID"] . "/presentation.jpg\" width=\"950\" height=\"350\" alt=\"" . $row["PstTitle"] . "\"></a><div class=\"caption\"><p>" . $row["PstTitle"] . "</p></div>";
		$slidedata = $slidedata . "<a href=\"/post/" . $row["PID"] . "/" . $row["PstURL"] . "\" title=\"\"><img src=\"/images/posts/" . $row["PID"] . "/presentation.jpg\" alt=\"" . $row["PstTitle"] . "\"></a>";
	};

	$slidedata = $slidedata . "</div>";
	
	return $slidedata;
}

function postgroups($postid) {
	$sql = "SELECT Groups.GrpTitle FROM Groups, PostGroups WHERE PostGroups.PostID = " . $postid . " and Groups.GID = PostGroups.GroupID";
	$result = mysql_query($sql) or die(mysql_error());
	
	while ($row = mysql_fetch_array($result)) {
		If ($grouplist == "") {
			$grouplist = $grouplist . $row["GrpTitle"];
		} else {
			$grouplist = $grouplist . "|" . $row["GrpTitle"];
		};
	};
	return $grouplist;
};

function draftList() {
	$draftdata = "";
	$sql = "SELECT `PID`, `PstTitle` FROM `Post` WHERE `PstActive` = 'N' ORDER BY PID DESC";
	$result = mysql_query($sql) or die(mysql_error());
	
	while ($row = mysql_fetch_array($result)) {
		$draftdata = $draftdata . $row["PID"] . "|" . $row["PstTitle"] . "|-|";
	};
	return $draftdata;
}

function presentationPic($postid) {
	$filename = "/home/mexicanbaker/images/posts/" . $postid . "/presentation.jpg";

	if (file_exists($filename)) {
		return true;
	} else {
		return false;
	};
};

function postPic($postid, $imgid) {
	$filename = "/home/mexicanbaker/images/posts/" . $postid . "/image" . $imgid . ".jpg";

	if (file_exists($filename)) {
		return true;
	} else {
		return false;
	};
};

function postcount() {
	$sql = "SELECT `PID` FROM `Post` WHERE `PstActive` = 'Y'";
	$result = mysql_query($sql) or die(mysql_error());
	$numcount = mysql_num_rows($result);
	return $numcount;
};

function commentcount($postid) {
	$sql = "SELECT `CID` FROM `Comments` WHERE `PostID` = $postid";
	$result = mysql_query($sql) or die(mysql_error());
	$numcount = mysql_num_rows($result);
	return $numcount;
};

function commenthtml($postid) {
	$sql = "SELECT `ComBody`,`CommentDate`,`ComName`,`ComEmail`,`ComWebsite`,`CID` FROM `Comments` WHERE `PostID` = " . $postid . " AND `Hidden` = 'N' ORDER BY `CID` ASC";
	$result = mysql_query($sql) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$commentout .= "<li class='comment'><article>";
		$commentout .= "<img alt='' src='" . get_gravatar($row["ComEmail"],50,"mm","g",false) . "' class='avatar' height='50' width='50'>";
		$commentout .= "<div class='comment-meta'>";
		$commentout .= "<h5 class='author'><cite class='fn'>";
		if (strlen($row["ComWebsite"]) > 0) {
			if (preg_match("#https?://#", $row['ComWebsite']) === 0) {
				$commentout .= "<a class='coollink' target='_blank' href='http://" . $row["ComWebsite"] . "'>" . $row["ComName"] . "</a>";
			} else {
				$commentout .= "<a class='coollink' target='_blank' href='" . $row["ComWebsite"] . "'>" . $row["ComName"] . "</a>";
			}
		} else {
			$commentout .= $row["ComName"];
		};
		if ($_SESSION['auth'] == "1") {
			$commentout .= "<span class='hidecomment'><a target='_blank' href='/include/comment.php?type=hide&post_id=" . $row["CID"] . "'>Hide Comment</a></span>";
		}
		$commentout .= "</cite></h5><p class='date2'><time pubdate='' datetime='" . date('Y-m-d\TH:i:sP', strtotime($row["CommentDate"])) . "'>". date('F d, Y H:i', strtotime($row["CommentDate"])) ."</time></p></div>";
		$commentout .= "<div class='comment-body'><p>" .  $row['ComBody'] . "</p></div></article></li>";
	};

	return $commentout;
};

function recipehtml($postid, $posttitle, $recipeorder) {
	$sql = "SELECT RcpTitle, Difficulty, PrepTime, CookTime, Servings, PrepInstructions, RID FROM Recipe WHERE PostID = " . $postid . " and RcpOrder = " . $recipeorder;
	$result = mysql_query($sql) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$rcptitle = $row["RcpTitle"];
		$difficulty = $row["Difficulty"];
		$preptime = $row["PrepTime"];
		$cooktime = $row["CookTime"];
		$servings = $row["Servings"];
		$prepinstructions = $row["PrepInstructions"];
		$recipeid = $row["RID"];
	};
	
	if (strlen($rcptitle) == 0) {
		$rcptitle = $posttitle;
	}

	$sql = "SELECT RecipeItems.TextLine FROM Recipe, RecipeItems WHERE RecipeItems.RecipeID = Recipe.RID and Recipe.PostID = " . $postid . " and Recipe.RcpOrder = " . $recipeorder . " Order By RecipeItems.RIID Desc";
	$result = mysql_query($sql) or die(mysql_error());

	$recipeout = "</p><div class='recipecard' itemscope itemtype=\"http://data-vocabulary.org/Recipe\">";
	
	$recipeout .= "<p class='postbody recipeprintbutton'><a target='_blank' href='/print/" . $recipeid . "'>PRINT</a>";
	
	$recipeout .= "<h2 itemprop=\"name\">" . $rcptitle . "</h2>";

	$preptimes = explode(":", $preptime);
	$cooktimes = explode(":", $cooktime);
	
	$recipeout .= "<span class='recipedetails'>DIFFICULTY: " . diffLabel($difficulty) . " &#149; PREP TIME: <time datetime=\"PT" . $preptimes[0] . "H" . $preptimes[1] . "M\" itemprop=\"preptime\">" . $preptime . "</time> &#149; COOK TIME: <time datetime=\"PT" . $cooktimes[0] . "H" . $cooktimes[1] . "M\" itemprop=\"cookTime\">" . $cooktime . "</time> &#149; SERVINGS: " . $servings . "</span><br /><br />";
	
	$recipeout .= "<h2>INGREDIENTS:</h2><ul>";
	
	while ($row = mysql_fetch_array($result)) {
		if(stristr($row["TextLine"], '<b>') === FALSE) {
			$recipeout .= "<li itemprop=\"ingredient\" itemscope itemtype=\"http://data-vocabulary.org/RecipeIngredient\"><span itemprop=\"name\">" . $row["TextLine"] . "</span></li>";
		} else {
			$recipeout .= "<li itemprop=\"ingredient\" itemscope itemtype=\"http://data-vocabulary.org/RecipeIngredient\" style='list-style:none;'><span itemprop=\"name\">" . $row["TextLine"] . "</span></li>";
		}
	};
	
	$recipeout .= "</ul><br /><h2>PREPARATION:</h2><p class='postbody' itemprop=\"instructions\">";
	
	$recipeout .= $prepinstructions;
	
	$recipeout .= "</p></div><p class='postbody'>";
	
	return $recipeout;
}

function recipeprint($recipeid) {
	$sql = "SELECT R.RcpTitle, P.PstTitle, R.Difficulty, R.PrepTime, R.CookTime, R.Servings, R.PrepInstructions FROM Recipe R, Post P WHERE (R.PostID = P.PID) AND R.RID = " . $recipeid;
	$result = mysql_query($sql) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$rcptitle = $row["RcpTitle"];
		$posttitle = $row["PstTitle"];
		$difficulty = $row["Difficulty"];
		$preptime = $row["PrepTime"];
		$cooktime = $row["CookTime"];
		$servings = $row["Servings"];
		$prepinstructions = $row["PrepInstructions"];
	};
	
	if (strlen($rcptitle) == 0) {
		$rcptitle = $posttitle;
	}

	$sql = "SELECT RecipeItems.TextLine FROM RecipeItems WHERE RecipeItems.RecipeID = " . $recipeid . " Order By RecipeItems.RIID Desc";
	$result = mysql_query($sql) or die(mysql_error());
	
	$recipeout .= "<title>Mexican Baker - " . $rcptitle . "</title></head><body onload='window.print();'>";
	
	$recipeout .= "<div class='recipecard2'>";
	
	$recipeout .= "<p class='postbody recipeprintbutton'>";
	
	$recipeout .= "<h2>Mexican Baker - " . $rcptitle . "</h2>";
	
	$recipeout .= "<span class='recipedetails'>DIFFICULTY: " . diffLabel($difficulty) . " <br /> PREP TIME: " . $preptime . " <br /> COOK TIME: " . $cooktime . " <br /> SERVINGS: " . $servings . "</span><br />";
	
	$recipeout .= "<h2>INGREDIENTS:</h2><ul>";
	
	while ($row = mysql_fetch_array($result)) {
		if(stristr($row["TextLine"], '<b>') === FALSE) {
			$recipeout .= "<li>" . $row["TextLine"] . "</li>";
		} else {
			$recipeout .= "<li style='list-style:none;'>" . $row["TextLine"] . "</li>";
		}
	};
	
	$recipeout .= "</ul><h2>PREPARATION:</h2><p class='postbody'>";
	
	$recipeout .= nl2br($prepinstructions);
	
	$recipeout .= "</p></div>";
	
	return $recipeout;	
}

function recipecount($postid) {
	$sql = "SELECT `RID` FROM `Recipe` WHERE `PostID` = " . $postid . ";";
	$result = mysql_query($sql) or die(mysql_error());
	$numcount = mysql_num_rows($result);
	return $numcount;
};

function creditoption($cid) {
	$sql = "SELECT `CID`, `CreditType` FROM Credits";
	$result = mysql_query($sql) or die(mysql_error());

	$creditout = "<select style='padding:0px;height:19px;width:100px;' id='selCredit' name='selCredit'>";
	
	while ($row = mysql_fetch_array($result)) {
		$creditout .= "<option value='" . $row["CID"] . "'";
		if ($cid == $row["CID"]) {
			$creditout .= " selected";
		};
		$creditout .= ">" . $row["CreditType"] . "</option>";
	};
	
	$creditout .= "</select>";
	
	return $creditout;
};

function authoroption($aid) {
	$sql = "SELECT `AID`, `AthFirstName`, `AthLastName` FROM Authors WHERE AthActive = 'Y'";
	$result = mysql_query($sql) or die(mysql_error());

	$authorout = "<select style='padding:0px;height:19px;width:100px;' id='selAuthor' name='selAuthor'>";
	
	while ($row = mysql_fetch_array($result)) {
		$authorout = $authorout . "<option value='" . $row["AID"] . "'";
		if ($aid == $row["AID"]) {
			$authorout = $authorout . " selected";
		};
		$authorout = $authorout . ">" . $row["AthFirstName"] . " " . $row["AthLastName"] . "</option>";
	};
	
	$authorout = $authorout . "</select>";
	
	return $authorout;
};

function authorhtml($aid) {
	$sql = "SELECT `AthDesc`, `AthEmail`, `AthFirstName`, `AthLastName` FROM Authors WHERE AID = " . $aid .";";
	$result = mysql_query($sql) or die(mysql_error());
	
	while ($row = mysql_fetch_array($result)) {
		
		$authorname = $row["AthFirstName"] . " " . $row["AthLastName"];
		
		$authorout .= "<div class='abouttheauthor' itemscope itemtype=\"http://data-vocabulary.org/Person\">";
		$authorout .= "<div class='atapic'><img src='http://www.gravatar.com/avatar/";
				
		$authorout .= md5(strtolower(trim($row["AthEmail"])));
					
		$authorout .= "?s=100&d=mm&r=g' alt='" . $authorname . "' /></div><div class='atatext'><h2 itemprop=\"name\">";
				
		$authorout .= $authorname . "</h2><p>" . $row["AthDesc"] . "</p></div></div>";
	};
	
	return $authorout;
}

function catoption($catid) {
	$sql = "SELECT `CATID`, `CatTitle` FROM Categories WHERE CatActive = 'Y'";
	$result = mysql_query($sql) or die(mysql_error());

	$catout = "<select style='padding:0px;height:19px;width:100px;' id='selCat' name='selCat'>";
	
	while ($row = mysql_fetch_array($result)) {
		$catout = $catout . "<option value='" . $row["CATID"] . "'";
		if ($catid == $row["CATID"]) {
			$catout = $catout . " selected";
		};
		$catout = $catout . ">" . $row["CatTitle"] . "</option>";
	};
	
	$catout = $catout . "</select>";
	
	return $catout;
};

function yesno($yesorno, $fieldname) {

	$stringout = "<select style='padding:0px;height:19px;width:50px;' id='" . $fieldname . "' name='" . $fieldname . "'>";
	
	//Yes
	$stringout = $stringout . "<option value='Y'";
	if ($yesorno == 'Y') {
		$stringout = $stringout . " selected";
	};
	$stringout = $stringout . ">Yes</option>";

	//No
	$stringout = $stringout . "<option value='N'";
	if ($yesorno == 'N') {
		$stringout = $stringout . " selected";
	};
	$stringout = $stringout . ">No</option>";
	
	$stringout = $stringout . "</select>";
	
	return $stringout;
};

function isloggedin() {
	if ($_SESSION['auth'] != "1") {
		header("Location: index.php");
		return False;
	} else {
		return True;
	}
}

function newPostNumber() {
	$sql = "SELECT Max(`PID`) As 'NextPID' FROM `Post`";
	$result = mysql_query($sql) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$currentPostId = $row["NextPID"];
	};
	return $currentPostId + 1;
}

function newRecipeNumber() {
	$sql = "SELECT Max(`RID`) As 'NextRID' FROM `Recipe`";
	$result = mysql_query($sql) or die(mysql_error());

	while ($row = mysql_fetch_array($result)) {
		$currentPostId = $row["NextRID"];
	};
	return $currentPostId + 1;
}

function recipeExists($postid, $index) {
	$sql = "SELECT `RID` FROM `Recipe` WHERE `PostID` = $postid AND `RcpOrder` = $index";
	$result = mysql_query($sql) or die(mysql_error());
	$numcount = mysql_num_rows($result);
	if ($numcount > 0) {
		while ($row = mysql_fetch_array($result)) {
			return $row["RID"];
		};
	} else {
		return "FALSE";
	};
}

function recipeExistsID($recipeid) {
	$sql = "SELECT `RID` FROM `Recipe` WHERE `RID` = $recipeid";
	$result = mysql_query($sql) or die(mysql_error());
	$numcount = mysql_num_rows($result);

	if ($numcount > 0) {
		return true;
	} else {
		return false;
	};
}

function formatpostbody($postid, $postbody, $posttitle, $continue) {

	if ($continue) {
		$postbody = substr($postbody, 0, strpos($postbody, "%continue%"));
		//$postbody = stristr($postbody, "%continue%", true); //PHP 5.3
	} else {
		$postbody = str_replace("%continue%","",$postbody);
	}
	
	for ($i = 1; $i <= 25; $i++) {
		$postbody = str_replace("%img". $i . "%", imgsForDetailView($postid, $posttitle, $i), $postbody);
	}
	
	for ($i = 1; $i <= recipecount($postid); $i++) {
		$postbody = str_replace("%recipe". $i . "%", recipehtml($postid, $posttitle, $i), $postbody);
	}

	$postbody = nl2br($postbody);
	
	return $postbody;
};

function validate($email, $pass) {
	
	$sql = "SELECT `AthFirstName` FROM Authors WHERE AthEmail = '" . sqlQuotes($email) . "' and AthPass = '" . sqlQuotes($pass) . "'";
	$result = mysql_query($sql) or die(mysql_error());
	
	$validate = "FAILED";

	while ($row = mysql_fetch_array($result)) {
		$validate = $row["AthFirstName"];
	};
	return $validate;
};

//RECIPE EDITOR FUNCTIONS

$ingredientsDropDownHtml = ""; //TODO: Implement this to save SQL Calls.

function numDropDown($num, $selected) {
	$numbers = array("0","1","2","3","4","5","6","7","8","9","10","11","12");

	$numDropDown = "<select id='number" . $num . "' name='number" . $num . "'>";

	foreach ($numbers as &$value) {
		$numDropDown = $numDropDown . "<option value='" . $value . "'";
    	if ($selected == $value) {
    		$numDropDown = $numDropDown . " selected";
		}
    	$numDropDown = $numDropDown . ">" . $value . " </option>";
	};

	$numDropDown = $numDropDown . "</select>";

	return $numDropDown;
}

function quantityDropDown($num, $selected) {

	//$fractions = array("1/8","1/7","1/6","1/5","1/4","1/3","1/2","2/7","2/5","2/3","3/8","3/7","3/5","3/4","4/7","4/5","5/8","5/7","5/6","6/7","7/8");
	$fractions = array("1/8","1/4","1/3","1/2","2/3","3/8","3/4","5/8","7/8");

	$quantityDropDown = "<select id='quantity" . $num . "' name='quantity" . $num . "'>";

	$quantityDropDown = $quantityDropDown . "<option value=''>0</option>";

	foreach ($fractions as &$value) {
		$numbervalue = number_format(factionToDec($value), 2, '.', '');
    	$quantityDropDown = $quantityDropDown . "<option value='" . $numbervalue . "'";

    	if (strval($selected) == strval($numbervalue)) {
    		$quantityDropDown = $quantityDropDown . " selected";
		}

    	$quantityDropDown = $quantityDropDown . ">" . decToFraction2($numbervalue) . " </option>";
    };

	$quantityDropDown = $quantityDropDown . "</select>";

	return $quantityDropDown;
}

function diffDropDown($selected) {
	$difficulty = array("E","M","H");

	$diffDropDown = "<select id='difficulty' name='difficulty'>";

	foreach ($difficulty as &$value) {
		$diffDropDown = $diffDropDown . "<option value='" . $value . "'";
    	if ($selected == $value) {
    		$diffDropDown = $diffDropDown . " selected";
		}
    	$diffDropDown = $diffDropDown . ">" . diffLabel($value) . " </option>";
	};

	$diffDropDown = $diffDropDown . "</select>";

	return $diffDropDown;
}

function diffLabel($diffSet) {
	switch ($diffSet) {
    case "E":
        return "EASY";
        break;
    case "M":
        return "MEDIUM";
        break;
    case "H":
        return "HARD";
        break;
	}
}

function servingsDropDown($servingsNum) {
	
	$servingsDeopDown = "<select id='servings' name='servings'>";
	
	for ($i = 1; $i <= 30; $i++) {
		$servingsDeopDown = $servingsDeopDown . "<option value='" . $i . "'";
		if ($servingsNum == $i) {
    		$servingsDeopDown = $servingsDeopDown . " selected";
		}
		$servingsDeopDown = $servingsDeopDown . ">" . $i . " </option>";
	}
	
	$servingsDeopDown = $servingsDeopDown . "</select>";

	return $servingsDeopDown;
}

function unitsDropDown($num, $selected) {
	$sql = "SELECT `UID`, `UntName` FROM Units WHERE UntActive = 'Y' ORDER BY `UntName`";
	$result = mysql_query($sql) or die(mysql_error());

	$ingout = "<select id='unit" . $num . "' name='unit" . $num . "'>";
	
	while ($row = mysql_fetch_array($result)) {
		$ingout = $ingout . "<option value='" . $row["UID"] . "'";
		if ($selected == $row["UID"]) {
			$ingout = $ingout . " selected";
		};
		$ingout = $ingout . ">" . $row["UntName"] . "</option>";
	};
	
	$ingout = $ingout . "</select>";
	
	return $ingout;
};

function ingredientsDropDown($num, $selected) {
	$sql = "SELECT `IID`, `IngName` FROM Ingredients WHERE IngActive = 'Y' ORDER BY `IngName`";
	$result = mysql_query($sql) or die(mysql_error());

	$ingout = "<select id='ingredient" . $num . "' name='ingredient" . $num . "'>";

	$ingout = $ingout . "<option value=''> - SELECT - </option>";
	
	while ($row = mysql_fetch_array($result)) {
		$ingout = $ingout . "<option value='" . $row["IID"] . "'";
		if ($selected == $row["IID"]) {
			$ingout = $ingout . " selected";
		};
		$ingout = $ingout . ">" . $row["IngName"] . "</option>";
	};
	
	$ingout = $ingout . "</select>";
	
	return $ingout;
};

function sqlQuotes($string)
{
	return str_replace("'", "''", $string); 
}

?>