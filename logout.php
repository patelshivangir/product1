<?php
include('inc/config.php');
if(isset($_SESSION['user_id'])){
 session_destroy();
    header('location:index.php');
}

?>