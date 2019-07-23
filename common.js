
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

/*function productValidation(){
    
    var optionValid = 0;
    var name = $('#name').val();
    var nameValid = 0;
   
    var sku = $('#sku').val();
    var skuValid = 0;
    
    var description = $('#desc').val();
    var descValid = 0;
    
    var stock = $('#stock').val();
    var stockValid = 0;
    
    var price = $('#price').val();
    var priceValid = 0;
    
    var imageValid = 0;
    
    if($.trim(name).length > 0){
        $('#nameValid').html('');
        $('#nameValid').removeClass('errormsg');
        nameValid = 0;   
    }
    else{
        $('#nameValid').html('Name is Required');
        $('#nameValid').addClass('errormsg');
        nameValid = 1; 
    }
    
    if($.trim(sku).length > 0){
        $('#skuValid').html('');
        $('#skuValid').removeClass('errormsg');
        skuValid = 0;   
    }
    else{
        $('#skuValid').html('SKU is Required');
        $('#skuValid').addClass('errormsg');
        skuValid = 1; 
    }
    
    if($.trim(description).length > 0){
        $('#descValid').html('');
        $('#descValid').removeClass('errormsg');
        descValid = 0;   
    }
    else{
        $('#descValid').html('Description is Required');
        $('#descValid').addClass('errormsg');
        descValid = 1; 
    }
    
    if($.trim(stock).length > 0){
        $('#stockValid').html('');
        $('#stockValid').removeClass('errormsg');
        stockValid = 0;   
    }
    else{
        $('#stockValid').html('Stock is Required');
        $('#stockValid').addClass('errormsg');
        stockValid = 1; 
    }
    
    if($.trim(price).length > 0){
        $('#priceValid').html('');
        $('#priceValid').removeClass('errormsg');
        priceValid = 0;   
    }
    else{
        $('#priceValid').html('Price is Required');
        $('#priceValid').addClass('errormsg');
        priceValid = 1; 
    }
        
    $(':input').each(function() {
            
        if($(this.value).length > 0){
            optionValid = 0;
        }else{
           optionValid = 1;
        }
    });
     $('select[class=optype]').each(function() {
        alert();
        if($(this.value).length > 0){
            optionValid = 0;
            $('#descValid').html('');
            $('#descValid').removeClass('errormsg');
        }else{
           optionValid = 1;
           $('#descValid').html('');
           $('#descValid').removeClass('errormsg');
        }
    });
    
   if(addImageModel > 0){
        alert();
        if($('#uploadImages').data('index') > 0){
            imageValid = 0;
            $('#imageValid').html('');
            $('#imageValid').removeClass('errormsg');
        }else{
            imageValid = 1;
            $('#imageValid').html('Please select at least one image');
            $('#imageValid').addClass('errormsg');
        }
    }
    if(nameValid == 0 && skuValid == 0 && descValid == 0 && stockValid == 0 && priceValid == 0 && optionValid){
        productSubmit();
    }  
}*/
