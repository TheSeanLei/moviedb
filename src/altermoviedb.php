<?php

#Connect to DB
require_once("./library.php");
$db = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
// Check connection

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  return null;
  }

//print_r($_POST);
  

#Create table that displays all movie information
$check = "INSERT INTO movie (title, release_year, rating, running_time_minutes, platform) VALUES
('$_POST[title]','$_POST[release]','$_POST[rating]','$_POST[runtime]','$_POST[platform]')";

// Form the SQL query (a SELECT query)
if (!mysqli_query($db, $check))
  {
	  //echo "Could not add based on given title and release year of movie"
  die('Could not add given the inputted movie title and release year ' . mysqli_error($con));
  }
echo "1 record added";



#End of db usage
mysqli_close($db);
?>