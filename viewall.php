<?php 

session_start(); 
include "dbcon.php";
$query_params['shop'] = $_GET['shop'];
$shop_name=$_SESSION['shopname']; ?>

<div class="viewvideo-wrap">
<?php
$select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
$shop_details=mysql_fetch_array($select_store_data);
 $shop_name=$shop_details['shop_address'];
$shop_token=$shop_details['shop_token'];
$shop_tbl_id=$shop_details['shop_id'];
$_SESSION['shopid'] = $shop_token;

if($_GET['del_id'])
{
  $did = $_GET['del_id']; 
  $shop = $_GET['shop_name']; 
  $stmt=mysql_query("DELETE FROM `videos` WHERE `id` = '$did' and `shop_address`  = '$shop'");

}
?>
<!-- header-->

<?php include "header.php"; ?>

<div class="wrapper">
<div class="container">


<div class="left_inner_header">
<ul>

       <li><a href="insertvideo.php?shop_name=<?php echo $shop_name;?>"><span> + </span> Add Single Video</a></li>
       <li><a href="add.php?shop_name=<?php echo $shop_name;?>"><span> + </span> Add Multiple Videos</a></li>
       <li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">View all</a></li>
       <li><a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="save_reorder">Reorder Videos</a></li>
    <div id="reorder-helper" class="light_box" style="display:none;">1. Drag Videos to reorder.<br>2. Click 'Save Reordering' when finished.</div>
      </ul>
</div>
<div class="right_inner_header">
<ul>
    <li><a href="embed_code.php?shop_name=<?php echo $shop_name;?>">Embed code</a></li>
        </ul>
</div>



</div>
</div>
<!-- header end-->


<div class="wrapper">
<div class="container">
<!--<div class="right_view_header_container"><?php include "add_setting.php";?></div> -->
 <div class="show_all">

 

<div class="videolist">
 <ul class="reorder_ul reorder-photos-list">
 <?php 

$query= "SELECT * FROM `videos` WHERE `shop_address` = '$shop_name' ORDER BY order_display ASC ";
$result = mysql_query($query);
 while($row= mysql_fetch_array($result, MYSQL_ASSOC)){
  $video_url=$row['url'];
 ?>


<li id="image_li_<?php echo $row['id']; ?>" class="ui-sortable-handle">
 <a href="javascript:void(0);" style="float:none;" class="image_link">

 <img src='http://img.youtube.com/vi/<?php echo $values;?>/0.jpg'/><div class='circle'><div class='circle_inner'> </div></div>
 
 
   
  <div class="update-section">  
 <div class="caption">
  <p class="video-title"><?php echo $row['name']; ?></p>
  <p class="video-description"> <?php echo $row['description']; ?></p>
  </div>
 <div class="edit-section">
<span class="edit-icon"><a href="edit.php?id=<?php echo $row['id'] ?>&shop_name= <?php echo $shop_name;?>">

<img src="images/edit.png"/>
</a> </span>
 </div>
 <div class="delete-section">
<span class="delete-icon"><a href="viewall.php?del_id=<?php echo $row['id'] ?>&shop_name=<?php echo $shop_name; ?>">

   <img src="images/delete1.png"/> </a></span>
 </div>
 
 </div>
  
  </a>
  </li>
  




 

 <?php } ?> 

 </ul>
</div>
</div>
</div>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.reorder_link').on('click',function(){
    $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
    $('.reorder_link').html('save reordering');
    $('.reorder_link').attr("id","save_reorder");
    $('#reorder-helper').slideDown('slow');
    $('.image_link').attr("href","javascript:void(0);");
    $('.image_link').css("cursor","move");
    $("#save_reorder").click(function( e ){
      if( !$("#save_reorder i").length ){
        $(this).html('').prepend('<img src="images/refresh-animated.gif"/>');
        $("ul.reorder-photos-list").sortable('destroy');
        $("#reorder-helper").html( "Reordering Photos - This could take a moment. Please don't navigate away from this page." ).removeClass('light_box').addClass('notice notice_error');
  
        var h = [];
        $("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id').substr(9));  });
       // alert("update");
        $.ajax({
          type: "POST",
          url: "orderUpdate.php",
          data: {ids: " " + h + ""},
          success: function(data){
//alert(data);
            window.location.reload();
          }
        }); 
        return false;
      } 
      e.preventDefault();   
    });
  });
});
</script>
