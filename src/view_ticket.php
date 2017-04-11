<?php
session_start();
print_r($_SESSION);
print_r($_POST);
echo "Viewing ticket";
echo "</br></br>";
#Go back to admin home page
echo "<a href='admin_home.php'>Select another ticket</a>";
echo "</br></br>";

#Connect to DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs4501";
$db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($db->connect_error) {
	die("Connection failed: " . $db->connect_error);
} 


#Make ticket class
require_once('ticket_class.php');
$ticketID = $_SESSION['ticketID'];
$check = "SELECT tickets.Ticket_id, Received, Sender_Name, Sender_Email, Subject, Problem_Description, Tech, Status FROM Tickets, ticket_to_admin WHERE Tickets.Ticket_id = ticket_to_admin.ticket_id AND Tickets.Ticket_id = $ticketID"; 
$result = $db->query($check);
#store ticket info 
$id;
$received;
$senderName;
$senderEmail;
$subject;
$description;
$tech; 
$status;
while ($row = $result->fetch_object()) {
	$id = $row->Ticket_id;
	$received = $row->Received;
	$senderName = $row->Sender_Name;
	$senderEmail = $row->Sender_Email;
	$subject = $row->Subject;
	$description = $row->Problem_Description;
	$tech = $row->Tech;
	$status = $row->Status;
}
$ticket = new ticket_class($id, $received, $senderName, $senderEmail, $subject, $description, $tech, $status); 

#Display all ticket information
echo "Ticket Number: ";
print($ticket->id);
echo "</br>";
echo "Received: ";
print($ticket->received);
echo "</br>";
echo "Sender Name: ";
print($ticket->senderName);
echo "</br>";
echo "Sender Email: ";
print($ticket->senderEmail);
echo "</br>";
echo "Subject: ";
print($ticket->subject);
echo "</br>";
echo "Problem Description: ";
print($ticket->description);
echo "</br>";
echo "Tech: ";
print($ticket->tech);
echo "</br>";
echo "Status: ";
print($ticket->status);
echo "</br>";
echo "</br>";


#BUTTON options

#If a button was selected, do corresponding action
#change status of ticket
if (isset($_POST['button']) && $_POST['button'] == 'Change Status') {
	if (strcmp($ticket->status, "open") ==0){
		$ticket->status = "closed";
	}
	else{
			$ticket->status = "open";
	}
	#print($ticket->status);
	#print($id);
	$status = $ticket->status;
	// update data in mysql database 
	$sql="UPDATE tickets SET status = '$status' WHERE tickets.ticket_id=$id";

	$db->query($sql);
	
	#reload page to display new status
	header("Location: view_ticket.php");
	exit;
}
#Assign Self
elseif (isset($_POST['button']) && ($_POST['button'] == 'Assign Self')) {
	$username = $_SESSION['username'];
	#print("$username");
    #$sql="UPDATE ticket_to_admin SET Tech = $username WHERE ticket_to_admin.Ticket_id=$id";
	$sql="UPDATE ticket_to_admin SET Tech = 'Sean' WHERE ticket_to_admin.Ticket_id=$id";
	$db->query($sql);
	
	#reload page to display new status
	header("Location: view_ticket.php");
	exit;
	
} 
#Remove Self
elseif (isset($_POST['button']) && ($_POST['button'] == 'Remove Self')) {
	$sql="UPDATE ticket_to_admin SET Tech = '' WHERE ticket_to_admin.Ticket_id=$id";
	$db->query($sql);
	
	#reload page to display new status
	header("Location: view_ticket.php");
	exit;
} 
#Email Submitter
elseif (isset($_POST['button']) && ($_POST['button'] == 'Email Submitter')) {
	$_SESSION['senderEmail'] = $ticket->senderEmail;
	header("Location: emailSubmitter.php");
	exit;
} 
#Delete Ticket
elseif (isset($_POST['button']) && ($_POST['button'] == 'Delete')) {
	$sql="DELETE FROM tickets WHERE tickets.Ticket_id=$id";
	$db->query($sql);
	$sql="DELETE FROM ticket_to_admin WHERE ticket_to_admin.Ticket_id=$id";
	$db->query($sql);
	
	#reload page to display new status
	header("Location: admin_home.php");
	exit;
} 
#View all tickets from same submitter
elseif (isset($_POST['button']) && ($_POST['button'] == 'Find Tickets from Same Submitter')) {
	$submitter = $ticket->senderName;
	#echo "$submitter";
	$check = "SELECT tickets.Ticket_id, Received, Sender_Name, Sender_Email, Subject, Tech, Status, Select_Ticket FROM Tickets, ticket_to_admin WHERE Tickets.Ticket_id = ticket_to_admin.ticket_id AND Tickets.Sender_Name = '$submitter'"; 
	$result = $db->query($check);
	$row = $result->fetch_array();
	#echo "$row";
	echo "<table border='1'><caption> <h2> Same Submitter Tickets </h2> </caption>";
	#Make column labels
	
	while ($next_element = each($row)){
		$next_element = each($row);
		$next_key = $next_element['key'];
		print "<th>" . $next_key . "</th>";
	}
	#Display table data
	$result = $db->query($check);
	echo "<form action = 'admin_mytickets.php' method='POST'>";
	while ($row = $result->fetch_object()) {
		echo "<tr align = 'center'>";
		echo "<td>$row->Ticket_id</td>";
		echo "<td>$row->Received</td> "; 
		echo "<td>$row->Sender_Name</td> ";
		echo "<td>$row->Sender_Email</td> ";
		echo "<td>$row->Subject</td> ";
		echo "<td>$row->Tech</td> ";
		echo "<td>$row->Status</td> ";
		echo "<td><input type = 'radio' name = 'selected' value = $row->Ticket_id> </td>";
		
		echo "</tr>";
	}
	echo "<tr align = 'center'>";

	echo "</tr>";
	echo "</table>";
	echo "	</form>";
	echo "</br></br>";
} 

