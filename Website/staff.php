<?php
    session_start();
    if($_SESSION['type'] != 'staff' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
?>

<html>
<head>
    <title>Staff Center</title>
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
    <div class="formcan" id="Register Voter">
        <h2>Staff Operations</h2>
        <a href="voters.php"><button>Manage Voters</button></a>
        <a href="candidates.php"><button>Manage Candidates</button></a>
        <a href="municipalities.php"><button>Manage Municipalities</button></a>
        <a href="reporting.html"><button>Reporting</button></a>
    </div>
</center>
</body>
</html>