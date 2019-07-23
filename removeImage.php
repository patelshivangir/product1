<?php 

include('../inc/config.php');
$image = $_REQUEST['image'];

$msg['error'] = 0;
$msg['msg'] = '';

$selectImage = "SELECT * FROM `tbl_images` WHERE `image_path`='$image'"; 

    if($get_image = mysqli_query($con,$selectImage)){

        if(mysqli_num_rows($get_image) > 0){
            
           if(mysqli_query($con,"DELETE FROM `tbl_images` WHERE `image_path`='$image'")){

                if(!unlink("../".$image)){ 
                    
                    $msg['error'] = 1;
                    $msg['msg'] =  "something went wrong while removeing image.";
                   
                }else{
                    $msg['error'] = 0;
                }
            }else{
                $msg['error'] = 1;
                $msg['msg'] =  "something went wrong while removeing image.";
            }
        }
    }else{
        $msg['error'] = 1;
        $msg['msg'] =  "Image is not exist.";
    }

echo json_encode($msg);
?>