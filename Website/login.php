<html>
	<head>
		<title>IEC Login</title>
	</head>
	<body>
	  <center>
			<div style="margin-top: 100px;padding-top:15px;padding-bottom:20px;width: 300px;height: 250px;background-color: grey">
				<h2>IEC</h2>
				<form method="post" action="login.php" enctype="multipart/form-data">
				    <div>
					    <label><b>Email</b></label><br>
					    <input name="Email" type="text" placeholder="Enter Email" required><br>
					    <label><b>Password</b></label><br>
					    <input name="Password" type="password" placeholder="Enter Password" required><br><br>
					    <button type="submit">Login</button><br><br>
				    </div>
			  	</form>
			  	<?php
					require('connect.php');
					session_start();
					// LOGIN AND ASSIGN AUTH
					$sql = "SELECT Type, Email FROM User WHERE Email='" . $_POST['Email'] . "';";
					$res = $conn->query($sql);
					if($res->num_rows > 0){
						// USER EXISTS
						$user = $res->fetch_assoc();
						if($user['Type'] == 'Staff'){
							$sql = "SELECT * FROM Staff WHERE email='" . $_POST['Email'] . "';";
							$res = $conn->query($sql);
							$row = $res->fetch_assoc();
							if($row['Password'] == $_POST['Password']){
								$_SESSION['type'] = 'staff';
								$_SESSION['auth'] = 'true';
								header("Location: staff.php");
							}else{
								echo '<h3 style="color: red">Incorrect email or password.</h3>';
							}
						}else{
							$sql = "SELECT * FROM Voter WHERE email='".$_POST['Email']."';";
							$res = $conn->query($sql);
							$row = $res->fetch_assoc();
							if($row['Password'] == $_POST['Password']){
								$_SESSION['type'] = 'voter';
								$_SESSION['auth'] = 'true';
								header("Location: dashboard.php");
							}else{
								echo '<h3 style="color: red">Incorrect email or password.</h3>';
							}
						}
					}else if(isset($_POST['Email'])){
						// USER NOT FOUND
						echo '<h3 style="color: red">Incorrect email or password.</h3>';
					}
					$conn->close();
				?>
			</div>
		</center>
	</body>
</html>

