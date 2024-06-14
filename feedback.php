<?php
// include('config/connect.php');
$connection = mysqli_connect('localhost','root','','userdatabase');
$successMessage="";
$fullname="";
$message="";

if($_SERVER['REQUEST_METHOD']=="POST"){
    $fullname=$_POST['fullname'];
    $message=$_POST['message'];

    $preparedQuery = $connection->prepare("INSERT INTO testimonies (fullname,message) VALUES (?,?)");
    $preparedQuery->bind_param("ss", $fullname,$message);
    $preparedQuery->execute();

    if($preparedQuery->error){
        $errorMessage="Failed!".$preparedQuery->error;
        exit;
    }else{
        echo "<script>alert('Feedback successfully saved!Redirecting to Homepage');</script>";
        header('Refresh:0; URL=index.html');
    }
    $preparedQuery->close();
}


?>