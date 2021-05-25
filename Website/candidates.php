<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');
    // If the values are posted, insert them into the database.
    //Candidate (Name, Surname, PartyId, Type, MunicipalityId)
    if(isset($_POST['Action'])){
    	if($_POST['Action'] == 'create'){
		    $id = $_POST['ID'];
	        $name = $_POST['Name'];
	        $municipality = $_POST['Municipality'];
            $surname = $_POST['Surname'];
			$email = $_POST['Email'];
	        $phone = $_POST['Phone'];
	        $password = $_POST['Password'];

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
            <div style="background-color: gray; width: 225px; height: 270px;margin-top:25px" id="Register Voter">
                <h2>Register Candidate</h2>
                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <label id="Name-Label">Name: </label><br>
                    <input required name="Name" type="text"><br>
                    <label id="Surname-Label">Surname: </label><br>
                    <input required name="Surname" type="text"><br>
                    <label id="Municipality-Label">Municipality: </label><br>
                    <input required name="Municipality" type="text"><br>
                    <label id="Party-Label">Party: </label><br>
                    <input required name="Party" type="text"><br><br>
                    <input type="submit" value="Register">
                    <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
                    <input hidden name="Action" value="create">
                </form>
            </div>
            <div style="background-color: gray; width: 225px; height: 415px;margin-top:25px" id="Register Voter">
                <h2>Update Candidate</h2>
                <p style="margin-top:-20px">Update candidate by name and surname, leave field blank to remain unchanged.</p>
                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <label id="oldName-Label">Name: </label><br>
                    <input required name="oldName" type="text"><br>
                    <label id="oldSurname-Label">Surname: </label><br>
                    <input required name="oldSurname" type="text"><br><br>
                    <label id="Name-Label">Name: </label><br>
                    <input required name="Name" type="text"><br>
                    <label id="Surname-Label">Surname: </label><br>
                    <input required name="Surname" type="text"><br>
                    <label id="Municipality-Label">Municipality: </label><br>
                    <input required name="Municipality" type="text"><br>
                    <label id="Party-Label">Party: </label><br>
                    <input required name="Party" type="text"><br><br>
                    <input type="submit" value="Register">
                    <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
                    <input hidden name="Action" value="edit">
                </form>
            </div>
        </center>
	</body>
</html>
