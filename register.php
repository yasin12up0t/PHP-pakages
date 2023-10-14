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
    <title>register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
           if(isset($_POST["submit"]))
            {
                $fullname = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $passwordRepeat = $_POST["passwordRepeat"];
                $passwordHash = password_hash($password,PASSWORD_DEFAULT);
                $errors = array();
                if(empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat))
                {
                    array_push($errors,"All feilds are required");
                }
                if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                {
                    array_push($errors,"Email isnt valid");
                }
                if(strlen($password)<8)
                {
                    array_push($errors,"Your password must exceed 8 letters");
                }
                if($password !== $passwordRepeat)
                {
                    array_push($errors,"Your password doesnt match");
                }

                require_once "Database.php" ;
                $sql="SELECT * FROM users WHERE email='$email'";
                $result =mysqli_query($conn, $sql);
                $rowCount=mysqli_num_rows($result);
                if($rowCount>0)
                {
                    array_push($errors,"This E-mail is already exist");
                }

                if(count($errors)>0)
                {
                    foreach($errors as $error)
                    {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }
                else{
                    require_once "Database.php" ;
                    $sql="INSERT INTO users (full_name,email,password) VALUES (?, ?, ?)";
                    $stmt=mysqli_stmt_init($conn);
                    $prepareStmt= mysqli_stmt_prepare($stmt, $sql);
                    if($prepareStmt)
                    {
                        mysqli_stmt_bind_param($stmt, "sss", $fullname, $email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You are Successfully registed</div>";
                    }
                    else
                    {
                        die("some thing went wrong");
                    }
                }     
                
            } 
        ?>
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full name:">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email:">
            </div> 
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="password:">
            </div> 
            <div class="form-group">
                <input type="text" class="form-control" name="passwordRepeat" placeholder="passwordRepeat:">
            </div> 
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>            
        </form>
        <div>Have Email already<a href="login.php">Login here</a></div>
    </div>
</body>
</html>