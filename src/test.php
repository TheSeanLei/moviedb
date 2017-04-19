<?php

$rows = "this is a test";
// encode array to json
$json = json_encode($rows);

$file = "test.json";
/**
if (file_put_contents($file, $json)){
    echo "JSON file created successfully...";
}
else  {
    echo "Oops! Error creating json file...";
	
}
*/
$fp = fopen('test.json', 'w');
fwrite($fp, 'Cats chase mice');
fclose($fp);
?>