<?php

require "dbutil.php";
	$db = DbUtil::loginConnection();
	
	// Make sure you run moviedb.sql File in phpmyadmin
	
#Start at the sign in page
#header("Location: admin_signin.php");
#		exit;

echo "Run moviedb.sql in phpmyadmin to set up the movie database!";

$db->close();
?>