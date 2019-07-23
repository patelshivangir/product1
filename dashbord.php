<?php include('inc/config.php'); 
$searchKey=$_REQUEST['q'];
$pageNumber = (int)$_REQUEST['p'];
$perPageCount = (int)$_REQUEST['c'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == ''){
     header('location:index.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Product detail</title>
        <?php include('inc/head.php'); ?>
    </head>
    <body>
        
        <div class="container">
            <?php include('inc/header.php'); ?>
            <br><br><br><center><h1>Welcome to Product Admin</h1></center>
        </div>
    </body>
</html>
