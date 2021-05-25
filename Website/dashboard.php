<?php
    session_start();
    if($_SESSION['type'] != 'voter' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
?>

<html>
    <head>
        <title>Voter Dashboard</title>
    </head>
    <body>
        <center>
            <div style="background-color: gray; width: 200px; height: 200px;margin-top:50px" id="Register Voter">
                <h2 style="padding-top: 25px">Dashboard</h2>
                <a href="account.php"><button style="margin-top:0px;width: 170px; height:35px;">Manage Account</button></a>
                <a href="vote.php"><button style="margin-top:15px;width: 170px; height:35px;">Vote</button></a>
            </div>
        </center>
    </body>
</html>