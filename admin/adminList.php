<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; admin_login.php');
    die();
}
$con = mysqli_connect('localhost','root','','userdatabase');
$query = "SELECT * FROM admin_login ";
$result = mysqli_query($con,$query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Admins</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>UserName</th>
                <th>Email</th>
                
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['username'];?></td>
                <td><?php echo $row['email'];?></td>
            
                <td><a onclick="return confirm('Are you sure,you want to delete?')" href="delete_Admin.php?id=<?php echo $row['id']?>">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
</table>
</body>
</html>