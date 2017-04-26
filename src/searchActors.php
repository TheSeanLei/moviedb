<?php
	require "dbutil.php";
	$db = DbUtil::loginConnection();
	
	$stmt = $db->stmt_init();


	if($stmt->prepare("select * from movie_maker where fname like ?") or die(mysqli_error($db))) {
		$searchString = '%' . $_GET['searchfname'] . '%';
		$stmt->bind_param(s, $searchString);
		$stmt->execute();
		$stmt->bind_result($id, $fname, $lname, $birth_date, $death_date, $age, $country);

		echo "<table border=2><th>id</th><th>first name</th><th>last name</th><th>birth date</th><th>country</th>\n";
		while($stmt->fetch()) {
			echo "<tr><td>$id</td><td>$fname</td><td>$lname</td><td>$birth_date</td><td>$country</td></tr>";
		}
		echo "</table>";
	
		$stmt->close();
	}
	
	
	$db->close();


?>
