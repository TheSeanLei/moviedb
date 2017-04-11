<?php
#print_r($_POST);

#If adding new user
if (isset($_POST['user']) && isset($_POST['pass'])){
		// Create connection to database
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cs4501";
		$db = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($db->connect_error) {
			die("Connection failed: " . $db->connect_error);
		} 
	
		#Check if user and password is in the database
		# Get the user and password info from the $_POST array.  hash() the
	    # password before matching it with the DB info.  If the password does not
	    # match, notify the user and quit.
	    $user = rtrim($_POST["user"]);
		$password = rtrim($_POST["pass"]);
		#echo "$password";
	    $pass = hash('sha256', "$password");
		$pass = substr($pass , 0, 30);
		#echo "$pass";
		
		#CHECK IF USER ALREADY EXISTS
		$query = "select * from Users where Users.username = '$user' and Users.Password = '$pass'";
		$result =  $db->query($query) or die ("Invalid query" . $db->error);
	    $rows = $result->num_rows;
		
	    if ($rows < 1){
			$query = "insert into Users values(default, '$user', '$pass')";
			$db->query($query) or die ("Invalid query" . $db->error);
		    header("Location: user_signin.php");
			exit;
			}
		else{
			echo "<br/><H2><center>User already exists!<BR />";
		    echo "<a href = \"admin_signin.php\">Try Again</a>";
		    #session_destroy();
		    die("</h2></center>");
					
			
		}

		
}
	#If user and password are both filled and submitted
	if (isset($_POST['username']) && isset($_POST['password'])){
		// Create connection to database
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cs4501";
		$db = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($db->connect_error) {
			die("Connection failed: " . $db->connect_error);
		} 
	
		#Check if user and password is in the database
		# Get the user and password info from the $_POST array.  hash() the
	    # password before matching it with the DB info.  If the password does not
	    # match, notify the user and quit.
	    $user = rtrim($_POST["username"]);
		$password = rtrim($_POST["password"]);
		#echo "$password";
	    $pass = hash('sha256', "$password");
		$pass = substr($pass , 0, 30);
		#echo "$pass";
		
		#CHECK IF ADMIN IS LOGGING IN
	    $query = "select * from Admins where Admins.username = '$user' and Admins.Password = '$pass'";
		$result =  $db->query($query) or die ("Invalid query" . $db->error);
	    $rows = $result->num_rows;
		
	    if ($rows < 1){
		    
			}
		else{
			#start admins session
			#start user session
			session_start();
			$_SESSION["username"] = $_POST['username'];
					
			header("Location: admin_home.php");
			exit;
		}
		
		#CHECK IF USER IS LOGGING IN
		$query = "select * from Users where Users.username = '$user' and Users.Password = '$pass'";
		$result =  $db->query($query) or die ("Invalid query" . $db->error);
	    $rows = $result->num_rows;
		
	    if ($rows < 1){
		    echo "<br/><H2><center>You are not an authorized user!<BR />";
		    echo "<a href = \"admin_signin.php\">Try Again</a>";
		    #session_destroy();
		    die("</h2></center>");
			}
		else{
			#start admins session
			#start user session
			session_start();
			$_SESSION["username"] = $_POST['username'];
					
			header("Location: user_signin.php");
			exit;
		}
		
	}

?>

<html>
 <head>
  <title>Admin Login</title>
 </head>
 <body>
	<h1>Log-in</h1>
	<form action = "admin_signin.php" method="POST">
	
	Username: <input type = "text" name = "username" placeholder = "Type in your username" size = "30"> <br/>
	Password: <input type = "text" name = "password" placeholder = "Type in your password" size = "30"> <br/>
	<input type = "submit" value = "Submit"/>
	</form>
	<br/>
	<br/>
	<br/>
	<form action = "admin_signin.php" method="POST">
	New User: <input type = "text" name = "user" placeholder = "Type in username" size = "30"><br/>
	New Password: <input type = "text" name = "pass" placeholder = "Type in password" size = "30"><br/>
	<input type = "submit" name = "register" value = "register"/>
	</form>
 </body>
</html>
