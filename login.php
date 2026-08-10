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
</head>
<body>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        
        <h2>Login</h2>

        <!-- Display error messages if local validation fails -->
        <?php if (!empty($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        username:<br>
        <input type="text" name="username" required><br>
        password:<br>
        <input type="password" name="password" required><br>
        <input type="submit" name="submit" value="Login">
    </form>
    
</body>
</html>


