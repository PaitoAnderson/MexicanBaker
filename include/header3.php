  <div id="outer-wrap-centered">
  <div id="main-wrap-outer">
  <div id="main-wrap-inner">
  <div id="container">
  <div id="content">

  <header id="header">
    <!--[if lt IE 8]>
		<div class="updatebrowser">
			<a target="_blank" href="http://www.updatebrowser.net/">You are using an outdated browser, clear here to update.</a>
		</div>
	<![endif]-->
    <div id="logo">
      <br />
      <a href="/"><img src="/images/Final-Logo_400.png" alt="Mexican Baker Logo" /></a>
    </div>
      <?php 
          echo("<div id=\"topNav\">");
      ?>
      <nav class="main-nav">
      <ul>
        <li class="link"><a href="/">Home</a></li>
        <?php 
          if ($_SESSION['auth'] == "1") {
            echo("<li class=\"link\"><a href=\"/manage\">Manage</a></li>");
          }
        ?>
        <li class="link"><a href="/recipes">Recipe Index</a></li>
        <li class="link"><a href="/contact">Contact</a></li>
        <?php 
          if ($_SESSION['auth'] == "1") {
            echo("<li class=\"link\"><a href=\"/login\">Logout</a></li>");
          }
        ?>
      </ul>
      </nav>
    </div>
  </header>