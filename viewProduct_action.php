<?php
include('config.php');
$msg ='';
$id=$_REQUEST['id'];
$res['basicDetail']=[];
$res['images']=[];
$res['options']=[];
$res['values']=[];
$result[] = [];

if($id > 0){
    
    $sql = "SELECT * FROM `tbl_category` WHERE `category_id` = $id";
    $execute_sql = mysqli_query($con,$sql);
    
    if(mysqli_num_rows($execute_sql) > 0){ 
        
        $value = mysqli_fetch_object($execute_sql);
        $data['category_id'] = $value->category_id;
        $data['category_name']=$value->category_name;
        $data['category_description'] = $value->category_description;
        $data['category_status'] = $value->category_status;
        $data['parent'] = $value->parent;
       
        
        array_push($res['basicDetail'],$data);
        $result[1]=$res['basicDetail'];
    }
        
    //$imageSql="SELECT * FROM `tbl_images` WHERE `product_id` = $id";
 //   $execute_imageSql = mysqli_query($con,$imageSql);
    
   // if(mysqli_num_rows($execute_imageSql) > 0){ 
        
       // while($val = mysqli_fetch_object($execute_imageSql)){
       //     $val = $val->image_path;
          //  array_push($res['images'], $val);
            //array_push($res['images'],$val);
            //$result[2] = $res['images'];
    //   }
 //   }
    
    
}

echo json_encode($res);