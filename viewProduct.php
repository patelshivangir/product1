<?php include('inc/config.php'); 
$searchKey=$_REQUEST['q'];
$pageNumber = (int)$_REQUEST['p'];
$perPageCount = (int)$_REQUEST['c'];
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == ''){
     header('location:index.php');  
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Product Management</title>
        <?php include('inc/head.php'); ?>
        <script type="text/javascript" language="javascript" src="js/dashboard.js"></script>
    </head>
    <body>
        
   <div class="container">
        <?php include('inc/header.php'); ?>
       <input type="hidden" id="pageNumber" value="<?php if($pageNumber > 0){ echo $pageNumber; } ?>">
       
       <p class="text-center" style="font-size:30px;">Manage Product Detail</p>
       <div class="row" style="margin:20px 20px 20px 20px; float:right;">
             
           Search:- <input type="text" id="search" name="search" style="margin:0px 20px 0px 10px;" value="<?php if(isset($searchKey)){ echo $searchKey; } ?>">
       </div>
        
            <?php if($_REQUEST['m'] > 0){ ?>
            <br><br><br><br>
            <div class="alert alert-success alert-dismissible fade show" >
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong>&nbsp;&nbsp;&nbsp;  <?php if($_REQUEST['m'] == 1){ echo "Product Are Saved"; }else if($_REQUEST['m'] == 3){echo "Records is deleted."; }else{ echo "Product Detail Updated"; } ?>
              </div>
            <?php } ?>
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead  class="thead-dark">
                    <tr style="align:center; font-size:16px;">
                      <th width="130px"><input type="button" id="deleteAll" value="Delete Multiple Records" style="font-size:14px;"><br><input type="checkbox" id="selectAll" name="selectAll"></th>
                      
                      <th width="130px">Product</th>
                      <th width="130px">SKU</th>
                      <th width="130px">Stock</th>
                      <th width="130px">Quantity</th>
                      <th width="130px">Price</th>
                      <th width="280px">Description</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="productDetail">
                    
                    </tbody>
              </table>
            </div>
            <br><br>
       
       
    <div class="row productFooter">
        <div class="col">
            <select id="record_limit" style="width:100px;">
                    <option value=5 selected>5</option> 
                    <option value=10 <?php if($perPageCount == 10){ ?> selected <?php } ?>>10</option> 
                    <option value=15<?php if($perPageCount == 15){ ?> selected <?php } ?>>15</option> 
             </select>
        </div>
        <div class="col" >
            <ul class="pagination">
            <li class="page-item" style="cursor:pointer;"><a class="page-link" id="first" enable>First</a></li>
            <li class="page-item" style="cursor:pointer;"><a class="page-link" id="prev" enable>Previous</a></li>
            
            <li class="page-item" style="cursor:pointer;"><a class="page-link" id="next" enable>Next</a></li>
            <li class="page-item" style="cursor:pointer;"><a class="page-link" id="last" enable>Last</a></li>
          </ul>
        </div>
        <div class="col" id="pageDetail"> 
            <div align="right" style="font-size:16px;"></div>
            
        </div>
    </div> 
</div>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    			
                    <h3 class="modal-title">Are you sure you want to delete the records?</h3>	
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div> 
        
    <div class="modal fade" id="modalProductDetail">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-center">
            <h4 class="modal-title w-100 font-weight-bold">Product Details</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><h3>&times;</h3></span>
            </button>
          </div>
          <div class="modal-body mx-2">
                <div class="md-form mb-5">
                  <label data-error="wrong" data-success="right" id="name" style="font-size:20px;"><b>Name :-</b></label><br>
                  <label data-error="wrong" data-success="right" id="desc" style="font-size:17px;"><b>Description :-</b> </label><br>
                  <label data-error="wrong" data-success="right" id="price" style="font-size:17px;"><b>Price :- </b></label>
                  <br><label data-error="wrong" data-success="right" id="stock" style="font-size:17px;"> <b>Stock :- </b></label>
                  <br><label data-error="wrong" data-success="right" id="sku" style="font-size:17px; "><b>SKU :- </b></label>
                </div>

            </div>
        </div>
      </div>
    </div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:0px;">
       <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <div class="modal-body">
         <h5 class="modal-title" id="exampleModalCenterTitle"> Please select atleast one record.</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 
      </div>
    </div>
  </div>
</div>
    </body>
</html>


