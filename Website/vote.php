<?php
    session_start();
    if($_SESSION['type'] != 'voter' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
?>

<html>
    <head>
        <title>Vote!</title>
    </head>
    <body>
        <center>
            <div style="background-color: gray; width: 200px; height: 280px;margin-top:25px" id="Register Voter">
                <h2 style="padding-top: 25px">Vote</h2>
                
            </div>
        </center>
    </body>
</html>