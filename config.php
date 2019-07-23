
<?php
session_start();
error_reporting(0);
$con = mysqli_connect('localhost','root','','product_admin');

if(mysqli_connect_error($con)){
    
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    
}

?>