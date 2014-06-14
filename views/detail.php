<?php
$postdate = strtotime($postdetails[4]);
$postauthor = $postdetails[3];

$creditverb = $postdetails[7];
$creditname = $postdetails[8];
$crediturl = $postdetails[9];
?>
		<p class="postdate">
		<?php echo(date('F j',$postdate) . "<sup>" . getNumberSuffix(date('j',$postdate)) . "</sup> " . date('Y',$postdate)); ?></p>
		<h1 class="posttitle"><a class="link" href="/post/<?php echo($postid . "/" . $postdetails[6] . "\">" . $postdetails[0]); ?>
		<?php
			if ($_SESSION['auth'] == "1") {
				echo(" - <a class=\"link\" href=\"/builder/" . $postid . "\">Edit</a>");
			}
		?>
		</a></h1>
		<p class="postbody"><?php echo(formatpostbody($postid, $postdetails[1], $postdetails[0], false)); ?></p>
		<?php 
		if ($creditverb != "None") {
			echo ("<p class='postbody credit'>" . $creditverb . " <a class='coollink' target='_blank' href='" . $crediturl . "'>" . $creditname . "</a>");
		} 
		
		echo ("<br />" . authorhtml($postdetails[11]));
		
		?>
		<div class="comments" id="comments">
			<h5 style="font-size:15pt;margin-top:15pt;">ADD YOUR COMMENT:</h5>
			<?php echo(commenthtml($postid)); ?>
			<div id="newcomment"></div>
			<div id="flash"></div>
		</div>
		<div class="reply" id="reply">
			<form action="#" method="post" id="commentform">
				<p class="comment-form-author input-block">
					<label for="author"><b>Name</b> (required)</label>
					<input id="author" name="author" type="text" value="" size="30" placeholder="John Smith" aria-required="true" required="" />
				</p>
				<p class="comment-form-email input-block">
					<label for="email"><b>Email</b> (required)</label>
					<input id="email" name="email" type="email" value="" size="30" placeholder="someone@something.com" aria-required="true" required="" />
				</p>
				<p class="comment-form-url input-block">
					<label for="url"><b>Website</b></label>
					<input id="url" name="url" type="url" value="" placeholder="http://yourwebsite.com/" size="30" />
				</p>
				<p class="comment-form-comment">
					<label for="comment"><b>Your Comment</b></label>
					<textarea style="position: relative;z-index: 10;opacity: 0.8;color:#818181;background-color:#F4F4F4;border-color:#E5E5E5;" id="comment" name="comment" cols="45" rows="5" placeholder="Write your comment here." aria-required="true" required=""></textarea>
				</p>
				<p class="form-submit">
					<input style="width: 150px;" name="submit" type="submit" id="submit" value="Post Comment" />
					<input type="hidden" name="comment_post_ID" value="<?php echo($postid); ?>" id="comment_post_ID" />
				</p>
			</form>
		</div>
	