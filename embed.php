<?php
session_start(); 
$shop_name= $_SESSION['shopname']; 

function send_header() {
    $expires_offset = -1; // 1 year

    header('Content-Type: application/x-javascript; charset=UTF-8');
    header('Vary: Accept-Encoding'); // Handle proxies
    header('Expires: ' .gmdate( "D, d M Y H:i:s", time() + $expires_offset ) . ' GMT');
    header("Cache-Control: public, max-age=$expires_offset");
}
send_header(); 
?> 


<?
$query_params['shop'] = $_GET['shop'];
$shop_name = $query_params['shop'] = $_GET['shop'];
include "dbcon.php";
$select_store_data=mysql_query("SELECT * FROM `app_data_tbl` WHERE `shop_address` = '$shop_name'");
$shop_details=mysql_fetch_array($select_store_data);
$charge_status=$shop_details['charge_status'];


 $shop_name=$shop_details['shop_address'];
$path = "https://www.apps.expertvillagemedia.com/shopify/evm-gallery/upload/".$shop_name."/";
$settings = mysql_query("SELECT * FROM `gallery_settings` WHERE `shop_address` = '".$shop_name."'");

$records = mysql_num_rows($settings);
if($records > 0)
{  
while($row=mysql_fetch_array($settings))
{
 $view = $row['videogallerytheme'];

 $no_of_img=$row['noi'];
 $shop_name=$row['shop_address'];
 $show_captions=$row['show_captions'];
  $font_color="#".$row['font_color'];
 $plus_font_color="#".$row['plus_font_color'];
$plus_bg_color="#".$row['plus_bg_color'];
$font_size=$row['name_font_size']."px";
 $width=$row['width'];
if(empty($width))
{
$width = "300";
}
 $column_spacing=$row['column_spacing'];
 if(empty($column_spacing))
{
$column_spacing = "20";
}
$height=$row['height'];
 if(empty($height))
{
$height = "200";
}
}
}

if(empty($plus_font_color))
{
$plus_font_color = "#000";
}
if(empty($plus_bg_color))
{
$plus_bg_color = "#fff";
}

if(empty($no_of_img))
{
$no_of_img = "4";
}

$grid_width = 96/$no_of_img;
$grid_margin=4/$no_of_img;
$grid_margin=$grid_margin/2;  



 
?>


jQuery(document).ready(function(){
$(document).ready(function() 
{
var $div = $("#evm-video-gallery"); 
$('<style>.page-container{transform:none!important}</style>').appendTo('body');

<?php 
 $s_a_t = mysql_query("SELECT * FROM `videos` WHERE `shop_address` = '$shop_name' ORDER BY order_display ASC");
 
$records = mysql_num_rows($s_a_t);
if($records > 0)
{   
while($l_a_t=mysql_fetch_array($s_a_t))
{

 $url=$l_a_t['url'];

if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/',  $url,$id)) {
  $values = $id[1];
  $origin="youtube";
} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/',  $url, $id)) {
  $values = $id[1];  
} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/',  $url, $id)) {
  $values = $id[1];  
} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
  $values = $id[1];  
}
else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/',  $url, $id)) {
    $values = $id[1]; 
} else if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $id)) {
   // echo "Vimeo ID: $output_array[5]";
   $values = $id[5];  
}
else if (preg_match('/https?:\/\/(?:www\.)?vimeo\.com\/\d{8}/',$url, $id)) {
  $values = $id[3];  
}
else {

}

?>
<?php $box = "evm-box";?>
$("#evm-video-gallery").append("<div id='evm-video-box-<?php echo $values;?>' class='<?php echo $box;?>' style='height:<?php echo $height;?>; width:<?php echo $width;?>; margin:<?php echo $column_spacing;?>; float:left;' class='<?php echo $box;?> '><div class='gallery-wrap' style='position:relative; width:100%; float:left; height:100%;'> <a  class='gallery-wrap-href' href='#' data-modal-id='popup-<?php echo $values;?>'><?php  if($origin=="youtube"){  ?><iframe id='popup-youtube-player' frameborder='0'  src='https://www.youtube.com/embed/<?php echo $values; ?>' frameborder='0' allowfullscreen width='100%' height='100%' ></iframe><?php }?><?php  if($origin=="vimeo"){  ?><iframe width='100%' height='100%'id='popup-youtube-player' src='https://player.vimeo.com/video/<?php echo $values; ?>'  webkitAllowFullScreen mozallowfullscreen allowFullScreen width='100%'></iframe><?php }?></a></div><?php if(!empty($show_captions)){ ?><p class='caption' style='color:<?php echo $plus_font_color;?>; font-size:<?php echo $font_size;?>; float:left; width:100%; text-align:center; height:35px; '><?php echo $l_a_t['name'];?></p><?php }?></div>")
<?php 

}
}
?>


});               
}); 
