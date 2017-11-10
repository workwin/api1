<?php 
session_set_cookie_params(86400);
ini_set('session.gc_maxlifetime', 86400);
session_start(); 
$conn=mysqli_connect("localhost","ndiatech_1","Sakalsiddhi1111@","ndia_video")or die("sorry! No server not found");
//$query_params['shop'] = $_GET['shop'];
$shop_name=$_SESSION['shopname'];

 ?>
<div class="full-width addvideos" id="addvideos">

<div class="wrapper">
<div class="inner-container">


<div class="left_inner_header">
<ul>

       <li><a href="insertvideo.php?shop_name=<?php echo $shop_name;?>"><span> + </span> Add Single Video</a></li>
       <li><a href="add.php?shop_name=<?php echo $shop_name;?>"><span> + </span> Add Multiple Videos</a></li>
      <li><a href="viewall.php?shop_name=<?php echo $shop_name;?>">View all</a></li>
       
      </ul>
</div>

<div class="right_inner_header">
<ul>
	  <li><a href="embed_code.php?shop_name=<?php echo $shop_name;?>">Embed code</a></li>
</ul>
</div>


<?php


 if(isset($_POST['btn-save']))
{

$video_caption = $_POST['video_caption'];
$video_desc = $_POST['video_desc']; 
$video_url = $_POST['video_url'];

$insert_token= mysqli_query($conn,"INSERT INTO `videos` ( `shop_address` ,`name` ,`description` ,`url` ,`id`) VALUES ('$shop_name', '$video_caption', '$video_desc', '$video_url', '$shop_id')");


$show = '<a href="viewall.php"> View Video</a>';
$msg = 'Video has been added successfully';

$width = $_POST['width'];
 if(empty($width))
{
$width="300";
}
$width= $width."px";
$column_spacing = $_POST['column_spacing'];
if(empty($column_spacing ))
{
$column_spacing ="20";
}
$column_spacing= $column_spacing."px";

$height = $_POST['height'];
if(empty($height ))
{
$height ="200";
}
$height= $height."px";


$select_settings = mysqli_query($conn,"SELECT * FROM `gallery_settings` WHERE `shop_address` = '$shop_name'");


 $rec = mysqli_num_rows($select_settings);
if($rec > 0)
{  
$update_token=mysqli_query($conn,"UPDATE  `gallery_settings` SET  `videogallerytheme` =  '$videogallerytheme',    `noi` =  '$noofimg',`show_captions`= '$show_captions', `font_color` =  '$font_color', `plus_font_color` =  '$plus_font_color', `plus_bg_color` =  '$plus_bg_color',  `name_font_size` =  '$name_font_size',`width` =  '$width',`column_spacing` =  '$column_spacing' ,`height` =  '$height' WHERE  `shop_address` = '$shop_name'");
//echo '<div id="add_setting">';
// echo "Settings have been updated successfully!";
// echo '</div>';
}
else
{
$insert_token= mysqli_query($conn,"INSERT INTO `gallery_settings` ( `shop_address` , `videogallerytheme` ,  `noi`,`show_captions`, `font_color`  , `plus_font_color`  , `plus_bg_color`  , `name_font_size`,`width`,`column_spacing`,`height`) VALUES ('$shop_name', '$videogallerytheme',  '$noofimg','$show_captions','$font_color', '$plus_font_color', '$plus_bg_color', '$name_font_size','$width','$column_spacing','$height')");
//echo '<div id="add_setting">';
 //echo "Settings have been saved successfully!";
 //echo '</div>';
}



}
?>

<div class="insert-wrap">
<div class="left-insert-video-wrap"> 
<div class="left-section">
<h2> Post Video information </h2>
<p> Some basic information about video post.</p>

</div>
</div>

<div class="insert-video-wrap">
 <div class="wrapper">

<div class="inner-container">
 
 <div class="show_all">
			


		    

	
 <form method='post' name="myForm" enctype="multipart/form-data" action=""id="reg-form" autocomplete="off">
       <div class="form_wrapper">
       <div class="input_addbox_wrapper">
               <label>Video Caption</label>
                <div class="input_box"><input type='text' id="video_caption" name='video_caption' class='form-control' placeholder='Video Caption' value="" /></div>
     </div>

 <div class="input_addbox_wrapper">
                <label>Video Url</label>
                <div class="input_box"><input type='url' id='video_url' name='video_url' class='form-control' placeholder='EX : https://www.youtube.com/watch?v=iCaYJS4QufY' value="" required /></div>
     </div>
      
        

<div class="input_addbox_wrapper" id="ebutton">
             <div class="input_box_submit ebtn"><button type="submit" class="btn_add_review evmbtn btn btn-info" name="btn-save" id="btn_save submit" >Save</button>  </div>

			  </div>
<div id="message"><?php if(!empty($msg)){ echo $msg;}?></div>
</div>
</form>




</div>
</div>
</div>

</div>
</div>


<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->

<!--<script type="text/javascript">
$(document).ready(function() {	
	
	// submit form using $.ajax() method
	
	$('#reg-form').submit(function(e){
		
		e.preventDefault(); // Prevent Default Submission
		
		$.ajax({
			url: 'insertvideo.php',
			type: 'POST',
			data: $(this).serialize() // it will serialize the form data
		})
		.done(function(data){
			$('#addvideos').fadeOut('slow', function(){
				$('#addvideos').fadeIn('slow').html(data);
			});
		})
		.fail(function(){
			alert('Ajax Submit Failed ...');	
		});
	});
	
	
	
});
</script> -->

