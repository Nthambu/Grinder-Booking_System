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
$stmt = $conn->prepare("SELECT email, reset_token_expiry FROM superadmin WHERE reset_token = ?");
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
        echo '<div class="alert alert-danger">Password must be at least 8 characters long and match the confirmation.</div>';
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $stmt = $conn->prepare("UPDATE superadmin SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("ss", $hashed_password, $token);
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Password updated successfully. Redirecting to login...</div>';
            header('Refresh: 2; URL=admin_login.php');
        } else {
            echo '<div class="alert alert-danger">Failed to update password. Please try again.</div>';
        }
        $stmt->close();
        $conn->close();
    }
} else {
    // Display the password reset form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Password Reset</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h2>Password Reset</h2>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                <div class="form-group">
                                    <label for="password">New Password:</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password:</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}
?>
