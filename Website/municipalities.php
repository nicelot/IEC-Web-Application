<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
	require('connect.php');
    // If the values are posted, insert them into the database.
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
    </head>
    <body>
        <center>
            <div style="background-color: gray; width: 200px; height: 375px;margin-top:25px" id="Register Voter">
                <h2>Update Municipalities</h2>
                <form method="POST" action="municipalities.php" enctype="multipart/form-data">
                    <p style="margin-top:-10px">Update municipality by ID, leave field blank to remain unchanged.</p>
                    <label id="Municipality-Label">Municipality (ID)</label>
                    <input required name="oldID" type="text"><br><br>
                    <label id="ID-Label">ID:</label><br>
                    <input name="ID" type="text"><br>
                    <label id="Name-Label">Name:</label><br>
                    <input name="Name" type="text"><br>
                    <label id="Name-Label">Type:</label><br>
                    <input name="Type" type="text"><br><br>
                    <input type="submit" value="Update">
                    <input hidden name="Action" value="edit">
                </form>
                <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
            </div>
        </center>
    </body>
</html>