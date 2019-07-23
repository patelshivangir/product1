$(document).ready(function(){
    $('#login').click(function(){
        loginValidation();
    }); 
});
function loginValidation(){
 
    var email =$('#username').val();
    var emailValid = 0;
    
    var password = $('#password').val();
    var passwordValid = 0;
    
    if($.trim(email).length > 0){
        
        var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
        
        if(pattern.test(email)){
            $('#unameValid').html('');
            $('#unameValid').removeClass('errormsg');
            emailValid = 0;
        }else{
            $('#unameValid').html('Invalid Email ID');
            $('#unameValid').addClass('error');
            emailValid = 1; 
        }
    }else{
        $('#unameValid').html('Email is Required');
        $('#unameValid').addClass('error');
        emailValid = 1; 
    }
    
    if($.trim(password).length > 0){
        $('#passwordValid').html('');
        $('#passwordValid').removeClass('error');
        passwordValid = 0;   
    }else{
        $('#passwordValid').html('Password is Required');
        $('#passwordValid').addClass('error');
        passwordValid = 1; 
    }
    
    if(emailValid == 0 && passwordValid == 0){
        loginSubmit();   
    } 
}
function loginSubmit(){
   var formData =$('#loginForm').serialize();
    
    $.ajax({
        type:"POST",
        data:formData,
        dataType:'json',
        cache: false,
        url: "xhr/login_action.php", 
        success: function(result){
            if(result.error == 0){
                
                window.location = 'dashbord.php';
            }else{
               $('#loginError').html(result.msg);
            }
        },
    }); 
}
