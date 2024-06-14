<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the default timezone
date_default_timezone_set('Africa/Nairobi');

// Load Composer's autoloader
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $conn = new mysqli('localhost', 'root', '', 'userdatabase');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check reset attempts
    $stmt = $conn->prepare("SELECT reset_attempts, last_reset_attempt FROM superadmin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($reset_attempts, $last_reset_attempt);
    $stmt->fetch();
    $stmt->close();

    $current_time = new DateTime();
    $last_reset_time = new DateTime($last_reset_attempt);
    $interval = $current_time->diff($last_reset_time);

    // Reset attempts if last attempt was more than 24 hours ago
    if ($interval->d >= 1) {
        $reset_attempts = 0;
    }

    if ($reset_attempts >= 4) {
        echo "<div class='alert alert-danger'>You have reached the maximum number of reset attempts for today. Please try again tomorrow.</div>";
    } else {
        $reset_attempts++;
        $stmt = $conn->prepare("UPDATE superadmin SET reset_token = ?, reset_token_expiry = ?, reset_attempts = ?, last_reset_attempt = NOW() WHERE email = ?");
        $stmt->bind_param("ssis", $token, $expiry, $reset_attempts, $email);
        if ($stmt->execute()) {
            // Construct the reset link
            $reset_link = "http://localhost/services/admin/S_Reset.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click on this link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'franklinentamburi@gmail.com';
                $mail->Password   = 'app password';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('your email', 'Mailer');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                echo "<div class='alert alert-success'>Password reset link has been sent to your email.</div>";
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Failed to update token.</div>";
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
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
                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
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
