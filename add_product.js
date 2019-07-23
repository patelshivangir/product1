
$(document).ready(function(){
    
    /*$('body').on('click','#collapse',function(){
        if($(this).hasClass('fa fa-chevron-up')){
            $(this).attr('class','fa fa-chevron-down');
        }else{
             $(this).attr('class','fa fa-chevron-up');
        }
        
    });*/
   
   var edit_id = $('#id').val();
    
   $('#addImage').click(function(){
      
      $('#imageConrol').val(1); 
      $('#uploadImages').removeAttr('style');
   });
    
   $('#addOption').click(function(){
      var count = $('#optionCount').val();
      $('#optionCount').val(++count);
       getOption(count);
  });
  
    $("#images").change(function () {
        $('#imageConrol').val(1);
        $('#uploadImages').attr('data-index',1);
        //$('.pip').remove();
        if (typeof (FileReader) != "undefined") {
            var dvPreview = $("#dvPreview");
            
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
           $($(this)[0].files).each(function () {
                var file = $(this);
                if (regex.test(file[0].name.toLowerCase())){
                   
                var reader = new FileReader();
                reader.onload = function (e) {
                    
                var img = $("#dvPreview").append("<span class=\"pip\" style='height:180px;'>" + "<img class='imageThumb' src='" + e.target.result + "' style='height:180px;'/>" + "" +"</span>"); 
                    
                //var img = $("<span class=\"pip\" style='margin-top:5px;'>" + "<img class='imageThumb' src='" + e.target.result + "'  data-title='" + e.target.result + "' title=\"" + file.name + "\" />" + "" +"</span>").appendTo("#dvPreview");
                 
                 $('#imageValid').html('');  
                } 
                reader.readAsDataURL(file[0]);
                } else {
                    imageValid = 1;
                    $('#imageValid').html("This file is not a valid image file.");
                    dvPreview.html("");
                    return false;
                }
                
            });
        }else {
            alert("This browser does not support HTML5 FileReader.");
        }
    });
    
    $('body').on("change",".optype",function(){
        
       var optionID = $(this).parents('.row').attr('data-id');
       getOptionsDetail(optionID, this.value);
        
       $('#error_'+$(this).parents('.row').attr('data-id')).remove();
    });
    
    $('body').on("click",'.addValue',function(){
       var optionID = $(this).attr('data-option-id');
        var counter = $('#valueCounter_'+optionID).val();
       getMutliValue(++counter, optionID);
    });
    
    $('body').on("click",'.opremove',function(){
       var optionID = $(this).attr('id');
       $(this).parents('#mainOption_'+optionID).remove();
        
       var count = $('#optionCount').val();
        $('#optionCount').val(--count);
        
        if(edit_id > 0){
            var id = $(this).attr('data-id');
            var type='option';
            
            $.ajax({
                 data:{id:id, type:type},
                 url:"xhr/delete_options.php",
                success:function(){
                    
                    var count = $('#optionCount').val();
                    $('#optionCount').val(count--);
                }
            });
         }
    });
    
    $('body').on("click",'.valremove',function(){
       var valueID = $(this).attr('id');
       $(this).parents('#valueRow_'+valueID).remove();
        
       var optionID = $(this).data('option-id');
       var valueCount = $('#valueCounter_'+optionID).val();
    
       $('#valueCounter_'+optionID).val(--valueCount); 
        
       if(edit_id > 0){
            var id = $(this).attr('data-id');
            var type='value';
            
            $.ajax({
                 data:{id:id, type:type},
                 url:"xhr/delete_options.php",
                success:function(){
                   
                }
            });
            
        }
        
    });
    
    $('body').on("keypress keyup","#stock",function (event) {
        
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            
            event.preventDefault();
          
        }
    });
    
    $('body').on("keypress keyup","#price",function (event) {
        
      if((event.which != 46 || $(this).val().indexOf('.') != -1)&&(event.which < 48 || event.which > 57)) {
            
            event.preventDefault();
      }
    });
    
    $('body').on("keypress keyup",".singleValuePrice",function (event) {
         
        if((event.which != 46 || $(this).val().indexOf('.') != -1)&&(event.which < 48||event.which > 57)) {
            event.preventDefault();
        }
    });
    
    $('body').on("keypress keyup",".multiValuePrice",function (event) {
        
      if((event.which != 46 || $(this).val().indexOf('.') != -1)&&(event.which < 48 || event.which > 57)) {
            
            event.preventDefault();
      }
    });
    
});

function getOption(count){

    $.ajax({
        data:{count:count},
        dataType:'html',
        url: "xhr/option.php", 
        success: function(result){
            $('#getOption').append(result);
        },
    }); 
}
function getOptionsDetail(optionID, value){
    
    $.ajax({
        data:{optionID:optionID, value:value},
        dataType:'html',
        url: "xhr/OptionsDetail.php", 
        success: function(result){
            $('#option_detail_'+optionID).remove();
           $('#Option_'+optionID).append(result);
         
        },
    });
}
function getMutliValue(counter, optionID){
 
    $.ajax({
        data:{counter:counter, optionID:optionID},
        dataType:'html',
        url: "xhr/multipleValue.php", 
        success: function(result){
           
           $('#multipleValue_'+optionID).append(result);
            $('#valueCounter_'+optionID).val(counter);
        },
            
    });
    
}

