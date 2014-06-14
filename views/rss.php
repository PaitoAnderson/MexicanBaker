<?php
    header("Content-Type: application/rss+xml; charset=ISO-8859-1");
    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
	$rssfeed .= '<rss version="2.0">';
	$rssfeed .= '<channel>';
	$rssfeed .= '<title>Mexican Baker</title>';
	$rssfeed .= '<link>http://www.mexicanbaker.com/</link>';
	$rssfeed .= '<description>Mexican Baker RSS Feed</description>';
	$rssfeed .= '<language>en-us</language>';
	$rssfeed .= '<copyright>Copyright (C) ' . date('Y') . ' mexicanbaker.com</copyright>';
	
	$query = "SELECT Post.PstTitle, Post.PstBody, Post.PstDescription, Post.PstDate, Post.PstURL, Post.PID, Authors.AthFirstName, Authors.AthLastName FROM Post, Authors WHERE Post.PstActive = 'Y' and Post.AuthorID = Authors.AID ORDER BY Post.PstDate DESC";
    $result = mysql_query($query) or die ("Could not execute query");
 
    while($row = mysql_fetch_array($result)) {
        extract($row);
 
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $PstTitle . '</title>';
        //if (strlen($PstDescription) > 5) {
        //	$rssfeed .= '<description>' . $PstDescription . '</description>';
        //} else {
	        $rssfeed .= '<description><![CDATA[' . str_replace("<br />\r\n<br />", "<br />", nl2br(preg_replace('/%.+?%/s','', $PstBody))) . ']]></description>';
        //};
        $rssfeed .= '<link>http://www.mexicanbaker.com/post/' . $PID . "/" . $PstURL . '</link>';
        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($PstDate)) . '</pubDate>';
        $rssfeed .= '<author>' . $AthFirstName . ' ' . $AthLastName . '</author>';
        $rssfeed .= '</item>';
    }
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';

    $rssfeed = str_replace("&", "&amp;", $rssfeed);
	
	echo($rssfeed);
?>