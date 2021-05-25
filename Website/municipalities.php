<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');

    if(isset($_POST['Action'])){
    	if($_POST['Action'] == 'edit'){
            $oldID = $_POST['oldID'];
            $newID = $_POST['ID'];
            $name = $_POST['Name'];
            $type = $_POST['Type'];

            if($newID == ""){
                $newID = $oldID;
            }

            if($name == ""){
                $query = "SELECT Name FROM Municipality WHERE MunicipalityID='$oldID';";
                $result = $conn->query($query);
                $name = $result->fetch_assoc()['Name'];
            }

            if($type == ""){
                $query = "SELECT Type FROM Municipality WHERE MunicipalityID='$oldID';";
                $result = $conn->query($query);
                $type = $result->fetch_assoc()['Type'];
            }

            $query = "UPDATE Municipality SET MunicipalityID='$newID', Name='$name', Type='$type' WHERE MunicipalityID='$oldID';";
            $result = $conn->query($query);
            if($result){
                $msg = "Municipality updated!";
            }else{
                $msg = "Failed to update municipality!";
            }
        }
	}
?>

<html>
<head>
  <title>Municipality Management</title>
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
    <h2>Update Municipalities</h2>
    <form method="POST" class="formcan" action="municipalities.php" enctype="multipart/form-data">
      <p style="color: #002b6e; font-weight: bold;">Update municipality by ID, leave field blank to remain unchanged.</p>
      <label class ="formlab" id="Municipality-Label">Municipality (ID)</label>
      <input required class="canlab" name="oldID" type="text"><br>
      <hr class="new4"><br>
      <label class ="formlab" id="ID-Label">ID:</label><br>
      <input class="canlab" name="ID" type="text"><br>
      <label class ="formlab" id="Name-Label">Name:</label><br>
      <input class="canlab" name="Name" type="text"><br>
      <label class ="formlab" id="Name-Label">Type:</label><br>
      <input class="canlab" name="Type" type="text"><br><br>
      <input id="upmun" class="canlab" type="submit" value="Update">
      <input class="canlab" hidden name="Action" value="edit">
    </form>
    <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
  </div>
</center>
</body>
</html>