function productValidation(){
  
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
    
    var data_count = $("#optionCount").val();
    
    var optionValid = 0;
    
    var opTitleValid = 0;
    var opTypeValid = 0;
    
    var multiTitleValid = 0;
    var multiPriceValid = 0;
    
    var singlePriceValid = 0;
    
    var addImageModel = $('#imageConrol').val();
     var imageValid = 1;
    
    if($.trim(name).length > 0){
        $('#nameValid').html('');
        $('#nameValid').removeClass('errormsg');
        nameValid = 0;   
    }else{
        $('#nameValid').html('Name is Required');
        $('#nameValid').addClass('errormsg');
        nameValid = 1; 
    }
    
    if($.trim(sku).length > 0){
        $('#skuValid').html('');
        $('#skuValid').removeClass('errormsg');
        skuValid = 0;   
    }else{
        $('#skuValid').html('SKU is Required');
        $('#skuValid').addClass('errormsg');
        skuValid = 1; 
    }
    
    if($.trim(description).length > 0){
        $('#descValid').html('');
        $('#descValid').removeClass('errormsg');
        descValid = 0;   
    }else{
        $('#descValid').html('Description is Required');
        $('#descValid').addClass('errormsg');
        descValid = 1; 
    }
    
    if($.trim(stock).length > 0){
        $('#stockValid').html('');
        $('#stockValid').removeClass('errormsg');
        stockValid = 0;   
    }else{
        $('#stockValid').html('Stock is Required');
        $('#stockValid').addClass('errormsg');
        stockValid = 1; 
    }
    
    if($.trim(price).length > 0){
        $('#priceValid').html('');
        $('#priceValid').removeClass('errormsg');
        priceValid = 0;   
    }else{
        $('#priceValid').html('Price is Required');
        $('#priceValid').addClass('errormsg');
        priceValid = 1; 
    }
     
    if(addImageModel > 0){
        
            if($('#images').val() != ''){
                if($('#imageValid').html() == ''){
                    imageValid = 0;
                    $('#imageValid').html('');
                    $('#imageValid').removeClass('errormsg');
                }
            }else{
                imageValid = 1;
                $('#imageValid').html('Please select at least one image');
                $('#imageValid').addClass('errormsg');
            }
       
    }else{ imageValid = 0; }
    
    if(data_count > 0){
            
        $( ".singleOption" ).each(function() {
            
            var opID = $(this).children('.row').attr('data-id');
             $('#error_'+opID).remove();       
            if($("#title_"+opID).val() == ''){
              
               opTitleValid = 1;
               if($("#title_error_"+opID).length == 0){
                    
                   $(this).find('.opTitleDiv').after("<span class='error' id='title_error_"+opID+"'>This field is required</span>");                   
                }
                
            }else{
                opTitleValid = 0;
                $("#title_error_"+opID).remove();   
            }
             
            if($("#type_"+opID).val() == 0){
               
                opTypeValid = 1;
               if($("#type_error_"+opID).length == 0){
                  
                    $(this).find('.opTypeDiv').after("<span class='error' id='type_error_"+opID+"'>This field is required</span>");                   
                }
            }else{
                var option_value = $("#type_"+opID).val();
                var option_id = opID;
                
                opTypeValid = 0;
                $("#type_error_"+opID).remove();   
            }
                if(option_value > 1){
                     var value_count =  $('#valueCounter_'+opID).val();
                    
                   
                       
                    if(value_count > 0){
                        
                        optionValid = 0;
                        $('.value_row').each(function(){
                            
                           $(this).children('span').remove();
                            var value_index =  $(this).attr('data-id');


                        if($('#multiValueTitle_'+value_index).val() == ''){
                            
                            multiTitleValid = 1;

                             if($("#mul_value_title_error_"+value_index).length == 0){

                                $('#title_div_'+value_index).after("<span class='error' id='mul_value_title_error_"+value_index+"'>This field is required</span>");
                             }

                        }else{
                            multiTitleValid = 0;
                            $("#mul_value_title_error_"+value_index).remove();
                        }

                    });
                             
                    }else{
                        optionValid = 1;
                        $(this).append("<span class='error' id='error_"+opID+"'>Please select atleast one option value</span>");
                    }   
                
                }
          

        });
    }
    //console.log(nameValid+'-'+skuValid+'-'+descValid+'-'+stockValid+'-'+priceValid+'-'+optionValid+'-'+opTitleValid+'-'+opTypeValid+'-'+multiTitleValid+'-'+imageValid);
    if(nameValid == 0 &&
      skuValid == 0 &&
      descValid == 0 &&
      stockValid == 0 &&
      priceValid == 0 &&
       optionValid == 0 &&
      opTitleValid == 0 &&
      opTypeValid == 0 &&
      multiTitleValid == 0 &&
      imageValid == 0){
     return true;   
    }else{
        return false;
    }
}

function removeImage(image){
    $.ajax({
        data:{image:image},
        dataType:'json',
        url: "xhr/removeImage.php", 
        success: function(result){
            if(result.error == 0){
                window.location = '';
            }else{
                
             alert(result.msg);   
            }
        },
    }); 
}