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
  <title>Candidate Registration</title>
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
  <div id="Register Voter">
    <h2>Register Candidate</h2>
    <form method="POST" class="formcan" action="register.php" enctype="multipart/form-data">
      <label class ="formlab">Name: </label><br>
      <input required class="canlab" name="Name" type="text"><br>
      <label class ="formlab">Surname: </label><br>
      <input required class="canlab" name="Surname" type="text"><br>
      <label class ="formlab">Municipality: </label><br>
      <input required class="canlab" name="Municipality" type="text"><br>
      <label class ="formlab">Party: </label><br>
      <input required class="canlab" name="Party" type="text"><br><br>
      <input id="regcand" class="canlab" type="submit" value="Register">
      <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
      <input hidden name="Action" value="create">
    </form>
  </div>
  <div id="Register Candidate">
    <h2>Update Candidate</h2>
    <p style="color: #002b6e; font-weight: bold;">Update candidate by name and surname, leave field blank to remain unchanged.</p>
    <form method="POST" class="formcan" action="register.php" enctype="multipart/form-data">
      <label class ="formlab" id="oldName-Label">Name: </label><br>
      <input required class="canlab" name="oldName" type="text"><br>
      <label class ="formlab" id="oldSurname-Label">Surname: </label><br>
      <input required class="canlab" name="oldSurname" type="text"><br>
      <hr class="new4"><br>
      <label class ="formlab" id="Name-Label">Name: </label><br>
      <input required class="canlab" name="Name" type="text"><br>
      <label class ="formlab" id="Surname-Label">Surname: </label><br>
      <input required class="canlab" name="Surname" type="text"><br>
      <label class ="formlab" id="Municipality-Label">Municipality: </label><br>
      <input required class="canlab" name="Municipality" type="text"><br>
      <label class ="formlab" id="Party-Label">Party: </label><br>
      <input required class="canlab" name="Party" type="text"><br><br>
      <input id="regcan" class="canlab" type="submit" value="Register">
      <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
      <input hidden name="Action" value="edit">
    </form>
  </div>
</center>
</body>
</html>
