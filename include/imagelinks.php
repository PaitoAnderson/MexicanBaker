<?php
function imgForSmallView($PID, $PostTitle) {
	return "<img class='smallviewimg' src='" . $basepath . "images/posts/" . $PID . "/smallview.jpg' alt='" . htmlspecialchars($PostTitle) . "' />";
}

function imgForMediumView($PID, $PostTitle) {
	return "<img class='mediumviewimg' src='" . $basepath . "images/posts/" . $PID . "/mediumview.jpg' alt='" . htmlspecialchars($PostTitle) . "' />";
}

function imgForLargeView($PID, $PostTitle) {
	return "<img class='largeviewimg' src='" . $basepath . "images/posts/" . $PID . "/largeview.jpg' alt='" . htmlspecialchars($PostTitle) . "' />";
}

function imgsForDetailView($PID, $PostTitle, $index) {
	return "</p><a class='lightbox' href='/images/posts/" . $PID . "/image" . $index . ".jpg' rel='lightbox'><img class='postimage'  src='/images/posts/" . $PID . "/image" . $index . ".jpg' alt='" . htmlspecialchars($PostTitle) . "' /></a><p class='postpadding'>";
}
?>