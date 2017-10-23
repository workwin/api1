<?php 
session_start();
$query_params['shop'] = $_GET['shop'];
 $shop_name=$_SESSION['shopname'];
 echo   $shop_name;

$conn=mysqli_connect("localhost","ndiatech_1","Sakalsiddhi1111@","ndia_video")or die("sorry! No server not found");

 ?>
 <div class="full-width">
<?php

$query_params['shop'] = $_GET['shop'];
$select_store_data=mysqli_query($conn,"SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");

$shop_details=mysqli_fetch_array($select_store_data);

$shop_name=$shop_details['shop_address'];
$shop_token=$shop_details['shop_token'];

$shop_tbl_id=$shop_details['shop_id'];

$status=$shop_details['charge_status'];
$confirmation_url = $shop_details['confirm_url'];

$_SESSION['shopid'] = $shop_token;
$_SESSION['shopname'] = $shop_address;

 //$shopifyClient = new ShopifyClient($_GET['shop_address'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
  
$sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
$shop_details = $sc->call('GET', '/admin/shop.json');

$shop_email= $shop_details['email'];
$shop_domain= $shop_details['domain'];
$shop_created_at= $shop_details['created_at'];
$update_app_data_table= mysqli_query($conn,"UPDATE  `app_data_tbl` SET  `shop_created_date` =  '$shop_created_at', `shop_email` = '$shop_email', `shop_domain` = '$shop_domain' WHERE `shop_address` =  '$shop_name'"); 

?>

<?php 

$query = mysqli_query($conn, "SELECT * FROM `video` where `shop_address` ='shop_address' ");
$records = mysqli_num_row ($query);
if($records > 0){
include 'viewall.php';
}else {
include 'video_home.php';
}




?>

</div>