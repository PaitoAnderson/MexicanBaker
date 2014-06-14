<?php
$showbuttons = false;
if (($view == "page") and ($pageid != 1)) {
	//Show Previous Page Button
	$prevpage = $pageid - 1;
	$nextprev1 .= "<a rel='prev' href='/page/" . $prevpage . "'><< Previous Page</a>";
	$showbuttons = true;
} else {
	$nextprev1 .= "<< Previous Page";
}
$postcount = postcount();
$numpages = ceil($postcount / $perpage);


if (($numpages > $pageid) and ($numpages > 1)) {
	//Show Next Page Button
	if ($pageid == "") {
		$nextpage = 2;
	} else {
		$nextpage = $pageid + 1;
	}
	$nextprev2 .= "<a rel='next' href='/page/" . $nextpage . "'>Next Page >></a>";
	$showbuttons = true;
} else {
	$nextprev2 .= "Next Page >>";
}

if ($showbuttons) {
	echo "<div class='pagination2'>";
	echo $nextprev1 . " &bull; " . $nextprev2;
	echo "</div>";
};
?>