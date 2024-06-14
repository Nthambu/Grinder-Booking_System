<?php

$servername="localhost";
$username="root";
$password="";
$dbname="userdatabase";
//establish a new connection

$connection= new mysqli($servername,$username,$password,$dbname);
//check if connection is established

if(!$connection){
  echo "failed to connect";
}
?>