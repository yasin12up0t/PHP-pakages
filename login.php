<?php
session_start();
if(isset($_SESSION["user"]))
{
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["login"]))
        {
            $email=$_POST["email"];
            $password=$_POST["password"];
            require_once "Database.php";
            $sql="SELECT * FROM users WHERE email='$email'";
            $result=mysqli_query($conn, $sql);
            $user=mysqli_fetch_array($result, MYSQLI_ASSOC);
            if($user)
            {
                if(password_verify($password, $user["password"]))
                {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                }
                else
                {
                    echo "<div class='The password doesnt match'></div>";
                }
            }
            else
            {
                echo "<div class='alert alert-danger'>Your email doesnt exist</div>";
            }
        }
        
        ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div> 
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="password:">
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="login" name="login">
            </div>            
        </form>
        <div>Havn't Email Yet <a href="register.php">register here</a></div>
    </div>
</body>
</html>