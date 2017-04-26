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
//echo json_encode($rows);
//write json to file
$file = fopen("downloadjson.json", "w+");
/*
//chmod($file, 0777);

if (file_put_contents($file, $json)){
    echo "JSON file created successfully...";
}
else  {
    echo "Oops! Error creating json file...";
	
}
fclose($file);


if(!file_exists("downloadjson.json")){
	echo "file doesn't exist";
}
else{
	echo "file exists!";
}

*/
// exclusive lock
if (flock($file,LOCK_EX))
  {
  fwrite($file, $json);
  // release lock
  flock($file,LOCK_UN);
  echo "Json file has been updated with the current movie table";
  }
else
  {
  echo "Error locking file!";
  }

fclose($file);



//echo json_encode($rows);


//$response = json_encode($result);

#End of db usage
 mysqli_close($db);
?>