#View all tickets with similar subjects
elseif (isset($_POST['button']) && ($_POST['button'] == 'Find Similar')) {
	$subject = $ticket->subject;
	$check = "SELECT tickets.Ticket_id, Received, Sender_Name, Sender_Email, Subject, Tech, Status, Select_Ticket FROM Tickets, ticket_to_admin WHERE Tickets.Ticket_id = ticket_to_admin.ticket_id AND Tickets.Subject LIKE '$subject'"; 
	$result = $db->query($check);
	$row = $result->fetch_array();
	#echo "$row";
	echo "<table border='1'><caption> <h2> Same Submitter Tickets </h2> </caption>";
	#Make column labels
	
	while ($next_element = each($row)){
		$next_element = each($row);
		$next_key = $next_element['key'];
		print "<th>" . $next_key . "</th>";
	}
	#Display table data
	$result = $db->query($check);
	echo "<form action = 'admin_mytickets.php' method='POST'>";
	while ($row = $result->fetch_object()) {
		echo "<tr align = 'center'>";
		echo "<td>$row->Ticket_id</td>";
		echo "<td>$row->Received</td> "; 
		echo "<td>$row->Sender_Name</td> ";
		echo "<td>$row->Sender_Email</td> ";
		echo "<td>$row->Subject</td> ";
		echo "<td>$row->Tech</td> ";
		echo "<td>$row->Status</td> ";
		echo "<td><input type = 'radio' name = 'selected' value = $row->Ticket_id> </td>";
		
		echo "</tr>";
	}
	echo "<tr align = 'center'>";

	echo "</tr>";
	echo "</table>";
	echo "	</form>";
	echo "</br></br>";
}


?>


<html>
 <head>
  <title>Assignment 2 user signin</title>
 </head>
 <body>
	<form action = "view_ticket.php" method="POST">
	<input type = "submit" name = "button" value = "Change Status"/>
	<input type = "submit" name = "button" value = "Assign Self"/>
	<input type = "submit" name = "button" value = "Remove Self"/>
	<input type = "submit" name = "button" value = "Email Submitter"/>
	<input type = "submit" name = "button" value = "Delete"/>
	<input type = "submit" name = "button" value = "Find Tickets from Same Submitter"/>
	<input type = "submit" name = "button" value = "Find Similar"/>
	</form> 
	
 
 </body>
</html>