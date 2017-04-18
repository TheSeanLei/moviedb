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

// Form the SQL query (a SELECT query)
$result = $db->query($check);

$rows = array();
while ($row = $result->fetch_object()) {
	array_push($rows, $row);
}

//print_r(array_values($rows));

// encode array to json
$json = json_encode($rows);

//header('Content-disposition: attachment; filename=export.json');
//header('Content-Type: application/json');

echo "$json";
//write json to file
$file = "downloadjson.json";
//chmod($file, 0777);
if (file_put_contents($file, $json)){
    echo "JSON file created successfully...";
}
else  {
    echo "Oops! Error creating json file...";
	
}

	 
//echo json_encode($rows);


//$response = json_encode($result);

#End of db usage
 mysqli_close($db);
?>