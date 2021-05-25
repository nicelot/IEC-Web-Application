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

	// LOGIN AND ASSIGN AUTH
	$user = $conn->query("SELECT Type, Email FROM User WHERE Email='"+$_POST['Email']+"';")->fetch_assoc();
	if($user->num_rows > 0){
		// USER EXISTS
		if($user['Type'] == 'Staff'){
			$res = $conn->query("SELECT * FROM Staff WHERE email='"+$_POST['Email']+"';")->fetch_assoc();
			if($res['Password'] == $_POST['Password']){
				$_SESSION['type'] = 'staff';
				$_SESSION['auth'] = 'true';
				header("Location: localhost/staff.html");
			}
		}else{
			$res = $conn->query("SELECT * FROM Voter WHERE email='"+$_POST['Email']+"';")->fetch_assoc();
			if($res['Password'] == $_POST['Password']){
				$_SESSION['type'] = 'voter';
				$_SESSION['auth'] = 'true';
				header("Location: localhost/voter.html");
			}
		}
	}else{
		// USER NOT FOUND
		echo "USER NOT FOUND!";
	}

	$conn->close();
?>