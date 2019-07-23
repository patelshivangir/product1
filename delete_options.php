<?php
include('../inc/config.php');

$id = $_REQUEST['id'];
$type = $_REQUEST['type'];
echo $id;

if($type == 'value'){
    $table_name = '`tbl_values`';
}else{
    $table_name = '`tbl_options`';
}
echo $sql = "DELETE FROM $table_name WHERE `id` = $id";

    if(mysqli_query($con, $sql)){
        
    }
?>