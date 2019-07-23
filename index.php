<?php include('config.php'); 

if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] != ''){
     header('location:dashbord.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        
        <script type="text/javascript" language="javascript" src="js/login.js"></script>
        
    </head>
    <body>
    
           <main class="login-form">
        
            
                      
                      
                         <div class="form-group">
                            <label for="email">Email <span class="error">*</span> :</label>
                          <input type="email" id="email" class="form-control" placeholder="Email" name="email"/>
                         </div>
                         <span id="unameValid"></span>
                       
                      <div class="form-group">
                        
                           <label for="password">Password <span class="error">*</span> :</label>

                          <input type="password" id="password" class="form-control" placeholder="Password" name="password"/>
                        </div>
                        <span id="passwordValid"></span>
                       <div class="form-group" style="text-align:right; margin-top:10px;">            
                        <a href="forgotPwd.php" name="forgotPwd" id="forgotPwd">Forgot Password? </a>
                       </div>
                          <div style="text-align:center; margin-top:20px;">
                           <input type="button" value="Login" id="login" name="login" style="margin-top:20px;" class="btn btn-info">
                          </div>
                   
       
       
           </main>
        
     </body>
</html>

