<?php
// Start the session at the very top before any HTML output
session_start();
include("database.php");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Please enter both a username and password.";
    } else {
        // Query the database for the user (using the 'user' column from index.php setup)
        $sql = "SELECT id, user, password FROM users WHERE user = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {
                // Verify the submitted password against the stored password hash
                if (password_verify($password, $user['password'])) {
                    // Password is correct! Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['user'];

                   
                    header("Location: welcome.php");
                    exit;
                } else {
                    // CHANGED: Redirects to incorrect password/username page
                    header("Location: invalid_username.php");
                    exit;
                }
            } else {
                // CHANGED: Redirects to incorrect password/username page
                header("Location: invalid_username.php");
                exit;
            }
            mysqli_stmt_close($stmt);
        }
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
        <div class="brand-name">FAKEBOOK</div>
        <h2>Welcome back</h2>
        <p class="form-intro">Sign in to continue.</p>

        <!-- Display error messages if local validation fails -->
        <?php if (!empty($error_message)): ?>
            <p class="form-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <label for="username">Username</label>
        <input id="username" type="text" name="username" required>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        <input type="submit" name="submit" value="Login">
        <div class="form-switch">or <a href="index.php">Register</a></div>
    </form>

    
</body>
</html>


