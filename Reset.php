<?php
// Set the default timezone
date_default_timezone_set('Africa/Nairobi');

// Include database connection
$conn = new mysqli('localhost', 'root', '', 'userdatabase');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the token from the URL
$token = $_GET['token'];

// Check if the token is provided
if (!isset($token) || empty($token)) {
    die('Token not provided.');
}

// Verify the token against the database
$stmt = $conn->prepare("SELECT email, reset_token_expiry FROM admin_login WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->bind_result($email, $reset_token_expiry);
$stmt->fetch();
$stmt->close();

if (!$email || new DateTime() > new DateTime($reset_token_expiry)) {
    die('Invalid or expired token.');
}

// If token is valid and form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve new password from the form
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password length and match
    if (strlen($new_password) < 8 || $new_password !== $confirm_password) {
        die('Password must be at least 8 characters long and match the confirmation.');
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE admin_login SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
    $stmt->bind_param("ss", $hashed_password, $token);
    if ($stmt->execute()) {
        echo 'Password updated successfully.';
        header('Refresh: 2; URL=login.php');
    } else {
        echo 'Failed to update password.';
    }
    $stmt->close();
    $conn->close();
} else {
    // Display the password reset form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Reset</title>
    </head>
    <body>
        <h2>Password Reset</h2>
        <form action="" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit">Reset Password</button>
        </form>
    </body>
    </html>
    <?php
}
?>
