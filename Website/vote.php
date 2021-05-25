<?php
    session_start();
    if($_SESSION['type'] != 'voter' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
    require('connect.php');

    if(isset($_POST['Action'])){
        if($_POST['Action'] == 'create'){
            $candidate = $_POST['Candidate'];
            $accountEmail = $_SESSION['email'];

            $query = "SELECT has_voted FROM Voter WHERE Email='$accountEmail';";
            $result = $conn->query($query);
            $voted = $result->fetch_assoc()['has_voted'];

            if($voted != 1){
                $query = "SELECT Type FROM Candidate WHERE CandidateID='$candidate'";
                $result = $conn->query($query);
                $type = $result->fetch_assoc()['Type'];

                $query = "INSERT INTO `Votes` (Type, CandidateID) VALUES ('$type', '$candidate');";
                $result = $conn->query($query);

                $query = "UPDATE Voter SET has_voted=1 WHERE Email='$accountEmail';";
                $result = $conn->query($query);

                if($result){
                    $msg = "Vote cast!";
                }else{
                    $msg = "Failed to cast vote!";
                }
            }else{
                $msg = "You have already voted!";
            }
        }
    }
?>

<html>
<head>
    <title>Vote!</title>
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
        <h2>Vote!</h2>
        <form method="POST" class="formcan" action="vote.php" enctype="multipart/form-data">
            <label class ="formlab" id="Candidate-Label">Candidate:</label><br>
            <input required class="canlab" name="Candidate" type="text"><br>
            <input id="vote" class="canlab" type="submit" value="Register">
            <?php echo "<h3 style=\"color: red\">$msg</h3>" ?>
            <input hidden name="Action" value="create">
        </form>
    </div>
    <div id="Register Voter">
        <h2>Candidates</h2>
        <div style="margin: 20px;background-color: #3f69a8; border-radius: 5px; padding: 15px 0px 15px 0px;width: 500px">
            <?php
                require('connect.php');

                $sql = "SELECT CandidateID, Name, Surname FROM Candidate";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  echo "<table><tr><th>ID</th><th>Name</th></tr>";
                  while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["CandidateID"]."    -    </td><td>".$row["Name"]." ".$row["Surname"]."</td></tr>";
                  }
                  echo "</table>";
                } else {
                  echo "0 results";
                }
                $conn->close();
            ?>
        </div>
    </div>
</center>
</body>
</html>