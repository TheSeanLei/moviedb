<?php
session_start();
#print_r($_POST);
#print_r($_SESSION);
#Get email submitter
if (isset($_SESSION['senderEmail'])){
	$emailSubmitter = $_SESSION['senderEmail'];
}
echo "Email will be sent to $emailSubmitter";



if (isset($_POST['Submit'])){
		

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
	$receiver = $emailSubmitter;
	#BUT IN THIS CASE TO NOT SPAM RANDOM EMAIL...
	$receiver = "Seanieboyy@gmail.com";
			
	$subj = $_POST['subject'];
	$msg = $_POST['message'];

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
	else {echo '<br/>Confirmation email has been sent'; }
}
?>

<html>
 <head>
  <title>Email ticket submitter</title>
 </head>
 <body>
	<h1>Email ticket submitter</h1>
	<form action = "emailSubmitter.php" method="POST">
	
	Subject: <input type = "text" name = "subject" placeholder = "Type in the subject" size = "30"> <br/>
	
	Message: <textarea name = "message" placeholder = "Type in your message" cols="40" rows="5"> </textarea><br/>
	
	<input type = "submit" name = "Submit" value = "Submit"/>
	</form> 
	
	<a href="view_ticket.php"">Return to view ticket</a>
 
 </body>
</html>