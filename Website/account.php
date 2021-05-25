<?php
    session_start();
    if($_SESSION['type'] != 'voter' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');
    
    if(isset($_POST['Action'])){
    	if($_POST['Action'] == 'edit'){
    		$accountEmail = $_SESSION['email'];
            $name = $_POST['Name'];
            $municipality = $_POST['Municipality'];
            $surname = $_POST['Surname'];
            $email = $_POST['Email'];
            $phone = $_POST['Phone'];

            $query = "SELECT NationalID FROM Voter WHERE Email='$accountEmail'";
            $result = $conn->query($query);
            $id = $result->fetch_assoc()['NationalID'];

            $query = "SELECT UserID FROM User WHERE Email='$accountEmail';";
            $result = $conn->query($query);
            $userid = $result->fetch_assoc()['UserID'];

            if($name == ''){
                $query = "SELECT Name FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $name = $result->fetch_assoc()['Name'];
            }

            if($municipality == ''){
                $query = "SELECT MunicipalityId FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $muniID = $result->fetch_assoc()['MunicipalityId'];
            }else{
                $query = "SELECT MunicipalityID FROM Municipality WHERE Name='$municipality';";
                $result = $conn->query($query);
                $muniID = $result->fetch_assoc()['MunicipalityID'];
            }

            if($surname == ''){
                $query = "SELECT Surname FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $surname = $result->fetch_assoc()['Surname'];
            }

            if($email == ''){
                $query = "SELECT Email FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $email = $result->fetch_assoc()['Email'];
            }

            if($phone == ''){
                $query = "SELECT PhoneNr FROM Voter WHERE NationalID='$id';";
                $result = $conn->query($query);
                $phone = $result->fetch_assoc()['PhoneNr'];
            }

            $query = "UPDATE Voter SET Name='$name', Surname='$surname', Email='$email', PhoneNr='$phone', MunicipalityId='$muniID' WHERE UserID='$userid';";
            $result = $conn->query($query);

            $query = "UPDATE User SET Name='$name $surname', Email='$email' WHERE UserID='$userid';";
            $result = $conn->query($query);

            if($result){
                $msg = "User $userid updated!";
            }else{
                $msg = "Failed to update user!";
            }
        }
	}
?>

<html>
	<head>
		<title>Account Management</title>
	</head>
	<body>
		<center>
            <div style="background-color: gray; width: 225px; height: 310px;margin-top:25px" id="Register Voter">
                <h2>Manage Account</h2>
                <form method="POST" action="account.php" enctype="multipart/form-data">
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
