<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');

    if(isset($_POST['Action'])){
    	if($_POST['Action'] == 'create'){
		    $name = $_POST['Name'];
            $surname = $_POST['Surname'];
	        $municipality = $_POST['Municipality'];
			$party = $_POST['Party'];

	        $query = "SELECT MunicipalityID FROM Municipality WHERE Name='$municipality'";
	        $result = $conn->query($query);
	        $muniID = $result->fetch_assoc()['MunicipalityID'];

            $query = "SELECT Type FROM Municipality WHERE Name='$municipality'";
            $result = $conn->query($query);
            $type = $result->fetch_assoc()['Type'];

            $query = "SELECT PartyID FROM Party WHERE Name='$party'";
            $result = $conn->query($query);
            $partyID = $result->fetch_assoc()['PartyID'];

	        $query = "INSERT INTO Candidate (Name, Surname, PartyId, Type, MunicipalityId) VALUES ('$name', '$surname', '$partyID', '$type', '$muniID');";
	        $result = $conn->query($query);
	        if($result){
	        	$msg = "Candidate registered!";
	        }else{
	        	$msg = "Failed to register candidate!";
	        }
		}else if($_POST['Action'] == 'edit'){
            $oldName = $_POST['oldName'];
            $oldSurname = $_POST['oldSurname'];
            $name = $_POST['Name'];
            $surname = $_POST['Surname'];
            $municipality = $_POST['Municipality'];
            $party = $_POST['Party'];

            if($name == ""){
                $query = "SELECT Name FROM Candidate WHERE Name='$oldName' AND Surname='$oldSurname';";
                $result = $conn->query($query);
                $name = $result->fetch_assoc()['Name'];
            }

            if($surname == ""){
                $query = "SELECT Surname FROM Candidate WHERE Name='$oldName' AND Surname='$oldSurname';";
                $result = $conn->query($query);
                $surname = $result->fetch_assoc()['Surname'];
            }

            if($municipality == ""){
                $query = "SELECT MunicipalityId FROM Candidate WHERE Name='$oldName' AND Surname='$oldSurname';";
                $result = $conn->query($query);
                $muniID = $result->fetch_assoc()['MunicipalityId'];

                $query = "SELECT Type FROM Candidate WHERE Name='$oldName' AND Surname='$oldSurname';";
                $result = $conn->query($query);
                $type = $result->fetch_assoc()['Type'];
            }else{
                $query = "SELECT MunicipalityID FROM Municipality WHERE Name='$municipality';";
                $result = $conn->query($query);
                $muniID = $result->fetch_assoc()['MunicipalityID'];

                $query = "SELECT Type FROM Municipality WHERE Name='$municipality';";
                $result = $conn->query($query);
                $type = $result->fetch_assoc()['Type'];
            }

            if($party == ""){
                $query = "SELECT PartyId FROM Candidate WHERE Name='$oldName' AND Surname='$oldSurname';";
                $result = $conn->query($query);
                $partyID = $result->fetch_assoc()['PartyId'];
            }else{
                $query = "SELECT PartyID FROM Party WHERE Name='$party';";
                $result = $conn->query($query);
                $partyID = $result->fetch_assoc()['PartyID'];
            }

            $query = "UPDATE Candidate SET Name='$name', Surname='$surname', PartyId='$partyID', Type='$type', MunicipalityId='$muniID' WHERE Name='$oldName' AND Surname='$oldSurname';";
            $result = $conn->query($query);
            if($result){
                $msg = "Candidate updated!";
            }else{
                $msg = "Failed to update candidate!";
            }
        }
	}
?>

<html>
	<head>
		<title>Candidate Management</title>
	</head>
	<body>
		<center>
            <div style="background-color: gray; width: 225px; height: 260px;margin-top:25px" id="Register Voter">
                <h2>Register Candidate</h2>
                <form method="POST" action="candidates.php" enctype="multipart/form-data">
                    <label id="Name-Label">Name: </label><br>
                    <input required name="Name" type="text"><br>
                    <label id="Surname-Label">Surname: </label><br>
                    <input required name="Surname" type="text"><br>
                    <label id="Municipality-Label">Municipality: </label><br>
                    <input required name="Municipality" type="text"><br>
                    <label id="Party-Label">Party: </label><br>
                    <input required name="Party" type="text"><br><br>
                    <input type="submit" value="Register"><br>
                    <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
                    <input hidden name="Action" value="create">
                </form>
            </div>
            <div style="background-color: gray; width: 225px; height: 415px;margin-top:25px" id="Register Voter">
                <h2>Update Candidate</h2>
                <p style="margin-top:-20px">Update candidate by name and surname, leave field blank to remain unchanged.</p>
                <form method="POST" action="candidates.php" enctype="multipart/form-data">
                    <label id="oldName-Label">Name: </label><br>
                    <input required name="oldName" type="text"><br>
                    <label id="oldSurname-Label">Surname: </label><br>
                    <input required name="oldSurname" type="text"><br><br>
                    <label id="Name-Label">Name: </label><br>
                    <input name="Name" type="text"><br>
                    <label id="Surname-Label">Surname: </label><br>
                    <input name="Surname" type="text"><br>
                    <label id="Municipality-Label">Municipality: </label><br>
                    <input name="Municipality" type="text"><br>
                    <label id="Party-Label">Party: </label><br>
                    <input name="Party" type="text"><br><br>
                    <input type="submit" value="Register">
                    <input hidden name="Action" value="edit">
                </form>
            </div>
        </center>
	</body>
</html>
