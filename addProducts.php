<?php include('inc/config.php'); 

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == ''){  header('location:index.php');  }
//print_r($_REQUEST);
$edit_id =(int)$_REQUEST['id'];
$searchKey=$_REQUEST['q'];
$pageNumber =$_REQUEST['p'];
$perPageCount =$_REQUEST['c'];
//header('location:dashbord.php?m='.$msg.'&q='.$searchKey.'&p='.$pageNumber.'&c='.$perPageCount);   
$error = 0;
$option_ID[] = '';
$optionTitle =[];
$optionType = [];
$optionValueID = [];
$multiValueTitle = [];
$multiValuePrice = [];
$image_name = [];
$image_path = [];
$title = '';
if($edit_id > 0){ $pID = $edit_id; $pageTitle = "Update";}else{ $pageTitle = "Add";}
$sql = "SELECT * FROM `product` WHERE `id`=$edit_id";

$Execute_sql = mysqli_query($con,$sql);

if(mysqli_num_rows($Execute_sql) > 0){ 
    
    $fetchData = mysqli_fetch_object($Execute_sql); 
    $name = $fetchData->name;
    $sku = $fetchData->sku;
    $desc = $fetchData->description;
    $stock = $fetchData->stock;
    $price = $fetchData->price;
}

$sqlImage = "SELECT * FROM `tbl_images` WHERE `product_id`=$edit_id";

$Execute_sqlImage = mysqli_query($con,$sqlImage);

if(mysqli_num_rows($Execute_sqlImage) > 0){
    
    while($row = mysqli_fetch_object($Execute_sqlImage)){
        
        array_push($image_path,$row -> image_path);
    }
}

$sqlOption = "SELECT * FROM `tbl_options` WHERE `product_id`=$edit_id";

$Execute_sqlOption = mysqli_query($con,$sqlOption);
$option_count = mysqli_num_rows($Execute_sqlOption);

if($option_count > 0){
    $i = 1;
    while($row = mysqli_fetch_object($Execute_sqlOption)){
        
        $option_ID = $row->id;
        $optionTitle[$i][$option_ID] = $row->title;
        $optionType[$i][$option_ID] = $row->type;
       
        
        $sqlOptionValues = "SELECT * FROM `tbl_values` WHERE `product_id`=$edit_id AND `option_id`=$option_ID";

        $Execute_sqlOptionValues = mysqli_query($con,$sqlOptionValues);

        $ValueCount[$i] = mysqli_num_rows($Execute_sqlOptionValues);
        
        if($ValueCount[$i] > 0){
            if($row->type == 1){ 
               
                $rows = mysqli_fetch_object($Execute_sqlOptionValues);
                
                $singlePrice[$i][$rows->id] = $rows->price;
            }else{
                
                $j = 1;
                while($rows = mysqli_fetch_object($Execute_sqlOptionValues)){
                    $optionValueID = $rows->id;

                    $multiValueTitle[$i][$j][$optionValueID] = $rows->title;
                    $multiValuePrice[$i][$j][$optionValueID] = $rows->price;
                    $j++;

                }
            }

        }
         $i++;
        
    }
} 

