<?php
define("DB_SERVER", "localhost");
define("DB_USER", "XXXX");
define("DB_PASS", "XXXX");
define("DB_NAME", "XXXX");

mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME) or die(mysql_error());
?>