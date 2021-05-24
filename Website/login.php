<?php
$server= "localhost";
$user = "IEC";
$pass = "IEC_PASSWORD";
$db = "IEC_DB";

// Create connection
$conn = new mysqli($server, $user, $pass, $db);
session_start();

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if($conn->query("SELECT Type, Email FROM User WHERE Email='"+$_POST['Email']+"';")->fetch_assoc()['Type'] == 'Staff'){
	$res = $conn->query("SELECT * FROM Staff WHERE email='"+$_POST['email']+"';")->fetch_assoc();
	if($res['Password'] == $_POST['Password']){
		$_SESSION['type'] = 'staff';
		$_SESSION['auth'] = 'true';
	}
}else{
	$res = $conn->query("SELECT * FROM Voter WHERE email='"+$_POST['email']+"';")->fetch_assoc();
	if($res['Password'] == $_POST['Password']){
		$_SESSION['type'] = 'voter';
		$_SESSION['auth'] = 'true';
	}
}

if ($result->num_rows > 0) {
  // output data of each row
	echo " +--------------+\n";
	while($row = $result->fetch_assoc()) {
		echo " | ".  $row['PartyID']. "\t| ". $row['Name']. "\t|\n";
	}
	echo " +--------------+\n";
} else {
	echo "0 results";
}
$conn->close();
?>