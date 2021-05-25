<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
?>

<html>
    <head>
        <title>Staff Center</title>
    </head>
    <body>
        <center>
            <div style="background-color: gray; width: 200px; height: 280px;margin-top:50px" id="Register Voter">
                <h2 style="padding-top: 25px">Staff Operations</h2>
                <a href="register.php"><button style="margin-top:0px;width: 170px; height:35px;">Manage Voters</button></a>
                <a href="manage_municipalities.html"><button style="margin-top:15px;width: 170px; height:35px;">Manage Municipalities</button></a>
                <a href="reporting.html"><button style="margin-top:15px;width: 170px; height:35px;">Reporting</button></a>
            </div>
        </center>
    </body>
</html>