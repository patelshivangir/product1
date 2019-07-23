<?php
include('inc/config.php'); 

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == ''){  header('location:index.php');  }

if(isset($_REQUEST['submit'])){
    
    $id = $_REQUEST['userID'];
    $current_pass = $_REQUEST['current_pass'];
    $new_pass = $_REQUEST['new_pass'];
    $confirm_pass = $_REQUEST['confirm_pass'];
    
    $currentPwdError = '';
    $newPwdError = '';
    $confirmPwdError = '';
    $success = '';
    $error = '';
    
    if(empty($current_pass)){ $currentPwdError = "Please enter your current password."; }
    if(empty($new_pass)){ $newPwdError = "New password is required."; }
    if(empty($confirm_pass)){ 
        $confirmPwdError = "Confirm password is required."; 
    }else if($new_pass != $confirm_pass){ 
        $confirmPwdError = "Confirm password does not match to new password."; }
    
    if(empty($currentPwdError) && empty($newPwdError) && empty($confirmPwdError)){
        
        $selectData = "SELECT * FROM `tbl_login` WHERE `id`=$id ";
        
        $executeData = mysqli_query($con, $selectData);
        
        if(mysqli_num_rows($executeData) > 0){
            
            $fetchData = mysqli_fetch_object($executeData);
            $current_pwd = md5($current_pass);
            $new_pwd = md5($new_pass);
            
            if($fetchData -> password == $current_pwd){
                
                if(mysqli_query($con, "UPDATE `tbl_login` SET `password`='".$new_pwd."' WHERE `id`='$id'")){
                 
                      $success = "Your password updated successfully";  
                    
                }
                
            }else{ $currentPwdError = "Please Enter Valid Current Password";}
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Product Management</title>
        <?php include('inc/head.php'); ?>
        <script type="text/javascript">
    
           function formValidation(){

               var current_pass = $('#current_pass').val();
               var current_passValid = 0;

               var new_pass = $('#new_pass').val();
               var new_passValid = 0;

               var confirm_pass = $('#confirm_pass').val();
               var confirm_passValid = 0;

               if($.trim(current_pass).length == 0){
                   current_passValid = 1;
                   $('#current_passValid').html("Current Password is required.");
               }else{
                   current_passValid = 0;
                   $('#current_passValid').html("");
               }
               if($.trim(confirm_pass).length == 0){
                   confirm_passValid = 1;
                   $('#confirm_passValid').html("Confirm Password is required.");
               }else{
                   confirm_passValid = 0;
                   $('#confirm_passValid').html("");
               }

               if($.trim(new_pass).length == 0){
                   new_passValid = 1;
                   $('#new_passValid').html("New Password is required.");
               }else{
                   var pattern = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{5,}$/;
                   if(!pattern.test(new_pass)){

                        new_passValid = 1;
                       $('#new_passValid').html("Password contain at least 1 uppercase, 1 lowercase, 1 digit and 1 special character");
                   }else{
                      new_passValid = 0;
                      $('#new_passValid').html("");

                   if($.trim(confirm_pass).length == 0){

                       confirm_passValid = 1;
                       $('#confirm_passValid').html("Confirm Password is required.");
                   }else{

                       if(new_pass != confirm_pass){
                           confirm_passValid = 1;
                            $('#confirm_passValid').html("Password and confirm password does not match.");
                       }else{
                           confirm_passValid = 0;
                           $('#confirm_passValid').html("");
                       }
                   }

                  }
               }
               if(current_passValid == 0 && new_passValid == 0 && confirm_passValid == 0){
                    return true;
               }else{  return false; }

           }

        </script>
    </head>
<body>
    <div class="container">
        <?php include('inc/header.php'); ?> 
           <main class="login-form">
          <div class="row justify-content-center">
            <div class="col-md-4">
                <span class="error"><?php echo $error; ?></span>
                <span style="color:green; font-size:20px;"><?php echo $success; ?></span><br><br><br>
                <div class="card">
                    
                    <div class="card-header" style="font-size:25px;">Change Password</div>
                       <div class="card-body">
                          
                          <form method="post" id="changePassword" action="" onsubmit="return formValidation();">
                                <input type="hidden" name="userID" value="<?php echo $_SESSION['user_id']; ?>" />
    
                                <div class="form-group">
                                <label for="current_pass">Current Password <span class="error">*</span> :</label>
                               <input class="form-control" type="password" name="current_pass" id="current_pass" value="<?php echo $current_pass; ?>">
                                </div>
                                <span class="error" id="current_passValid"><?php echo $currentPwdError; ?> </span>
                                
                                <div class="form-group">
                                <label for="new_pass">New Password <span class="error">*</span> :</label>
                               <input class="form-control" type="password" name="new_pass" id="new_pass" value="<?php echo $new_pass; ?>">
                                </div>
                                <span class="error" id="new_passValid"><?php echo $newPwdError; ?> </span>
    
                                <div class="form-group">
                               <label for="confirm_pass">Confirm Password <span class="error">*</span> :</label>
                               <input class="form-control" type="password" name="confirm_pass" id="confirm_pass" value="<?php echo $confirm_pass; ?>">
                                </div>
                                <span class="error" id="confirm_passValid"><?php echo $confirmPwdError; ?> </span>
                                
                                <div style="text-align:center; margin-top:20px;">
                                <button type="submit" name="submit" class="btn btn-info" id="submit" value="Change Password">Change Password</button>
                                </div>
                           </form>
                    </div>
                </div>
            </div>
               </div>
        </main>
    </div>
   
</body>
</html>

