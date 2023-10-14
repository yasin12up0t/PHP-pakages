<?php
session_start();
if(!isset($_SESSION["user"]))
{
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>index</title>
</head>
<body>
    <div class="container">
    <h1>welcome</h1>
    <a href="logout.php" class="btn btn-warning">logout</a>
    </div>
</body>
</html>