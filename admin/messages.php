<?php
session_start();
if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
    // require ('config/connection.php');
    $con = mysqli_connect('localhost','root','','userdatabase');
}else{
    header('Location: login.php');
}

$query = "SELECT * FROM contacts ";
$result = mysqli_query($con,$query);
// $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Message</th>
                
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['fname'];?></td>
                <td><?php echo $row['email'];?></td>
                <td><?php echo $row['phone'];?></td>
                <td><?php echo $row['message'];?></td>
                
                
            </tr>

            <?php endwhile; ?>
        </tbody>
</table>
</body>
</html>