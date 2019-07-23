<?php include('inc/config.php'); 

require('inc/PHPMailer-master/class.phpmailer.php');
//require('inc/PHPMailer-master/src/Exception.php');
require('inc/PHPMailer-master/PHPMailerAutoload.php');


if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
     header('location:dashbord.php');  
}

if(isset($_REQUEST['submit'])){
    
    $email = $_REQUEST['email'];
    
    $emailError = '';
    $error = '';
    
    if(empty($email)){  $emailError = "Email is required.";}else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailError = "Invalid email format";}else{
    
        $sql = "SELECT * FROM `tbl_login` WHERE `email` = '$email'";

        $executeSQL = mysqli_query($con, $sql);

        if(mysqli_num_rows($executeSQL)){
            
            $newPwd = randomPassword();
            $newPassword = md5($newPwd);
            
            if(mysqli_query($con, "UPDATE `tbl_login` SET `password`='$newPassword' WHERE `email`='$email'")){
               
              $mail = new PHPMailer();
                
              try {
                    //Server settings
                   // $mail->SMTPDebug = 2;                                       // Enable verbose debug output
                    $mail->isSMTP();                                            // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'testing.cws@gmail.com';                     // SMTP username
                    $mail->Password   = 'cwstesting)(*';                               // SMTP password
                    $mail->SMTPSecure = 'tls';                             // Enable TLS encryption, `ssl` also accepted
                    $mail->Port       = 587;                                    // TCP port to connect to

                    //Recipients
                    $mail->setFrom('testing.cws@gmail.com', 'CWS');
                    $mail->addAddress($email);     // Add a recipient
                    
                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Login Password';
                    $mail->Body    = '<center><h3>Forgot Password?</h3><br><p> Hello user, you have request for forgot password. Your password is changed. You can use the new password for login or password reset. <br><br> <h4>Your new password is </h4><p style="font-size:25px;, color:00bfff;"> '.$newPwd.'</center>';
                    $mail->AltBody = '<h4>Your new password is</h4><p style="font-size:25px;, color:00bfff;"> '.$newPwd;

                    if($mail->send()){
                        header('location:index.php?m=1');
                    }
                } catch (Exception $e) {
                    $error="Message could not be sent. Mailer Error". $mail->ErrorInfo;
                }      
            }
           
        }else{
            $error = "This email is not registered";
        }
    }
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Product Management</title>
        <?php include('inc/head.php'); ?>
        <script type="text/javascript">

            function formValidation(){ 
                
                var email =$('#email').val();
                var emailValid = 0;

                 if($.trim(email).length > 0){

                    var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;

                    if(pattern.test(email)){
                        $('#emailValid').html('');
                        $('#emailValid').removeClass('errormsg');
                        emailValid = 0;
                    }else{
                        $('#emailValid').html('Invalid Email ID');
                        $('#emailValid').addClass('error');
                        emailValid = 1; 
                    }
                }else{
                    $('#emailValid').html('Email is Required');
                    $('#emailValid').addClass('error');
                    emailValid = 1; 
                }



                return false;
                if(emailValid == 0){ return true; }else{ return false;}
            }
        </script>
    </head>
<body>
 <div class="container">
   <main class="login-form">
      <div class="row justify-content-center">
        <div class="col-md-4">
           <div class="card">   
              <h5 style="text-align:center;margin:20px 20px 20px 20px;"><i class="fa fa-lock fa-4x"></i></h5>  
              <div class="card-header" style="font-size:25px;text-align:center;">Forgot Password?
              <p style="font-size:15px;">New password would be send to your email, you can login using that password.</p>
               </div>
                <div class="card-body">
                    <span class="error"><?php echo $error; ?></span>
    
                     <form method="POST" onsubmit="return formValidation();">
                         <div class="form-group">
                            <label for="email">Email <span class="error">*</span> :</label>
                              <input id="email" name="email" placeholder="Email Address" class="form-control" type="text">
                           
                              <span class="error" id="emailValid"> <?php echo $emailError; ?> </span>
                          </div>
                          <div class="form-group">
                            <input class="btn btn-info btn-block" value="Send My Password" type="submit" name="submit">
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

    
    
    
    