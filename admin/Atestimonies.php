<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; admin_login.php');
    die();
}
$con = mysqli_connect('localhost','root','','userdatabase');
$query = "SELECT * FROM testimonies ";
$result = mysqli_query($con,$query);
// $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonies</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['fullname'];?></td>
                <td><?php echo $row['message'];?></td>
                <td><a onclick="return confirm('Are you sure,you want to delete?')" href="delete_Testimonies.php?id=<?php echo $row['id']?>">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
</table>
</body>
</html>