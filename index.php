<?php
session_start();
$servername = $_SERVER['SERVER_NAME'];
date_default_timezone_set('America/Toronto');

$basepath = "https://" . $servername . "/";
require("include/dbconnect.php");

$perpage = 4;
$pageid = $_GET['id'];
$view = $_GET['view'];
$postid = $pageid;
include("include/imagelinks.php");
include("include/numberformats.php");
include("include/elements.php");
include("include/gravatar.php");
if ($view == "builder") {
	$postdetails = post($postid);
	$postdetails = explode("|", $postdetails);
	$pagetitle = "Post Builder";
	include("include/header1.php");
	echo "\n\r\t<link rel='stylesheet' media='screen' type='text/css' href='" . $basepath . "css/datepicker.css' />";
	echo "\n\r\t<script type='text/javascript' src='" . $basepath . "js/datepicker.js'></script>";
?>
	<script type="text/javascript">
	$(function(){
		$('#inputDate').DatePicker({
			format:'m/d/Y',
			date: $('#inputDate').val(),
			current: $('#inputDate').val(),
			starts: 1,
			position: 'r',
			onBeforeShow: function(){
				$('#inputDate').DatePickerSetDate($('#inputDate').val(), true);
			},
			onChange: function(formated, dates){
				$('#inputDate').val(formated);
				//$('#inputDate').DatePickerHide();
			}
		});
	});
	</script>
<?php
	include("include/header2.php");
	include("include/header3.php");

	include("views/builder.php");
	
	include("include/footer.php");
} elseif ($view == "post") {
	$postdetails = post($postid);
	$postdetails = explode("|", $postdetails);
	if (($postdetails[13] == 'Y') OR ($_SESSION['auth'] == "1")) {
		$pagetitle = $postdetails[0];
		include("include/header1.php");
		echo("\n\r\t<meta name='keywords' content='" . $postdetails[10] . "' />");
		include("include/header2.php");
		include("include/header3.php");
		
		include("views/detail.php");

		include("include/footer.php");
	} else {
		header("HTTP/1.0 404 Not Found");
		include("views/404.php");
	}
} elseif ($view == "presentation") {
	$postdetails = post($postid);
	$postdetails = explode("|", $postdetails);
	
	include("views/large.php");

} elseif ($view == "archive") {
	$postdetails = post($postid);
	$postdetails = explode("|", $postdetails);
	
	include("views/medium.php");
	
} elseif ($view == "hover") {
	$postdetails = post($postid);
	$postdetails = explode("|", $postdetails);
	
	include("views/small.php");
} elseif ($view == "recipe") {
	$pagetitle = "Recipe Editor";
	include("include/header1.php");
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/recipe.php");
	
	include("include/footer.php");
} elseif ($view == "print") {
	include("views/print.php");
} elseif ($pageid == "rss") {
	include("views/rss.php");
} elseif (($pageid == "home") or (($pageid == "") and ($view == "")) or ($view == "page")) {
	$pagetitle = "Mexican Baker Home";
	include("include/header1.php");
	echo "\n\r\t<script src='" . $basepath . "js/slides.min.jquery.js'></script>";
	echo("\n\r\t<meta name=\"keywords\" content=\"food,blog,baking,cooking,delicious,linda,paito,anderson,recipe,mexican baker\" />");
	echo("\n\r\t<meta name=\"description\" content=\"Welcome to my blog, Mexican Baker! It's a chronicle of the sometimes bizzare food adventures of a Mexican Mennonite who ended up in Canada and married a half Jamaican.  Culturally diverse yet delicious!\" />");
?>

	<link href="rss" rel="alternate" title="Mexican Baker" type="application/rss+xml" />
	<script>
	$(function(){
		$('#slides').slidesjs({
			width: 950,
			height: 350,
			navigation: {
      			active: false
      		},
			pagination: {
      			active: true,
      			effect: "slide"
      		},
			play: {
				active: false,
				effect: "slide",
				interval: 5000,
				auto: true,
				swap: false,
				pauseOnHover: true,
				restartDelay: 2500
		    }
		});
	});
	</script><?php
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/home.php");
	
	include("include/pagination.php");
	include("include/footer.php");
} elseif ($pageid == "contact") {
	$pagetitle = "Contact Me";
	include("include/header1.php");
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/contact.php");
	
	include("include/footer.php");
} elseif ($pageid == "login") {
	$pagetitle = "Login";
	include("include/header1.php");
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/login.php");
	
	include("include/footer.php");
} elseif ($pageid == "recipes") {
	$pagetitle = "Recipe Index";
	include("include/header1.php");
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/recipeindex.php");
	
	include("include/footer.php");
} elseif ($pageid == "manage") {
	$pagetitle = "Manage Posts";
	include("include/header1.php");
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/manage.php");
	
	include("include/footer.php");
} elseif ($pageid == "ingredients") {
	$pagetitle = "Add Ingredients";
	include("include/header1.php");
	include("include/header2.php");
	include("include/header3.php");
	
	include("views/ingredients.php");
	
	include("include/footer.php");
} else {
	header("HTTP/1.0 404 Not Found");
	include("views/404.php");
};
?>
