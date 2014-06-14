<div id="span12">
	<?php echo getSlides() ?>
<br />
<?php
//Fetch some posts :)
$thispage = 1;
if ($view == "page") {
	$thispage = $pageid;
}
$rawarray = posts($thispage, $perpage);
$postsdetails = explode("|-|", $rawarray);
$postcount = (substr_count($rawarray, "|-|") - 1);
$i = 0;
while ($i <= $postcount) {
	$postdetails = explode("|", $postsdetails[$i]);
	$postid = $postdetails[13];
	$postdate = strtotime($postdetails[4]);
	echo "<p class='postdate'>" . date('F j',$postdate) . "<sup>" . getNumberSuffix(date('j',$postdate)) . "</sup> " . date('Y',$postdate) . "</p>";
	echo "<h1 class=\"posttitle\"><a class='link' href='/post/" . $postid . "/" . $postdetails[6] . "'>" . $postdetails[0] . "</a></h1>";
	echo "<p class='postbody'>" . formatpostbody($postid, $postdetails[1], $postdetails[0], true) . "</p>";
	echo "<p class='postbody credit'>" . $creditverb . " <a class='coollink' target='_blank' href='" . $crediturl . "'>" . $creditname . "</a></p>";
	echo "<p class='continuereading'><a href='/post/" . $postid . "/" . $postdetails[6] . "'>Continue Reading...</a></p>";
	echo "<div style='clear:both;'><br /></div>";
	$i++;
};
?>
