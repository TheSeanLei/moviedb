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
#Create table that displays all movie information
$check = "SELECT title, release_year, rating, running_time_minutes, platform FROM movie";

#display sorted by
if (isset($_POST['sort']) && !empty($_POST['sort'])) {
	$sortby = $_POST['sort'];
	$check = "SELECT title, release_year, rating, running_time_minutes, platform FROM movie ORDER BY $sortby";
	}

// Form the SQL query (a SELECT query)
$result = mysqli_query($db,$check);
/**
 // Print the data from the table row by row
 while($row = mysqli_fetch_array($result)) {
 echo $row['title'];
 //echo " " . $row['release_year'];
 //echo " " . $row['rating'];
 //echo " " . $row['running(minutes)'];
 //echo " " . $row['platform'];
 //echo "<br>";
 }
 mysqli_close($db);
*/

//Start table
echo "<table border='1'><caption> <h2> All Movies </h2> </caption>";


$row = $result->fetch_array();
while ($next_element = each($row)){
	$next_element = each($row);
	$next_key = $next_element['key'];
	echo "<th>" . $next_key . "</th>";
}
#Display table data
$result = $db->query($check);
while ($row = $result->fetch_object()) {
	echo "<tr align = 'center'>";
	echo "<td>$row->title</td>";
	echo "<td>$row->release_year</td> ";
	echo "<td>$row->rating</td> ";
	echo "<td>$row->running_time_minutes</td> ";
	echo "<td>$row->platform</td> ";
	echo "</tr>";
}
echo "</table>";
echo "<br/><br/>";


#End of db usage
 mysqli_close($db);
?>