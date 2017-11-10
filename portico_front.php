<?php 
//session_start();
//$query_params['shop']=$_GET['shop'];
//$shop_name =$_SESSION['shopname'];
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Video Portico</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,600italic,700,400italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>

  <script type="text/javascript">
  ShopifyApp.init({
     apiKey: '',
    shopOrigin: 'https://<?php echo $shop_name;?>'
  });

  ShopifyApp.ready(function(){
    ShopifyApp.Bar.initialize({
      title: "Dashboard"
    });

    ShopifyApp.Bar.loadingOff(); 
  });
</script>

</head>
<body>

<div class="video_home_buttons">
<a href="upload_single_video.php?shop_name=<?php echo $shop_name;?>" class="btn">Upload Single Video</a>
<a href="upload_multiple_video.php?shop_name=<?php echo $shop_name;?>" class="btn">Upload multiple Videos</a></div>
</div>
</body>












