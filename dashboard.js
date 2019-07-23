
var perPageCount = 0;
var pageNumber = 1;
var searchKey = '';
var selectAll = 0;
var pagesCount = 0;
$(document).ready(function(){
    
    setTimeout(function(){ $('.alert').hide(); }, 10000);
    
    if($('#pageNumber').val() > 0){ pageNumber = $('#pageNumber').val(); }
    if($('#perPageCount').val() > 0){ perPageCount = $('#perPageCount').val(); }
    
    searchKey = $('#search').val();
    perPageCount = $('#record_limit').val();
    
    
    $('#record_limit').change(function(){
        $('input[type="checkbox"][name="selectAll"]').removeAttr('checked');
        perPageCount = this.value;
        pageNumber = 1;
        getProduct(perPageCount, pageNumber, searchKey); 
    });
    
     $("#search").keyup(function() {
         
        $('input[type="checkbox"][name="selectAll"]').removeAttr('checked'); 
        var character =$(this).val().toLowerCase();
        if(character.length > 2){ 
            var searchKey = character;
        
            pageNumber = 1; 
            getProduct(perPageCount, pageNumber, searchKey); 
        }else if(character.length == 0){
            searchKey == '';
            getProduct(perPageCount, pageNumber, searchKey); 
        }
        
    });
 
    $('body').on('click','.page-link',function(){
       $('input[type="checkbox"][name="selectAll"]').removeAttr('checked');
       if(this.id == 'prev'){ 
           pageNumber = pageNumber - 1; 
       }else if(this.id == 'next'){ 
           pageNumber = ++pageNumber; 
       }else if(this.id == 'first'){
           pageNumber = 1;
       }else if(this.id == 'last'){
           pageNumber = pagesCount; 
           
       }else{
          pageNumber = this.id; }
        
       searchKey=$("#search").val(); 
       getProduct(perPageCount, pageNumber, searchKey);
             
    });
    
    getProduct(perPageCount, pageNumber, searchKey);  
    
    $('input[type="checkbox"][name="selectAll"]').click(function(){

       if($(this). prop("checked") == true){ selectAll = 1; }else{ selectAll = 0; }
        
       if(selectAll == 1){ $('input[type="checkbox"][name="recordID[]"]').prop('checked','checked'); }else{ $('input[type="checkbox"][name="recordID[]"]').removeAttr('checked'); } 
        
    });
    $('#deleteAll').click(function(){
        var val = [];
        $('.deleteID:checked').each(function(i){
          val[i] = $(this).val();
        });
        deleteConfirmation('product',val,searchKey,pageNumber,perPageCount);
        
    });
       
});

function getProduct(perPageCount, pageNumber, searchKey){

   $.ajax({
        url: "xhr/getProduct_action.php",
        data:{perPageCount:perPageCount, pageNumber:pageNumber, searchKey:searchKey},
        success: function(result){
            $('.table').show();
            $('.productFooter').show();
            $('.pages').remove();
            $('#productDetail').html(result);
            $('#pageDetail').children('div').empty();            
            pagesCount = $('#pagesCount').val();
            var rowCount = $('#totalRecords').val();
            
            $('#first').parents('.page-item').show();
            $('#last').parents('.page-item').show();
            $('#next').parents('.page-item').show();
            $('#prev').parents('.page-item').show();
            $('#prev').parents('.page-item').removeClass('disabled');
            $('#next').parents('.page-item').removeClass('disabled');
            $('.table-responsive').children('h2').remove();
            if(rowCount == 0){
                
                $('.table-responsive').append('<h2 align="center">No result found</h2>'); 
                $('.productFooter').hide(); 
                $('.table').hide();
            
            }
            $('#pageDetail').children('div').append('Page '+pageNumber+' of '+pagesCount+'<br> Total Records : '+rowCount);
           
            
            for(var i = 1; i <= pagesCount; i++){
                $('#next').parents('.page-item').before("<li class='page-item pages' style='cursor:pointer;'><a class='page-link' id='"+i+"'>"+i+"</a></li>");   
                
                if(i == pageNumber){ 
                    
                    $('#'+i).parents('.pages').addClass('active');  
                }
                
                if(pageNumber == pagesCount){
                    $('#first').parents('.page-item').show();
                    $('#last').parents('.page-item').hide();
                    $('#next').parents('.page-item').hide();
                    $('#next').parents('.page-item').addClass('disabled');
                }
                if(pageNumber < pagesCount){ pageNumber == 1}
                if(pageNumber == 1){
                    $('#last').parents('.page-item').show();
                    $('#first').parents('.page-item').hide();
                    $('#prev').parents('.page-item').hide();
                    $('#prev').parents('.page-item').addClass('disabled');
                }
                if(pagesCount == 1){
                    $('#first').parents('.page-item').hide();
                    $('#last').parents('.page-item').hide();
                    $('#next').parents('.page-item').hide();
                    $('#prev').parents('.page-item').hide();                  
                    
                } 
                
                
            }
            
        },
    }); 
    
}

