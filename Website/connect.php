<?php
	$server= "localhost";
	$user = "IEC";
	$pass = "IEC_PASSWORD";
	$db = "IEC_DB";

	$conn = new mysqli($server, $user, $pass, $db);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>