if(isset($_REQUEST['addProduct'])){
   
    $nameError = ''; 
    $skuError ='';
    $descError ='';
    $stockError ='';
    $imageError ='';
    $priceError = '';
    $titleError = array();
    $typeError = array();
    $valTitleError = array();
    $valueCountError = array();
 
    $error = 0;
    $msg = 0;
    $error_msg = '';
    
    $created_dt = date('Y-m-d_H:i:s');
    $name = trim($_REQUEST['name']);
    $sku = trim($_REQUEST['sku']);
    $desc = trim($_REQUEST['desc']);
    $stock = trim($_REQUEST['stock']);
    $price = trim($_REQUEST['price']);
    
    $image_name = $_FILES['images']['name'];
    $imageExist = $_REQUEST['imageConrol'];
    $image_path = $_FILES['images']['path'];
    
    $option_count = $_REQUEST['optionCount'];
    $ValueCount = $_REQUEST['valueCounter'];
    //var_dump(!isset($stock));
    if(empty($name)){ $nameError = "Name is required<br>"; } 
    if(empty($sku)){ $skuError = "SKU is required<br>"; } 
    if(empty($desc)){ $descError = "Description is required<br>"; } 
    if($stock == ''){ $stockError = "Stock is required<br>"; } 
    if($price == ''){ $priceError = "Price is required<br>"; } 
   
    $allowedExts = array("jpeg","jpg","png","gif","PNG","JPG","JPEG");
    
    if($imageExist > 0){
       if(!empty($image_name[0])){
          for($i=0; $i<count($_FILES['images']['name']); $i++){

                $ext = explode('.',$_FILES['images']['name'][$i]);
                $extension=end($ext);

                if(in_array($extension,$allowedExts)){

                    if ($_FILES["images"]["error"][$i] ==0){

                    }else{ $imageError = "Image contain an error"; }

                }else{ $imageError = "This file is does not an image."; }

            }
       }else{ $imageError = "image is required<br>"; }
   }
    
    if($option_count > 0){
    
        $optionTitle = $_REQUEST['optitle'];
        $optionType = $_REQUEST['optype'];
        $singlePrice = $_REQUEST['singleValuePrice']; 
        //$singleValuePrice = $_REQUEST['singleValuePrice'];
        $multiValueTitle = $_REQUEST['multiValueTitle'];
        $multiValuePrice = $_REQUEST['multiValuePrice'];
        
        foreach ($optionTitle as $opKey => $titleValue) {
                
            foreach ($titleValue as $optionID => $title) {
                $title = trim($title);
                $type = $optionType[$opKey][$optionID];
                if(empty($title)){$titleError[$opKey] = "This fiels is required"; }
                if(empty($type)){$typeError[$opKey] = "This fiels is required"; }
                
                if($type >1){
                    if($ValueCount[$opKey] <= 0){ 

                        $valueCountError[$opKey] = "Please insert at least one value."; 

                    }else{ 

                        $mul_val_title = $_REQUEST['multiValueTitle'][$opKey];

                        foreach($mul_val_title as $q => $val_title){

                            foreach($val_title as $mulValID => $title){
                                $title = trim($title);
                                if(empty($title)){$valTitleError[$opKey][$q] = "This fiels is required"; }

                            }
                        }
                    }
                }
            }
        }
    }  
    
    if(empty($nameError) && empty($skuError) && empty($descError) && empty($stockError) && empty($priceError) && empty($titleError) && empty($typeError) && empty($valTitleError) &&empty($valueCountError) && empty($imageError)){    
      
         if($edit_id > 0){
            //echo "select * from `product` where `sku`='".$sku."' AND `id`!= $edit_id";exit;
            $SKUdata = mysqli_query($con,"select * from `product` where `sku`='".$sku."' AND `id`!= $edit_id"); 
            if(mysqli_num_rows($SKUdata) > 0){ 
                 
                $error_msg = "SKU already exist! Try another one.";
                $error = 1; 
            }else{
                $data = "`name`='$name', `stock`='$stock', `price`='$price', `sku`='$sku', `description`='$desc', `modified_dt`='$created_dt'";
                
                $update_qry = "UPDATE `product` SET $data WHERE `id`=$edit_id";

                if(mysqli_query($con,$update_qry)){
                    $error = 0;
                    $msg = 2;
                }else{ $error = 1; $error_msg = "Record Could not updated.";}
            }
        }else{
            
            $fields = "`name`, `stock`, `price`, `sku`, `description`,`created_dt`";
            $values = "'$name','$stock','$price','$sku','$desc','$created_dt'";

            $data = mysqli_query($con,"select * from `product` where `sku`='".$sku."'");

            if(mysqli_num_rows($data) > 0){ 
                $error_msg = "SKU already exist! Try another one.";
                $error = 1; }else{
                 
                $qry = "INSERT INTO `product`($fields)VALUES($values)";

                if(mysqli_query($con,$qry)){
                    $pID = mysqli_insert_id($con);
                    $error = 0;
                    $msg = 1;
                }else{ $error = 1; $error_msg = "Something went wrong! please try again.";}
            }
        } 
         if($error == 0){
         if($imageExist > 0){
                        
            for($i=0; $i<count($_FILES['images']['name']); $i++){
                
                $file_name = explode('.', $_FILES['images']['name'][$i]);
               
                $new_file = $file_name[0].'-'.$created_dt.".".$file_name[1];
                $path = "images/".$pID."/".$new_file;
                
                $fields = "`product_id`,`image_path`, `created_dt`";
                $value = "'$pID','$path','$created_dt'";
                
                $sql="INSERT INTO `tbl_images`($fields)VALUES($value)";

                if(mysqli_query($con,$sql)){
                   
                    $imgID = mysqli_insert_id($con);
                    
                    if(!is_dir("images/".$pID."/")){  mkdir("images/".$pID."/");  }
                    
                    if(move_uploaded_file($_FILES["images"]["tmp_name"][$i],$path)){
                        $error = 0;
                        if($edit_id > 0){ $msg =  2;}else{ $msg = 1;}
                     }else{
                        $error = 1;
                        $error_msg =  "something went wrong";
                    }
                }
            }
        }
         }
         if($error == 0){
         if($option_count > 0){
            
            foreach ($optionTitle as $opKey => $titleValue) {
                
                foreach ($titleValue as $optionID => $title) {
                    
                    $title = trim($title);
                    $type = $optionType[$opKey][$optionID];
                    
                    if (!empty($title) && !empty($type)){
                        
                        if($optionID > 0){
                            //echo "test";exit;
                            //echo "SELECT * FROM `tbl_options` WHERE `id`=$optionID";exit;
                           $checkID=mysqli_query($con,"SELECT * FROM `tbl_options` WHERE `id`=$optionID"); 
                            
                            if(mysqli_num_rows($checkID) > 0){
                                    
                                $row = mysqli_fetch_object($checkID);
                               
                                if($row->type != $type){

                                   mysqli_query($con,"DELETE FROM `tbl_values` WHERE `option_id` = $optionID");    
                                }
                                $sql = "UPDATE `tbl_options` SET `title`='$title',`type`=$type WHERE `id` = $optionID";
                                if(mysqli_query($con,$sql)){ $opID =$optionID;  $error= 0; $msg = 2;}else{$error = 1; $error_msg = "Something went wrong! please try again.";}
                            }
                        }else{
                            
                            $field = "`product_id`, `title`, `type`, `created_dt`";
                            $value = "'".$pID."','".$title."','".$type."','".$created_dt."'";
                            
                            $sql = "INSERT INTO `tbl_options`($field) VALUES($value)";
                            
                            if(mysqli_query($con,$sql)){ 
                                $opID = mysqli_insert_id($con); 
                                $error = 0;  
                                if($edit_id > 0){ $msg =  2;}else{ $msg = 1;} $error = 1; $error_msg = "Something went wrong! please try again.";}
                        }
                    }
                  
                    if($type == 1){
                        
                        $value_price = $_REQUEST['singleValuePrice'][$opKey];
                        
                        foreach($value_price as $valueID => $singleValue){
                            if($opID == 0){ $opID =$optionID; } 
                            $singleValue = trim($singleValue);
                            if($valueID > 0){
                                if($singleValue == ''){ $singleValue = 0; }
                                $sqlValue = "UPDATE `tbl_values` SET `price`=$singleValue WHERE `id`=$valueID";
                                if(mysqli_query($con,$sqlValue)){ $error = 0; $msg = 2; }else{ $error = 1; $error_msg = "Something went wrong! please try again.";} 
                                
                            }else{
                                $field_value = " `product_id`, `option_id`, `price`,`created_dt`";
                                $value_value = "'".$pID."','".$opID."','".$singleValue."','".$created_dt."'";

                                $sqlValue = "INSERT INTO `tbl_values`($field_value) VALUES($value_value)";
                                
                                if(mysqli_query($con,$sqlValue)){ $error = 0; if($edit_id > 0){ $msg =  2;}else{ $msg = 1;}$error = 1; $error_msg = "Something went wrong! please try again.";}
                            }
                        }
                        
                    }else{
                        
                        $mul_val_title = $_REQUEST['multiValueTitle'][$opKey];
                            
                        foreach($mul_val_title as $q => $val_title){
                                
                            foreach($val_title as $mulValID => $title){
                                
                               $title = trim($title);
                                $value = trim($_REQUEST['multiValuePrice'][$opKey][$q][$mulValID]);
                                if($edit_id > 0){ if($opID == 0){ $opID =$optionID; }  }
                                  
                                if($mulValID > 0){
                                    
                                    if($value == ''){$value = 0;}
             $sql_mul_value="UPDATE `tbl_values` SET `title`='$title',`price`=$value WHERE `id`=$mulValID";                                 
                                    if(mysqli_query($con,$sql_mul_value)){  $error = 0;  $msg =  2;}
                                    
                                }else{
                                    
                             $mul_field = "`product_id`, `option_id`, `title`, `price`,`created_dt`";
                             $mul_value ="'".$pID."','".$opID."','".$title."','".$value."','".$created_dt."'";

                             $sql_mul_value = "INSERT INTO `tbl_values`($mul_field) VALUES($mul_value)"; 

                                        if(mysqli_query($con,$sql_mul_value)){ 
                                            $error = 0; 
                                            if($edit_id > 0){ $msg =  2;}else{ $msg = 1;}
                                        }else{
                                            $error = 1; $error_msg = "Something went wrong! please try again.";
                                        }
                                }
                            
                            }
                        }
                    }
                }
            }
        }
         }
         $query_string = '';
         if($edit_id > 0){
            if(isset($searchKey)){ $query_string = '&q='.$searchKey.'&p='.$pageNumber.'&c='.$perPageCount; }else{
                $query_string = '&p='.$pageNumber.'&c='.$perPageCount;
            }
        }
        if($error == 0){  header('location:viewProduct.php?m='.$msg.$query_string); }
     }
      
 } 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Product Management</title>
        <?php include('inc/head.php'); ?>
        <script type="text/javascript" language="javascript" src="js/add_product.js"></script>
    </head>
    <body>
