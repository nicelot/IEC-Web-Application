<?php
	require('connect.php');
	start_session();
	// LOGIN AND ASSIGN AUTH
	$sql = "SELECT Type, Email FROM User WHERE Email='".$_POST['Email']."';";
	$res = $conn->query($sql);
	if($res->num_rows > 0){
		// USER EXISTS
		$user = $res->fetch_assoc();
		if($user['Type'] == 'Staff'){
			$sql = "SELECT * FROM Staff WHERE email='".$_POST['Email']."';";
			$res = $conn->query($sql);
			$row = $res->fetch_assoc();
			if($row['Password'] == $_POST['Password']){
				$_SESSION['type'] = 'staff';
				$_SESSION['auth'] = 'true';
				header("Location: staff.html");
			}else{
				echo "Wrong password for account ".$row['email']. "!";
			}
		}else{
			$sql = "SELECT * FROM Voter WHERE email='".$_POST['Email']."';";
			$res = $conn->query($sql);
			$row = $res->fetch_assoc();
			if($row['Password'] == $_POST['Password']){
				$_SESSION['type'] = 'voter';
				$_SESSION['auth'] = 'true';
				header("Location: vote.html");
			}else{
				echo "Wrong password for account ".$row['email']. "!";
			}
		}
	}else{
		// USER NOT FOUND
		//echo "user not found";
		header("Location: login.html");
	}

	$conn->close();
?>