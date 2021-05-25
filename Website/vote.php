<?php
    session_start();
    if($_SESSION['type'] != 'voter' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
    require('connect.php');

    if(isset($_POST['Action'])){
        if($_POST['Action'] == 'create'){
            $candidate = $_POST['Candidate'];
            $name = $_POST['Name'];

            $query = "INSERT INTO `User` (Type, Name, Email) VALUES ('Voter', '$name', '$email')";
            $result = $conn->query($query);

            $query = "SELECT UserID FROM User WHERE Email='$email'";
            $result = $conn->query($query);
            $UserID = $result->fetch_assoc()['UserID'];

            $query = "SELECT MunicipalityID FROM Municipality WHERE Name='$municipality'";
            $result = $conn->query($query);
            $muniID = $result->fetch_assoc()['MunicipalityID'];

            $query = "INSERT INTO `Vote` (NationalID, Name, Surname, Password, Email, PhoneNr, MunicipalityId, UserId, has_voted) VALUES ('$id', '$name', '$surname', '$password', '$email', '$phone', '$muniID', '$UserID', 0);";
            $result = $conn->query($query);
            if($result){
                $msg = "Vote cast!";
            }else{
                $msg = "Failed to cast vote!";
                $query = "DELETE FROM User WHERE UserID = $UserID";
                $result = $conn->query($query);
            }
        }
    }
?>

<html>
    <head>
        <title>Vote!</title>
    </head>
    <body>
        <center>
            <div style="background-color: gray; width: 225px; height: 250px;margin-top:25px" id="Register Voter">
                <h2 style="padding-top: 25px">Vote!</h2>
                <form method="POST" action="vote.php" enctype="multipart/form-data">
                    <label id="Candidate-Label">Candidate:</label><br>
                    <input required name="Candidate" type="text"><br>
                    <label id="Municipality-Label">Municipality Type: </label><br>
                    <input required name="Type" type="text"><br><br>
                    <input type="submit" value="Register">
                    <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
                    <input hidden name="Action" value="create">
                </form>
            </div>
        </center>
    </body>
</html>