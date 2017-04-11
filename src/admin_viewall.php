<?php
session_start();
print_r($_SESSION);
print_r($_POST);

#If a button was selected, do corresponding action
#Display open tickets
if (isset($_POST['action']) && ($_POST['action'] == 'View Open Tickets')) {
    header("Location: admin_home.php");
	exit;
} 
#Display admin's tickets
else if (isset($_POST['action']) && $_POST['action'] == 'View My Tickets') {
	header("Location: admin_mytickets.php");
	exit;
}
#log admin out
else if (isset($_POST['action']) && $_POST['action'] == 'Logout') {
    session_destroy;
	header("Location: admin_signin.php");
	exit;
} 
#view ticket selected
else if (isset($_POST['action']) && $_POST['action'] == 'View Selected Ticket' && $_POST['selected']) {
	$_SESSION['ticketID'] = $_POST['selected'];
	header("Location: view_ticket.php");
	exit;
} 
#view unassigned tickets
else if (isset($_POST['action']) && $_POST['action'] == 'View Unassigned Tickets') {
    header("Location: admin_viewunassigned.php");
	exit;
} 

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

#Create table that displays open and closed tickets
$check = "SELECT tickets.Ticket_id, Received, Sender_Name, Sender_Email, Subject, Tech, Status, Select_Ticket FROM Tickets, ticket_to_admin WHERE Tickets.Ticket_id = ticket_to_admin.ticket_id"; 

#display sorted by
if (isset($_POST['action']) && $_POST['action'] == 'Sort' && isset($_POST['sort'])) {
	$sortby = $_POST['sort'];
	$check = "SELECT tickets.Ticket_id, Received, Sender_Name, Sender_Email, Subject, Tech, Status, Select_Ticket FROM Tickets, ticket_to_admin WHERE Tickets.Ticket_id = ticket_to_admin.ticket_id ORDER BY $sortby"; 
	}
 
$result = $db->query($check);
echo "<table border='1'><caption> <h2> Technical Support Open Tickets </h2> </caption>";
#Make column labels
$row = $result->fetch_array();
while ($next_element = each($row)){
	$next_element = each($row);
	$next_key = $next_element['key'];
	print "<th>" . $next_key . "</th>";
}
#Display table data
$result = $db->query($check);
echo "<form action = 'admin_viewall.php' method='POST'>";
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
	#echo "<form action = SelectedTicket.php";
	#echo "method = 'Post'>";
	#echo "<td> <input type = 'radio' name = 'ticket_select' value= '$row->Ticket_id'></td>";
	#close last row
	echo "</tr>";
}
echo "<tr align = 'center'>";

echo "<td>Sort By<input type = 'radio' name = 'sort' value = 'Ticket_id'></td>";
echo "<td>Sort By<input type = 'radio' name = 'sort' value = 'Received'></td> "; 
echo "<td>Sort By<input type = 'radio' name = 'sort' value = 'Sender_Name'</td> ";
echo "<td>Sort By<input type = 'radio' name = 'sort' value = 'Sender_Email'</td> ";
echo "<td>Sort By<input type = 'radio' name = 'sort' value = 'Subject'</td> ";
echo "</tr>";
echo "</table>";
echo "<br/><br/>";

echo "	<input type = 'submit' name = 'action' value = 'View Open Tickets'> ";
echo "	<input type = 'submit' name = 'action' value = 'View My Tickets'> ";
echo "	<input type = 'submit' name = 'action' value = 'Sort'> ";
echo "	<input type = 'submit' name = 'action' value = 'Logout'> ";
echo "	<input type = 'submit' name = 'action' value = 'View Selected Ticket'> ";
echo "	<input type = 'submit' name = 'action' value = 'View Unassigned Tickets'>"; 
echo "	</form>";

?>


<html>
 <head>
  <title>Buttons</title>
 </head>
 <body>
	

 </body>
</html>



<?php

/**




 
Code where I access the value of radio button, in a separate script:
$db = new mysqli('localhost', 'root', '', 'Ticket_System');
if ($db->connect_error):
die ("Could not connect to db: " . $db->connect_error);
endif;
$selected = $_POST['ticket_select'];
echo $selected;



##########
Try putting echo "<form action = SelectedTicket.php"; echo "method = 'Post'>"; 
above the beginning of your while loop! Once you do that you also probably have to put double quotes around 
$row->Ticket_id when you assign it to the value - let me know how that works!

so echo "<form action='selectedTicket.php', method= 'POST'>"
echo "<td> <input type = 'radio' name = 'ticket_select' value= " . $row->Ticket_id . "></td>";
*/
?>