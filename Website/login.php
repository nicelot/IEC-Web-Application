<html>
	<head>
	  <title>IEC Login</title>
	  <link href="style.css" rel="stylesheet" type="text/css">
	  <link href="votercss.css" rel="stylesheet" type="text/css">
	  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
	<nav class="navtop">
	  <div>
	    <h1>Electoral Commission of South Africa</h1>
	  </div>
	</nav>
	<center>
	  <h2 class="formloghead">IEC Sign In</h2>
	  <div>
	    <form method="post" class="formlog" action="login.php" enctype="multipart/form-data">
	      <div>
	        <label class="formlab"><b>Email</b></label><br>
	        <input name="Email" type="text" placeholder="Enter Email" required><br><br>
	        <label class="formlab"><b>Password</b></label><br>
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
					$sql = "SELECT * FROM Staff WHERE Email='" . $_POST['Email'] . "';";
					$res = $conn->query($sql);
					$row = $res->fetch_assoc();
					if($row['Password'] == $_POST['Password']){
						$_SESSION['type'] = 'staff';
						$_SESSION['auth'] = 'true';
						header("Location: staff.php");
					}else{
						echo '<h3 style="color: red">Incorrect email or password.</h3>';
					}
				}else if($user['Type'] == 'Voter'){
					$sql = "SELECT * FROM Voter WHERE Email='".$_POST['Email']."';";
					$res = $conn->query($sql);
					$row = $res->fetch_assoc();
					if($row['Password'] == $_POST['Password']){
						$_SESSION['type'] = 'voter';
						$_SESSION['auth'] = 'true';
						$_SESSION['email'] = $_POST['Email'];
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

