<?php
	print_r($_POST);
	
	#Check if all fields in ticket submission is filled out
	if(!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['probsub']) && !empty($_POST['probdes'])){
		#Add to database
		// Create connection
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cs4501";
		$db = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($db->connect_error) {
			die("Connection failed: " . $db->connect_error);
		} 
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$name = "$firstname "."$lastname";
		$email = $_POST['email'];
		$email = 'Seanieboyy+'."$lastname".'@gmail.com';
		$subject = $_POST['probsub'];
		$description = $_POST['probdes'];
		date_default_timezone_set('America/New_York');
		$date = date('M d Y h:iA');
		$query = "insert into Tickets values (default, '$date','$name','$email','$subject','$description','open','temp')";
		$db->query($query) or die ("Invalid insert " . $db->error);
		$query = "insert into ticket_to_admin values (default, '')";
		$db->query($query) or die ("Invalid insert " . $db->error);

		#Send confirmation email to user
		$mailpath = 'C:/xampp/php/vendor/phpmailer/phpmailer'; 
		// Add the new path items to the previous PHP path
		$path = get_include_path();
		set_include_path($path . PATH_SEPARATOR . $mailpath);
		require 'PHPMailerAutoload.php';
		$mail = new PHPMailer();		 
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->SMTPSecure = "tls"; // sets tls authentication
		$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
		$mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
		$mail->Username = "cs4501.fall15@gmail.com"; // email username
		$mail->Password = "UVACSROCKS"; // email password

		$sender = "cs4501.fall15@gmail.com";
		$receiver = strip_tags($_POST["email"]);
		//$receiver = "Seanieboyy@gmail.com";
		$subj = "ticket submitted";
		$msg = "This is a confirmation email that your ticket has been submitted";

		// Put information into the message
		$mail->addAddress($receiver);
		$mail->SetFrom($sender);
		$mail->Subject = "$subj";
		$mail->Body = "$msg";

		// echo 'Everything ok so far' . var_dump($mail);
		$sent = 1;
		if(!$mail->send()) {
			$sent = 0;
			echo '<br/>Confirmation Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		   } 
		else {echo 'Confirmation email has been sent'; }
		
		#######################
		#email administrators
		$query = "SELECT Email FROM `admins`";
		$adminemails = $db->query($query);
		$sent2 = 1;
		while ($row = $adminemails->fetch_assoc()) {
			$admin = $row['Email'];
			$receiver = strip_tags($admin);
			//$receiver = "Seanieboyy@gmail.com";
			$subj = "ticket recently submitted";
			$msg = "A new ticket has been submitted";

			// Put information into the message
			$mail->addAddress($receiver);
			$mail->SetFrom($sender);
			$mail->Subject = "$subj";
			$mail->Body = "$msg";

			// echo 'Everything ok so far' . var_dump($mail);
			if(!$mail->send()) {
				$sent2 = 0;
				echo '<br/>Message to Admin could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			   } 
			#else { echo '<br/>Admins have been sent an email'; }
			#echo $row['Email'];
		}
		
		
		#Confirm to user in webpage
		if ($sent == 1 && $sent2 ==1){
			header("Location: confirmation.php");
			exit;
			}
		
	}
	elseif(!empty($_POST['firstname']) || !empty($_POST['lastname']) || !empty($_POST['email']) || !empty($_POST['probsub']) || !empty($_POST['probdes'])){
		#Alert user of error
		echo "Whoops! A field was left blank";
	}
	else{
		echo "nothing is set";
	}
	

?>
<html>
 <head>
  <title>Assignment 2 user signin</title>
 </head>
 <body>
	<h1>Submit A Ticket</h1>
	<form action = "user_signin.php" method="POST">
	
	First Name: <input type = "text" name = "firstname" placeholder = "Type in your first name" size = "30"> <br/>
	
	Last Name: <input type = "text" name = "lastname" placeholder = "Type in your last name" size = "30"> <br/>
	
	Email: <input type = "text" name = "email" placeholder = "Type in your email address" size = "30"> <br/>
	
	Problem Subject: <input type = "text" name = "probsub" placeholder = "Type in the subject of your problem" size = "30"> <br/>
	
	Problem Description: <textarea name = "probdes" placeholder = "Type in a desciption of your problem" cols="40" rows="5"> </textarea><br/>
	
	<input type = "submit" value = "Submit"/>
	</form> 
	
	<a href="admin_signin.php"">Click here to logout</a>
 
 </body>
</html>