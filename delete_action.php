<?PHP
include('../inc/config.php');

$error ='';
$msg[] ='';

$type = $_REQUEST['type'];
$id = $_REQUEST['id'];
$searchKey = $_REQUEST['q'];
$pageNumber = $_REQUEST['p'];
$perPageCount = $_REQUEST['c'];


if(!empty($id) && $type != ''){
    
    if($type == 'product'){ $tbl_name = '`product`'; }
    
    if(is_array($id)){
        
        foreach($id as $key=>$value){ 

            $qry = "DELETE FROM $tbl_name WHERE `id` = $value";

            if(mysqli_query($con,$qry)){

                $msg['error'] = 0;
                $msg['msg'] = "Record deleted successfully";

            }else{
                $msg['error'] = 1;
                $msg['msg'] = "Something went wrong! please try again.";  
            }
        }
    }else{
        
        $qry = "DELETE FROM $tbl_name WHERE `id` = $id";

        if(mysqli_query($con,$qry)){

            $msg['error'] = 0;
            $msg['msg'] = "Record deleted successfully";

        }else{
            $msg['error'] = 1;
            $msg['msg'] = "Something went wrong! please try again.";
        }
    }
    if($msg['error'] == 0){
        if($searchKey != ''){

            $sql = "SELECT * FROM `product` WHERE (`name` LIKE '%".$searchKey."%') OR (`stock` LIKE '%".$searchKey."%') OR  (`price` LIKE '%".$searchKey."%') OR (`sku` LIKE '%".$searchKey."%') OR (`description` LIKE '%".$searchKey."%')"; 
            }else{
                $sql = "SELECT * FROM `product`";
            }

            if($row = mysqli_query($con, $sql)){
               $rowCount= mysqli_num_rows($row); 
            }
            $pagesCount = ceil($rowCount / $perPageCount);

            if($pagesCount < $pageNumber){ $pageNumber=1; }
        }
    
    $msg['q'] = $searchKey;
    $msg['p'] = $pageNumber;
    $msg['c'] = $perPageCount;
    }

echo json_encode($msg);

?>