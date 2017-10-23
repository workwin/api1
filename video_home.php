<?php 
session_start();
$query_params['shop'] = $_GET['shop'];
$shop_name=$_SESSION['shopname'];
echo   $shop_name;

$conn=mysqli_connect("localhost","ndiatech_1","Sakalsiddhi1111@","ndia_video")or die("sorry! No server not found");

?>

<!DOCTYPE html>
<html>
<head>
<title>Evm Gallery by Expert Village Media Technologies</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>

  <script type="text/javascript">
  ShopifyApp.init({
     apiKey: 'b4e1fa4bf25f6bfb071bfe11a1ce136c',
    shopOrigin: 'https://<?php echo $shop_name;?>'
  });

  ShopifyApp.ready(function(){
    ShopifyApp.Bar.initialize({
      title: "Dashboard"
    });

    ShopifyApp.Bar.loadingOff(); 
  });
</script>

<style >
  .video_home_wrapper h2 {
    float: left;
    width: 100%;
    text-align: center;
    margin-bottom: 30px;
    margin-top: 15px;
}
.video_home_wrapper {
    float: left;
    width: 100%;
    padding: 20px;
}
.video-img-wrapper {
    float: left;
    width: 100%;
        margin-top: 50px;
    margin-bottom: 50px;

}
.video-img-left {
    float: left;
    width: 30%;
    margin-top:14px;
}
.video-img-right {
    float: left;
    width: 57%;
}
.video-img {margin:0 auto; width:42%;   padding-left: 113px;}
.video_home_buttons a.btn {
    text-decoration: none;
    width: 20%;
    text-align: center;
    padding: 20px;
    background: #0066ff;
    color: #fff;
}
.video_home_buttons {
    float: left;
    width: 100%;
    text-align: center;
    margin-bottom: 30px;
}

.footer_container {
    float: left;
    width: 100%;
    margin: 30px 0;
}
.footer_container h2 {
    padding: 30px 0;
    text-align: center;
    text-transform: uppercase;
}
.footer_block {
    float: left;
    width: 23%;
    margin: 0 10px;
}

</style>



</head>
<body>
<div class="app-header">
  <div class="header">
  <div class="logo"><img src="images/Video-Icon.png"/></div>
  <div class="list-right">
    <div class="app-heading">
      <ul>
	 <li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">Dashboard</a></li>
    <li><a href="installation.php?shop_name=<?php echo $shop_name;?>">How to use</a></li>
   <li><a href="#">Support</a></li>
    <li><a href="embed_code.php?shop_name=<?php echo $shop_name;?>">Embed code</a></li>
   <li><a href="add_setting.php?shop_name=<?php echo $shop_name;?>">Setting</a></li>
	
	  </ul>
    </div>
      </div>
  </div>
</div>

<div class="container">
<div class="wrapper" id="" style="margin-bottom:40px; margin-top:40px;">
<div class="wrapper" id="nav">
<div class="container">
<div class="video_home_wrapper">
<h2>Create an amazing Image Gallery for your store.</h2>
<div class="video-img-wrapper">
<div class="video-img">
<div class="video-img-left">
  <img src="images/Video_AppIcon.jpg"/>
  </div>
  <div class="video-img-right"><img src="images/video-Icon.png"/></div>
 </div>

</div>

<div class="video_home_buttons">
<a href="insertvideo.php?shop_name=<?php echo $shop_name;?>" class="btn">Upload Single Image</a>
<a href="add.php?shop_name=<?php echo $shop_name;?>" class="btn">Upload multiple Image</a></div>
</div>
</div>
</div>
</div>
</div>



</body>