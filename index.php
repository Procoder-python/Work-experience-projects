<?php
    include("database.php");

    session_start();   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>"method="post">
        <div class="brand-name">FAKEBOOK</div>
        <h2>Create your account</h2>
        <p class="form-intro">Register to get started.</p>
        <label for="username">Username</label>
        <input id="username" type="text" name="username">
        <label for="password">Password</label>
        <input id="password" type="password" name="password">
        <input type="submit" name="submit" value="Register">
        <div class="form-switch">or <a href="login.php">Log in</a></div>
    </form>    
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        if(empty($username)){
            echo"Please enter a username";

            
        }
        elseif(empty($password)){
            echo"please enter a password";
        }
        else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (user, password)
                    VALUES ('$username', '$hash')";
            mysqli_query($conn, $sql);
            echo"You are now registered!";       
        }
    }
    mysqli_close($conn);
?>

