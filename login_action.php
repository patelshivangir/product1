<?PHP
include('../inc/config.php');

$email = $_REQUEST['username'];
$password = $_REQUEST['password'];

$error ='';
$msg[] ='';

if($email == ''){ $error .= "Email is required"; }

if($password == ''){ $error .= "Password is required"; }

if($error == ''){
    
    if($email != '' && $password != ''){
        $password = md5($password);
        $sql = "SELECT * FROM `tbl_login` WHERE `email`='".$email."' && `password`='".$password."'";            
        $data = mysqli_query($con,$sql);
        
        if(mysqli_num_rows($data) > 0){
            
           $row = mysqli_fetch_object($data);
           $_SESSION['user_id'] = $row->id;   
           
            if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
                // last request was more than 30 minutes ago
                session_unset();     // unset $_SESSION variable for the run-time 
                session_destroy();   // destroy session data in storage
            }
            $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

            $msg['msg'] = "Login success";
            $msg['error'] = 0;
        }else{
           $msg['msg'] = "Incorrect Email Or Password.";
           $msg['error'] = 1; 
        }
    }
}
echo json_encode($msg);
?>