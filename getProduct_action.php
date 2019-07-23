<?PHP
include('config.php');

$perPageCount=$_REQUEST['perPageCount'];
$pageNumber = $_REQUEST['pageNumber'];
$searchKey = $_REQUEST['searchKey'];
$condition = '';
$error ='';
$msg[] ='';

if (!isset($pageNumber)) { $pageNumber = 1; } else { $pageNumber = $pageNumber; }

if($searchKey != ''){
   
   $sql = "SELECT * FROM `tbl_category` WHERE (`category_name` LIKE '%".$searchKey."%') OR (`category_description` LIKE '%".$searchKey."%') OR (`category_status` LIKE '%".$searchKey."%') OR (`sku` LIKE '%".$searchKey."%') OR (`parent` LIKE '%".$searchKey."%')"; 
}else{
    $sql = "SELECT * FROM `tbl_category`";
}

if($row = mysqli_query($con, $sql)){
   $rowCount= mysqli_num_rows($row); 
}
$pagesCount = ceil($rowCount / $perPageCount);

if($pagesCount < $pageNumber){ $pageNumber=1; }

$lowerLimit = ($pageNumber - 1) * $perPageCount;

$sqlQry = "$sql ORDER BY `category_id` DESC LIMIT ".$lowerLimit.",".$perPageCount;         
$data = mysqli_query($con,$sqlQry);
  ?>
<input type="hidden" name="pagesCount" id="pagesCount" value="<?php echo $pagesCount; ?>">
    <input type="hidden" name="totalRecords" id="totalRecords" value="<?php echo $rowCount; ?>">

<?php if(mysqli_num_rows($data) > 0){ ?>
    
<?php while($row = mysqli_fetch_object($data))
   { 
?>      
        <tr> 
            <td><input class="deleteID" type="checkbox" name="recordID[]" id="delete_<?php echo $row->category_id; ?>" value="<?php echo $row->category_id; ?>"></td>
      
            <td> <?php echo $row->category_name; ?> </td>
            <td> <?php echo $row->category_description; ?> </td>
            <td> <?php echo $row->category_status; ?></td>
            <td> <?php echo $row->parent; ?> </td>
           
            <td>
                <a name="option" class="btn btn-outline-secondary" href="addProducts.php?id=<?php echo $row->id; ?><?php if(!empty($searchKey)){echo '&q='.$searchKey;} ?>&p=<?php echo $pageNumber; ?>&c=<?php echo $perPageCount; ?>"><i class="fa fa-edit" style="font-size:25px;color:green"></i></a>&nbsp;&nbsp;
                <a href="javascript:void(0)" class="btn btn-outline-secondary" data-toggle="modal" id="deleteConfirm" name="deleteConfirm" onclick="deleteConfirmation('tbl_category','<?php echo $row->category_id; ?>','<?php echo $searchKey; ?>','<?php echo $pageNumber; ?>','<?php echo $perPageCount; ?>')"><i class="fa fa-trash" style="font-size:25px;color:red"></i></a>&nbsp;&nbsp;
            <a name="viewProduct" class="btn btn-outline-secondary" data-toggle="modal" onclick="viewDetail(<?php echo $row->category_id; ?>)"><i class="fa fa-eye" style="font-size:25px;"></i></a>&nbsp; </td>
                
        </tr>
   <?php  }
} ?>

 