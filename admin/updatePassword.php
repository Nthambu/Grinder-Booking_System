
<?php
session_start();
if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
    //require ('config/connection.php');
    $con = mysqli_connect('localhost','root','','userdatabase');
}else{
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Change Password</h2>
                    </div>
                    <div class="card-body">
                        <form action="change-password.php" onsubmit="return validate()" method="POST">
                            <div class="form-group">
                                <label for="oldpassword">Old Password</label>
                                <input type="password" class="form-control" id="oldpassword" name="o_password" placeholder="Enter old password" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="n_password" placeholder="Enter new password" required>
                            </div>
                            <div class="form-group">
                                <label for="password2">Confirm New Password</label>
                                <input type="password" class="form-control" id="password2" name="c_password" placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                            <a href="user.php" class="btn btn-secondary btn-block">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validate() {
            let password = document.getElementById("password").value;
            let password2 = document.getElementById("password2").value;
            if (password !== password2) {
                alert("Password Mismatch!");
                return false;
            }
            if (password.length < 8) {
                alert("Enter a Strong Password!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
