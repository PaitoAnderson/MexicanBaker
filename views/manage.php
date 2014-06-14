<?php
	isloggedin();
	$draftData = draftList();
	
	$drafts = explode("|-|", $draftData);
	$draftcount = (substr_count($draftData, "|-|") - 1);
?>
<ul class="postpadding" style="list-style-type:none;">
	<li><a class='coollink' href="builder/<?php echo newPostNumber(); ?>">New Post</a></li>
	<?php
	$i = 0;
	while ($i <= $draftcount) {
		$draftDetails = explode("|", $drafts[$i]);
		$postId = $draftDetails[0];
		$postTitle = $draftDetails[1];
		echo "<li><a class='coollink' href=\"builder/" . $postId . "\">" . $postTitle . "</a></li>";
		$i++;
	};
	?>
</ul>

<br />
<!--<ul class="postpadding" style="list-style-type:none;">
	<li><a href="ingredients">Ingredients</a></li>
</ul>-->
<br />
<ul class="postpadding" style="list-style-type:none;">
	<li><a class="coollink" target="_blank" href="http://mexicanbaker.com/images/cheat_sheet.png">Cheat Sheet</a></li>
	<li><a class="coollink" target="_blank" href="https://www.google.com/analytics">Google Analytics</a></li>
</ul>
<br />
<br />
