<?php
session_start();

#Connect to DB
require_once("./library.php");
$db = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
// Check connection

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  return null;
  }

$release = intval($_POST['release']);

//print_r($_POST);

#Create table that displays all movie information
$check = "DELETE FROM movie WHERE title = '$_POST[title]' and release_year = $release";
//echo "$check";
//echo is_int($release);
//$results = mysql_query($db, $check) or die('Invalid Delete'.mysql_error());

$results = $db->query($check) or die ("Invalid delete" . $db->error);

if ($db->affected_rows > 0) {
	echo "The movie was deleted";
}
else {
	echo "Movie could not be deleted";
}



#End of db usage
mysqli_close($db);
?>