<div class="container">
    <?php include('inc/header.php'); ?>   
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
             <?php if($error > 0){ ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><h3>Error!</h3></strong>          <?php echo $error_msg; ?>
              </div>
                <?php } ?>
                <div class="card">
                    <div class="card-header" style="font-size:25px;"><?php echo $pageTitle; ?> Product</div>
                    <div class="card-body">
                    
                     <form method="POST" id="productForm" name="productForm" action="" enctype="multipart/form-data" onsubmit="return productValidation();">
                        <input type="hidden" name="id" id="id" value="<?php echo $edit_id;?>">
                         <div class="form-group">
                            <label for="name">Product <span class="error">*</span> :</label>
                           <input type="text" class="form-control" id="name" name="name" value="<?php if(isset($name)){ echo $name; }?>">
                         </div>
                         <span class="error" id="nameValid"><?php echo $nameError; ?></span>

                         <div class="form-group">
                            <label for="sku">SKU <span class="error">*</span> :</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="<?php if(isset($sku)){ echo $sku; }?>">
                         </div>
                         <span class="error" id="skuValid"><?php echo $skuError; ?></span> 

                         <div class="form-group">
                            <label for="desc">Description <span class="error">*</span> :</label>
                            <input type="text" class="form-control" id="desc" name="desc" value="<?php if(isset($desc)){ echo $desc; }?>">
                         </div>
                         <span class="error" id="descValid"><?php echo $descError; ?></span>

                         <div class="form-group">
                            <label for="stock">Stock <span class="error">*</span> :</label>
                            <input type="text" class="form-control" id="stock" name="stock" value="<?php if(isset($stock)){ echo $stock; }?>">
                         </div>
                         <span class="error" id="stockValid"><?php echo $stockError; ?></span>

                         <div class="form-group">
                            <label for="price">Price <span class="error">*</span> :</label>
                            <input type="text" class="form-control" id="price" name="price" value="<?php if(isset($price)){ echo $price; }?>">
                         </div>
                         <span class="error" id="priceValid"><?php echo $priceError; ?></span><br>
                        
                         <button class="card-header" id="addImage" type="button">Add Images</button>
                         <?php $imageControl = $_REQUEST['imageConrol'];
                                    if(isset($imageCount)){ $imageControl = $imageCount; }
                                 if($imageControl > 0){ 
                                     ?>
                               <script type="text/javascript">
                                  $(document).ready(function(){
                                      $('#uploadImages').removeAttr('style');
                                  }); 
                                 </script>
                                     <?php }
                                    ?>
                         <input type="hidden" name="imageConrol" id="imageConrol" value="<?php if(isset($imageControl)){ echo $imageControl; }?>" >
                         <div id="uploadImages" style="display:none;"><br>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">Image Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" id="images" class="form-control" name="images[]" multiple value="<?php echo $image_path; ?>"> 
                                    <label class="custom-file-label" for="images">Choose Image</label>
                                </div>
                                <span id="imageValid" class="error" ><?php echo $imageError; ?></span>
                            </div><br>
                          </div><br><br> 
                            <div id="dvPreview"> 
                                <?php foreach($image_path as $key=>$path){?>
                                  <span class="pip"><img class='imageThumb' src="<?php echo $path; ?>"><button id='<?php echo $key; ?>' class="remove" type="button" name='imageRemove[<?php echo $key; ?>]' value="<?php echo $key; ?>" onClick="removeImage('<?php echo $path; ?>')">Remove</button></span>   
                                
                                    <?php  } ?>
                        </div><br><br>    
                         
                        <button class="card-header" id="addOption" type="button" name="addOption">Add Options</button><br><Br>
                        <input type="hidden" name="optionCount" id="optionCount" value="<?php echo $option_count; ?>">
                        <div id="getOption">
                      <?php if($option_count > 0){ 
                                //print_r($optionTitle);
                                $optionCount = $option_count; 
                                foreach ($optionTitle as $optionID => $titleValue) {
                                    foreach ($titleValue as $k => $title) {
                                        
                                        $type = $optionType[$optionID][$k]; 
                                        
                                        $singleValuePrice =$singlePrice[$optionID][$k];
                                         ?>
                                    <div id='mainOption_<?php echo $optionID; ?>' class="singleOption" style="background-color:#DFEAEA; margin-top:20px;">
                                        <div class="row" id="Option_<?php echo $optionID; ?>" data-id="<?php echo $optionID; ?>">
                                            <div class='col-md-5'>
                                                <div class='form-group opTitleDiv'>
                                                    <label for='title'>Title <span class="error">*</span> :</label>
                                                    <input type='text' class='form-control' id='title' name='optitle[<?php echo $optionID; ?>][<?php echo $k; ?>]' value="<?php if(isset($title)){ echo $title; }?>">
                                                </div>
                                                <span class="error"><?php echo $titleError[$optionID]; ?></span>
                                            </div>
                                            <div class='col-md-5'>
                                                <div class='form-group opTypeDiv'>
                                                    <label for='optype'>Option Type <span class="error">*</span> :</label>
                                                    <select id='type_<?php echo $optionID; ?>' name='optype[<?php echo $optionID; ?>][<?php echo $k; ?>]' class="optype">
                                                        <option value=0 selected>Select option type</option>
                                                        <option value='1'<?php if($type == 1){?> selected <?php }?>> Field</option>
                                                        <option value='2' <?php if($type == 2){?> selected <?php }?>> Dropdown</option>
                                                        <option value='3' <?php if($type == 3){?> selected <?php }?>> Radio</option>
                                                        <option value='4' <?php if($type == 4){?> selected <?php }?>> checkbox</option>
                                                    </select>
                                                </div>
                                                <span class="error"><?php echo $typeError[$optionID]; ?></span>
                                            </div>
                                            <div class='col-md-1' style="margin-top:2px;">
                                                <div class='form-group'>
                                                    <label for=''>&nbsp;</label>  
                                                    <button type='button' id='<?php echo $optionID; ?>' class='opremove' data-id="<?php echo $k; ?>"><i class='fa fa-trash' aria-hidden='true' style="color:red;"></i></button>
                                                </div>
                                             </div>
                                           
                                            <div class="card-header optionDetail" id="option_detail_<?php echo $optionID; ?>" style="width:600px;">
                                                <?php if($type == 1){ 
                                                        
                                                        $singlevaluePrice = $singlePrice[$optionID];
                                            
                                                            foreach($singlevaluePrice as $k => $price){
                                                              
                                                ?>
                                               <div class='singleValue' style='font-size:15px;' id='single_option'>
                                                    <div class='row'>
                                                       <div class='col-md-8' style="margin-bottom:20px;">
                                                            <label for='stock'>Price :</label>
                                                            <input type='text' class='singleValuePrice form-control' id='singleValuePrice_<?php echo $optionID; ?>' name='singleValuePrice[<?php echo $optionID; ?>][<?php echo $k; ?>]' value="<?php echo $price; ?>">
                                                        </div>
                                                     </div>
                                                </div>
                                                <?php       } 
                                                        
                                                    }else if($type > 1){ 
                                            
                                                    $ValueCounter = $ValueCount[$optionID];
                                                  
                                              ?>
                                                <div style='font-size:15px;'>
                                                    <div class='row'>
                                                        <div class='col-md-6'>
                                                            <label for='title'>Title <span class="error">*</span> :</label>
                                                        </div>
                                                        <div class='col-md-6'>
                                                            <label for='price'>Price :</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="valueCounter[<?php echo $optionID; ?>]" id="valueCounter_<?php echo $optionID; ?>" value="<?php if($ValueCounter > 0){ echo $ValueCounter; }else{ echo '0'; } ?>">
                                                <div id="multipleValue_<?php echo $optionID; ?>">
                                               <?php   
                                           
                                            if($ValueCounter > 0){
                                                      
                                                foreach ($multiValueTitle[$optionID] as $counter => $valueTitle) {

                                                    foreach ($valueTitle as $n => $valTitle) { 
                                                        $valPrice = $multiValuePrice[$optionID][$counter][$n];

                                                        //if(empty($valTitle)){ $valTitleError = "This field is required"; }
                                                        ?>
                                                    <div class='row value_row' id="valueRow_<?php echo $optionID.'_'.$counter; ?>" data-id="<?php echo $optionID.'_'.$counter; ?>">
                                                        <div class='col-md-6'>
                                                            <div class='form-group' id="title_div_<?php echo $optionID.'_'.$counter; ?>">
                                                                <input type='text' class='form-control' id="multiValueTitle_<?php echo $optionID.'_'.$counter; ?>" name="multiValueTitle[<?php echo $optionID; ?>][<?php echo $counter; ?>][<?php echo $n; ?>]" value="<?php if(isset($valTitle)){ echo $valTitle; } ?>">
                                                            </div>
                                                            <span class="error"><?php echo $valTitleError[$optionID][$counter]; ?></span>
                                                       </div>
                                                        <div class='col-md-5'>
                                                            <div class='form-group'>
                                                                <input type='text' class='multiValuePrice form-control' id='multiValuePrice_<?php echo $optionID.'_'.$counter; ?>' name="multiValuePrice[<?php echo $optionID; ?>][<?php echo $counter; ?>][<?php echo $n; ?>]" value="<?php if(isset($valPrice)){ echo $valPrice; } ?>">
                                                            </div>

                                                        </div>
                                                        <div class='col-md-1'>
                                                            <div class='form-group'>
                                                                <button type='button' id='<?php echo $optionID.'_'.$counter; ?>' class='valremove error' data-id="<?php echo $n; ?>" data-option-id="<?php echo $optionID; ?>"><span><i class='fa fa-trash' aria-hidden='true'></i></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                <?php } } } ?>    
                                                </div>
                                                <div class='row'>
                                                    <button type='button' id='addValue_<?php echo $optionID; ?>' class='addValue' style='margin :20px; 0px; 20px; 0px;' data-option-id="<?php echo $optionID; ?>">Add Value</button>
                                                </div>
                                                <span class="error"><?php echo $valueCountError[$optionID]; ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        </div>           
                            
                             <?php   } } }
                        ?> 
                        </div>
                       <input type="submit" class="btn btn-info" id="addProduct" name="addProduct" style="margin-top:20px;" value="<?php echo $pageTitle; ?> Product">
               </form>
                  </div>
                         
                        
               </div>       
            </div>
        </div>
    </div>

</main>
</div>
</body>
</html>