function deleteConfirmation(type,id,q,p,c){
    
    if(id.length == 0){
   
        $('#exampleModalCenter').modal();
        
    }else{
 
   $('#myModal').modal();
   $('#confirmDelete').click(function(){
       
       confirmDelete(type,id,q,p,c);
       $('#myModal').modal().slideUp();
   });}
}

function confirmDelete(type,id,q,p,c){
    
    $.ajax({
        url: "xhr/delete_action.php", 
        data :{id:id, type:type, q:q, p:p, c:c},
        dataType :'json',
        catch : false,
        success: function(result){
            
            if(result.error == 0){
               
                var urlData = '';
                if(result.q.length > 0){  
                    urlData ="m="+3+"&q="+result.q+"&p="+result.p+"&c="+result.c; 
                }else{ urlData = "m="+3+"&p="+result.p+"&c="+result.c; }
                    
                window.location = "viewProduct.php?"+urlData;
                getProduct(); 
                
            }else{
                alert(result.msg);   
            }
        },
    });
    
}

function viewDetail(id){
    $.ajax({
        url: "xhr/viewProduct_action.php", 
        data :{id:id},
        dataType :'json',
        catch : false,
        success: function(result){
         
            $('.mx-2').children('#images').remove();
            $('.mx-2').children('#options').remove();
            $(".optionsValue").empty();
            $(".optionTitle").empty();
            $('#name').empty();
            $('#desc').empty();
            $('#price').empty();
            $('#stock').empty();
            $('#stock').empty();
            $('#sku').empty();
            
            $('#modalProductDetail').modal();
            $('#name').append("Name :- "+result.basicDetail[0].name);
            $('#desc').append("Description :- "+result.basicDetail[0].desc);

            $('#price').append("Price :- "+result.basicDetail[0].price);
            $('#stock').append("Stock :- "+result.basicDetail[0].stock);
            if(result.basicDetail[0].stock > 0){ $('#stock').append(" Instock"); }else{ $('#stock').append(" Out of Stock");}
            $('#sku').append("SKU :- "+result.basicDetail[0].sku);
            
            if(result.images.length > 0){
                $('.mx-2').append("<div class='md-form mb-5' id='images'><h3> Images</h3></div> ");
                $.each(result.images, function(i){
                    $('.mx-2').children('#images').append("<span class='pip'><img class='imageThumb' src='"+this+"'><br></span>");
                });
            }
            
if(result.options.length > 0){
    
    $('.mx-2').append("<div class='md-form mb-5' id='options'><h3> Options</h3></div>");
    
    $.each(result.options, function(i){
       $('.mx-2').children('#options').append('<div style="margin-top:40px" class="optionTitle"><h6>'+this.title+'</h6><div id="optionValue_'+this.id+'" class="optionsValue"></div></div>');
        
      if(this.type == 1){
                
        $('.mx-2').find('#optionValue_'+this.id).append("<input type='text' name='singleValuePrice' id='field_"+this.id+"'>");
        //$('.mx-2').find('#field_'+this.id).after("&nbsp;&nbsp;&nbsp;+ &#x20B9;"+result.values[this.id][0].price);
        if(result.values[this.id][0].price > 0){$('.mx-2').find('#field_'+this.id).after("&nbsp;&nbsp;&nbsp;+ &#x20B9;"+result.values[this.id][0].price); } 
          
      }else if(this.type == 2){
                                
        $('.mx-2').find('#optionValue_'+this.id).append("<select id='value_"+this.id+"'><option value=0>Select "+this.title+"</option></select> "); 
        $.each(result.values[this.id], function(p){
            
       $('.mx-2').find('#value_'+this.option_id).append("<option value='"+this.title+"' id='op_"+this.id+"'>"+this.title+"</option>");           
            
        if(this.price > 0){  $('.mx-2').find('#op_'+this.id).append("&nbsp;&nbsp;&nbsp;+ &#x20B9;"+this.price); }
            
       });
          
     }else if(this.type == 3){ 
                
         $.each(result.values[this.id], function(q){
                   
            $('.mx-2').find('#optionValue_'+this.option_id).append("<div class='radio'><input type='radio' name='radio' id='radio_"+this.id+"'>&nbsp;&nbsp;"+this.title+"</div>");
                   
            if(this.price > 0){$('.mx-2').find('#radio_'+this.id).parent('.radio').append("&nbsp;&nbsp;&nbsp;+ &#x20B9;"+this.price); }
         });
         
     }else if(this.type == 4){
                
         $.each(result.values[this.id], function(q){
                   
            $('.mx-2').find('#optionValue_'+this.option_id).append("<div class='checkbox'><input type='checkbox' name='"+this.id+"' id='checkbox_"+this.id+"'>&nbsp;&nbsp; "+this.title+"</div");
             
            if(this.price > 0){  $('.mx-2').find('#checkbox_'+this.id).parent('.checkbox').append("&nbsp;&nbsp;&nbsp;+ &#x20B9;"+this.price); }
         });
                
      }
    
});
}
 },
    }); 

}