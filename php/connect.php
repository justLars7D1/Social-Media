<?php

	/*$dbhost = "localhost";
	$dbuser = "root";
	$dbpass = "";
	$dbname = "meet";*/

	$dbhost = "rdbms.strato.de";
	$dbuser = "U3090110";
	$dbpass = "axdu8qsy";
	$dbname = "DB3090110";


$connect = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Couldn't find/connect (to) the database!");

?>
