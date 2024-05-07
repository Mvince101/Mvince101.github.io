<?php
$conn = new mysqli("localhost:3307","root","","cart_system");
if($conn->connect_error){
    die("Your connection is not working".$conn-connect_error);
}
?>