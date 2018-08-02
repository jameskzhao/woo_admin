<?php

/*** PREVENT THE PAGE FROM BEING CACHED BY THE WEB BROWSER ***/
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

require_once("wp-authenticate.php");
$user = wp_get_current_user();
require_once("functions.php");

/*** REQUIRE USER AUTHENTICATION ***/
login();

/*** RETRIEVE LOGGED IN USER INFORMATION ***/