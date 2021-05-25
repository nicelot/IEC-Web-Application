<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');

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

            $query = "SELECT Email FROM Voter WHERE NationalID='$id';";
            $result = $conn->query($query);
            $userEmail = $result->fetch_assoc()['Email'];

            $query = "SELECT UserID FROM User WHERE Email='$userEmail';";
            $result = $conn->query($query);
            $userid = $result->fetch_assoc()['UserID'];

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

            $query = "UPDATE User SET Name='$name', Email='$email' WHERE UserID='$userid';";
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
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="votercss.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<nav class="navtop">
    <div>
        <h1>Electoral Commission of South Africa</h1>
        <a href="results.php"><i class="fas fa-poll-h"></i>Results</a>
    </div>
</nav>
<center>
    <div id="Register Voter">
        <h2>Register voter</h2>
        <form method="POST" class="formcan" action="register.php" enctype="multipart/form-data">
            <label id="ID-Label" class ="formlab">ID:</label><br>
            <input required class="canlab" name="ID" type="text"><br>
            <label id="Name-Label" class ="formlab">Name: </label><br>
            <input required class="canlab" name="Name" type="text"><br>
            <label id="Surname-Label" class ="formlab">Surname: </label><br>
            <input required class="canlab" name="Surname" type="text"><br>
            <label id="Municipality-Label" class ="formlab">Municipality: </label><br>
            <input required class="canlab" name="Municipality" type="text"><br>
            <label id="Email-Label" class ="formlab">Email: </label><br>
            <input required class="canlab" name="Email" type="text"><br>
            <label id="Phone-Label" class ="formlab">Phone: </label><br>
            <input required class="canlab" name="Phone" type="text"><br>
            <label id="Password-Label"class ="formlab">Password: </label><br>
            <input required class="canlab" name="Password" type="Password"><br><br>
            <input id="regvot" class="canlab" type="submit" value="Register">
            <!--<?php echo "<h3 style=\"color: red\">$msg</h3>" ?>-->
            <input hidden name="Action" value="create">
        </form>
    </div>
    <div id="Register Voter">
        <h2>Update voter</h2>
        <p style="color: #002b6e; font-weight: bold;">Update voter by ID, leave field blank to remain unchanged.</p>
        <form method="POST" class="formcan" action="register.php" enctype="multipart/form-data">
            <label id="ID-Label" class ="formlab">ID of Voter:</label><br>
            <input required class="canlab" name="ID" type="text"><br>
            <label id="Name-Label" class ="formlab">Name: </label><br>
            <input class="canlab" name="Name" type="text"><br>
            <label id="Surname-Label" class ="formlab">Surname: </label><br>
            <input class="canlab" name="Surname" type="text"><br>
            <label id="Municipality-Label" class ="formlab">Municipality: </label><br>
            <input class="canlab" name="Municipality" type="text"><br>
            <label id="Email-Label" class ="formlab">Email: </label><br>
            <input class="canlab" name="Email" type="text"><br>
            <label id="Phone-Label" class ="formlab">Phone: </label><br>
            <input class="canlab" name="Phone" type="text"><br><br>
            <input id="upvote" class="canlab" type="submit" value="Update">
            <input hidden name="Action" value="edit">
        </form>
    </div>
</center>
</body>
</html>
