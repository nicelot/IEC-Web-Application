<?php
    session_start();
    if($_SESSION['type'] != 'voter' || $_SESSION['auth'] != 'true'){
        header("location: login.php");
    }
?>

<html>
<head>
  <title>Voter Dashboard</title>
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
  <div class="formcan" id="Register Voter">
    <h2>Dashboard</h2>
    <a href="account.php"><button>Manage Account</button></a>
    <a href="vote.php"><button>Vote</button></a>
  </div>
</center>
</body>
</html>