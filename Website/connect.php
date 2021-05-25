<?php
	$server= "localhost";
	$user = "IEC";
	$pass = "IEC_PASSWORD";
	$db = "IEC_DB";

	// Create connection
	$conn = new mysqli($server, $user, $pass, $db);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>