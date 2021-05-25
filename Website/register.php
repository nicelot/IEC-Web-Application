<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');
    // If the values are posted, insert them into the database.
    if(isset($_POST['Action'])){
    	if($_POST['Action'] == 'create'){
		    $id = $_POST['ID'];
	        $name = $_POST['Name'];
	        $municipality = $_POST['Municipality'];
            $surname = $_POST['Surname'];
			$email = $_POST['Email'];
	        $phone = $_POST['Phone'];
	        $password = $_POST['Password'];
	        $action = $_POST['Action'];

	        $query = "INSERT INTO `User` (Type, Name, Email) VALUES ('Voter', '$name', '$email')";
	        $result = $conn->query($query);

	        $query = "SELECT UserID FROM User WHERE Email='$email'";
	        $result = $conn->query($query);
	        $UserID = $result->fetch_assoc()['UserID'];

	        $query = "SELECT MunicipalityID FROM Municipality WHERE Name='$municipality'";
	        $result = $conn->query($query);
	        $muniID = $result->fetch_assoc()['MunicipalityID'];

	        $query = "INSERT INTO `Voter` (NationalID, Name, Surname, Password, Email, PhoneNr, MunicipalityId, UserId, has_voted) VALUES ('$id', '$name', '$surname', '$password', '$email', '$phone', '$muniID', '$UserID', 0);";
	        $result = $conn->query($query);
	        if($result){
	        	$msg = "User registered!";
	        }else{
	        	$msg = "Failed to register user!";
                $query = "DELETE FROM User WHERE UserID = $UserID";
                $result = $conn->query($query);
	        }
		}else if($_POST['Action'] == 'edit'){
            $id = $_POST['ID'];
            $name = $_POST['Name'];
            $municipality = $_POST['Municipality'];
            $surname = $_POST['Surname'];
            $email = $_POST['Email'];
            $phone = $_POST['Phone'];
            $password = $_POST['Password'];
            $action = $_POST['Action'];

            if(!isset($_POST['Name'])){
                $query = "SELECT Name FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $name = $result->fetch_assoc()['Name'];
            }

            if(!isset($_POST['Municipality'])){
                $query = "SELECT MunicipalityId FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $muniID = $result->fetch_assoc()['MunicipalityId'];
            }else{
                $query = "SELECT MunicipalityID FROM Municipality WHERE Name='$municipality';";
                $result = $conn->query($query);
                $muniID = $result->fetch_assoc()['MunicipalityID'];
            }

            if(!isset($_POST['Surname'])){
                $query = "SELECT Surname FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $surname = $result->fetch_assoc()['Surname'];
            }

            if(!isset($_POST['Email'])){
                $query = "SELECT Email FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $email = $result->fetch_assoc()['Email'];
            }

            if(!isset($_POST['Phone'])){
                $query = "SELECT PhoneNr FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $phone = $result->fetch_assoc()['PhoneNr'];
            }

            $query = "UPDATE Voter SET Name='$name', Surname='$surname', Email='$email', PhoneNr='$phone', MunicipalityId='$muniID' WHERE NationalID='$id';";
            $result = $conn->query($query);
            if($result){
                $msg = "User updated!";
            }else{
                $msg = "Failed to update user!";
            }
        }
	}
?>

<html>
	<head>
		<title>Voter Registration</title>
	</head>
	<body>
		<center>
            <div style="background-color: gray; width: 225px; height: 375px;margin-top:25px" id="Register Voter">
                <h2>Register voter</h2>
                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <label id="ID-Label">ID:</label><br>
                    <input required name="ID" type="text"><br>
                    <label id="Name-Label">Name: </label><br>
                    <input required name="Name" type="text"><br>
                    <label id="Surname-Label">Surname: </label><br>
                    <input required name="Surname" type="text"><br>
                    <label id="Municipality-Label">Municipality: </label><br>
                    <input required name="Municipality" type="text"><br>
                    <label id="Email-Label">Email: </label><br>
                    <input required name="Email" type="text"><br>
                    <label id="Phone-Label">Phone: </label><br>
                    <input required name="Phone" type="text"><br>
                    <label id="Password-Label">Password: </label><br>
                    <input required name="Password" type="Password"><br><br>
                    <input type="submit" value="Register">
                    <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
                    <input hidden name="Action" value="create">
                </form>
            </div>
            <div style="background-color: gray; width: 225px; height: 375px;margin-top:25px" id="Register Voter">
                <h2>Update voter</h2>
                <p style="margin-top:-20px">Update voter by ID, leave field blank to remain unchanged.</p>
                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <label id="ID-Label">ID of Voter:</label><br>
                    <input required name="ID" type="text"><br>
                    <label id="Name-Label">Name: </label><br>
                    <input name="Name" type="text"><br>
                    <label id="Surname-Label">Surname: </label><br>
                    <input name="Surname" type="text"><br>
                    <label id="Municipality-Label">Municipality: </label><br>
                    <input name="Municipality" type="text"><br>
                    <label id="Email-Label">Email: </label><br>
                    <input name="Email" type="text"><br>
                    <label id="Phone-Label">Phone: </label><br>
                    <input name="Phone" type="text"><br><br>
                    <input type="submit" value="Update">
                    <input hidden name="Action" value="edit">
                </form>
            </div>
        </center>
	</body>
</html>
