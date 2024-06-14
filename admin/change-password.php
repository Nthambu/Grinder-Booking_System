<?php
session_start();
if (isset($_SESSION["id"]) && isset($_SESSION["username"])) {
    require('config/connection.php');
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        function validateData($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $o_password = validateData($_POST['o_password']);
        $n_password = validateData($_POST['n_password']);
        $c_password = validateData($_POST['c_password']);
        $id = $_SESSION["user_id"];

        if ($n_password !== $c_password) {
            echo "<script>alert('New passwords do not match.');</script>";
            header('Refresh: 0; URL=updateS_Password.php');
            exit();
        }

        if (strlen($n_password) < 8) {
            echo "<script>alert('Password must be at least 8 characters long.');</script>";
            header('Refresh: 0; URL=updateS_Password.php');
            exit();
        }

        $sql = "SELECT password FROM admin_login WHERE id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($o_password, $hashedPassword)) {
            $newHashedPassword = password_hash($n_password, PASSWORD_DEFAULT);
            $sql2 = "UPDATE admin_login SET password=? WHERE id=?";
            $stmt2 = $con->prepare($sql2);
            $stmt2->bind_param("si", $newHashedPassword, $id);
            
            if ($stmt2->execute()) {
                echo "<script>alert('Password changed successfully.');</script>";
                header('Refresh: 0; URL=login.php');
            } else {
                echo "<script>alert('Failed to change password. Please try again.');</script>";
                header('Refresh: 0; URL=updatePassword.php');
            }

            $stmt2->close();
        } else {
            echo "<script>alert('Old password is incorrect.');</script>";
            header('Refresh: 0; URL=updatePassword.php');
        }

        $con->close();
    } else {
        echo "<script>alert('Server Error!');</script>";
        header('Refresh: 0; URL=admin_panel.php');
    }
} else {
    header('Location: login.php');
    exit();
}
?>
