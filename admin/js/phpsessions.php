<?php
session_start();

//SET/create session variables
$_SESSION["fullname"] = "frank";
$_SESSION["age"] =34;
//delete single session variable
//unset($_SESSION["age"]);
//to delete all sessions use  session_unset();
session_unset();
session_destroy();


?>
<!DOCTYPE html>
<html><body>
    <?php
   echo $_SESSION["fullname"];
   echo $_SESSION["age"];
   ?>
</body></html>