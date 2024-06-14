<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header('Refresh:0; admin_login.php');
    die();
}
$con = mysqli_connect('localhost','root','','userdatabase');
$id = $_GET['id'];
$query = "DELETE FROM testimonies WHERE id='$id'";
$result= mysqli_query($con,$query);
if($result){
    echo 
    "
    <script>alert('Record Successfully Deleted!');
    ";
    header('Refresh:0; URL=superAdmin.php');
}else{
    echo 
    "
    <script>alert('Oops! Error Occurred.Please Try Again!');
    ";
    header('Refresh:0; URL=superAdmin.php');
}