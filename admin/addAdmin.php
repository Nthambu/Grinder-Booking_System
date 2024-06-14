<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; admin_login.php');
    die();
}
//session_start();
//use $_server_request method when you are using sessions if no sessions,use isset isset($_POST['submit'])
if (isset($_POST['submit'])) {
    $con = mysqli_connect('localhost', 'root', '', 'userdatabase');
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function validateData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validateData($_POST['username']);
    $email = validateData($_POST['email']);
    $password = validateData($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM admin_login WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Failed! Admin Already Exists!');</script>";
        header('Refresh: 0; URL=addAdmin.html');
    } else {
        $sql = "INSERT INTO admin_login (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Registration successful. Redirecting you to admin page');</script>";
            header('Refresh: 0; URL=superAdmin.php');
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
            header('Refresh: 0; URL=addAdmin.html');
        }
    }
    mysqli_close($con);
} else {
    echo "<script>alert('Server Down! Try Again Later');</script>";
    header('Refresh: 0; URL=addAdmin.html');
}
?>
