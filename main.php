<?php

    require 'shopify.php';
   // include "dbcon.php";
	
    /* Define your APP`s key and secret*/
    define('SHOPIFY_API_KEY','');
    define('SHOPIFY_SECRET','');
    /* Define requested scope (access rights) - checkout https://docs.shopify.com/api/authentication/oauth#scopes   */
    define('SHOPIFY_SCOPE','read_script_tags,write_script_tags,write_themes,read_content, write_content');

    if (isset($_GET['code'])) { // if the code param has been sent to this page... we are in Step 2
        // Step 2: do a form POST to get the access token
        $shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        //session_unset();
       // $create_date=date(()'Y-m-d');
	   	$create_date=date_default_timezone_set("UTC"); 
        // Now, request the token and store it in your session.
        $_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
        if ($_SESSION['token'] != '')
        $_SESSION['shop'] = $_GET['shop'];
        $shop_name = $_SESSION['shop'];
        $shop_token = $_SESSION['token'];
        $id=$shop_token;

        if(isset($shop_name))
        {    
        $select_shop_record=mysqli_query($conn,"SELECT * FROM  `app_data_tbl`  WHERE  `shop_address` =  '$shop_name'");
        $shop_record=mysqli_fetch_array($select_shop_record);
        $shop_address=$shop_record['shop_address'];
        if($shop_address == $shop_name)
        {
            echo "Application Installed. Redirecting...";
            ?>
             <a href="https://<?php echo $shop_name;?>/admin/apps/">Click here</a>;
             <?php // echo "<script>parent.location.href='https://$shop_name/admin/apps/13727db2c8d98f9a00c192e7f91f4b40'</script>"; ?>
        <?php
        }
        else
        {
        $insert_store_info=mysqli_query($conn,"INSERT INTO `app_data_tbl` (`shop_id`, `shop_token`, `shop_address`,  `create_date`) VALUES (NULL, '$shop_token', '$shop_name', '$create_date')");
        if($insert_store_info== 0)
        {
            echo "Installation Failed....!!!";
        }
        else
        {?>
            <style>.middle{text-align: center;text-transform: capitalize; font-size: 13px;}i{color: green;}</style>
        <div class="middle"></div>
<?php
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
// ===================Get Theme Details ================================================================================
$sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);
           $themes = $sc->call('GET', '/admin/themes.json', array('published_status'=>'published'));
                    $shop_details = $sc->call('GET', '/admin/shop.json');
             $shop_email= $shop_details[email];
            $shop_owner= $shop_details[shop_owner];

 foreach ($themes as $themedetails) {
  if($themedetails['role']=="main")
{
$themeid=$themedetails['id']; 
}
}

    // ===================add new snippet 
$ch = curl_init("https://$shop_name/admin/themes/$themeid/assets.json");
    $cssurl = "https://www.ndiatech.com/apps/videoportico/video-gallery-snippet.php";
    $fetch_css = @file_get_contents( $cssurl );
    $postpage = array( 'asset'=> array(
                                'key'=> 'snippets/video_portico.liquid',
                                'value'=> $fetch_css
                          ));
     $resp_assets_arr = $sc->call('PUT', "/admin/themes/$themeid/assets.json", $postpage);
     $fetch_css = @file_get_contents( $cssurl );
     $page = str_replace('\\/', '/', json_encode($resp_assets_arr));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $page); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    
    
?>

    <div style="display:none"><?php $chargeout = curl_exec($ch);?></div>
	
        <?php

$ch = curl_init("https://$shop_name/admin/pages.json");
  $cssurl = '<div id="evm-gallery"></div><script src="https://www.ndiatech.com/apps/videoportico/embed.php?shop='.$shop_name.'"></script>';
    //$cssurl = "https://www.apps.expertvillagemedia.com/shopify/evm-gallery/evm-gallery-snippet.php";
    $fetch_css = @file_get_contents( $cssurl );
    $postpage = array( 'page'=> array(
                                'title'=> 'Video ',
                                'body_html'=> $fetch_css
                            ));
    $page = str_replace('\\/', '/', json_encode($postpage));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $page); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
   <div style="display:none"><?php $output = curl_exec($ch); ?></div>

    <?php



// ============================== add uninstall webhook ============================================================
 
    $ch = curl_init("https://$shop_name/admin/webhooks.json");
    $callback = 'https://www.ndiatech.com/apps/videoportico/webhook.php?shop='.$shop_name; 

    $postwebhook = array("webhook" => array( "topic"=>"app/uninstalled",
                        "address"=> $callback,
                        "format"=> "json"));
     
    $webhook = str_replace('\\/', '/', json_encode($postwebhook));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $webhook); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
    <div style="display:none"><?php $out = curl_exec($ch); ?></div>
    <?php

// ============================== add Recurring charge api 
$received = $sc->call('GET', '/admin/recurring_application_charges.json', array('published_status'=>'published'));
        $charge_id = $received[0]['id'];
        $value = $received['0']['status'];
        $confirmation_url = $received[0]['confirmation_url'];
        $billing_on = $received[0]['billing_on'];
        $created_at = $received[0]['created_at'];
        $updated_at = $received[0]['updated_at'];
        $activated_on = $received[0]['activated_on'];
        $trial_ends_on = $received[0]['trial_ends_on'];
    $ch = curl_init("https://$shop_name/admin/recurring_application_charges.json");
    $callback = 'https://www.ndiatech.com/apps/videoportico/charge_application_rec.php?shop='.$shop_name; 

    $postapplicationcharge = array("recurring_application_charge" => 
                                    array("name" => "Basic Plan",
                                        "price" => 0.99,
                                        "return_url" => $callback,
                                        "trial_days" => 7,
                                        "test" => true
                                    ));

    $applicationcharge = str_replace('\\/', '/', json_encode($postapplicationcharge));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $applicationcharge); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
    ?>
    <div style="display:none"><?php $chargeout = curl_exec($ch);?></div>
 <?php  
    
echo "<script>parent.location.href='https://www.ndiatech.com/apps/videoportico/main.php?shop=$shop_name&token=$shop_token'</script>";


        try
        {
            // Get all products
        $received = $sc->call('GET', '/admin/recurring_application_charges.json', array('published_status'=>'published'));
        $charge_id = $received[0]['id'];
        $value = $received['0']['status'];
        $confirmation_url = $received[0]['confirmation_url'];
        if($value=='accepted')
        {
        $update= mysqli_query($conn,"UPDATE  `app_data_tbl` SET  `charge_status` = 'accepted',  `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");
echo "<script>parent.location.href='https://www.ndiatech.com/apps/videoportico/main.php?shop=$shop_name&token=$shop_token'</script>";
        }
        elseif($value=='pending')
        {
        $update= mysqli_query($conn,"UPDATE  `app_data_tbl` SET `charge_status` = 'pending',  `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");

        }
        else
            {
           $update= mysqli_query($conn,"UPDATE  `app_data_tbl` SET  `charge_status` = 'pending', `confirm_url` =  '$confirmation_url' WHERE `shop_address` =  '$shop_name'");
           echo "<script>parent.location.href='$confirmation_url'</script>";
            }

        $_SESSION['confirmation_url']= $confirmation_url;

// ==========================================================================================================

            try
            { 
                // API call limit helpers
                // echo $sc->callsMade(); // 2
                // echo $sc->callsLeft(); // 498
                // echo $sc->callLimit(); // 500

            }
            catch (ShopifyApiException $e)
            {
                // If you're here, either HTTP status code was >= 400 or response contained the key 'errors'
                echo '<pre>';
                print_r( $e->getMessage() );
                echo '</pre>';
            }

        }
        catch (ShopifyApiException $e)
        {
            /* 
             $e->getMethod() -> http method (GET, POST, PUT, DELETE)
             $e->getPath() -> path of failing request
             $e->getResponseHeaders() -> actually response headers from failing request
             $e->getResponse() -> curl response object
             $e->getParams() -> optional data that may have been passed that caused the failure

            */
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        catch (ShopifyCurlException $e)
        {
            // $e->getMessage() returns value of curl_errno() and $e->getCode() returns value of curl_ error()
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        // header("Location: index.php");
        exit; 


// =====================================================================================
    ?>
    
    <?php

    }
    }
    }

        $sc = new ShopifyClient($_SESSION['shop'], $_SESSION['token'], SHOPIFY_API_KEY, SHOPIFY_SECRET);
        try
        {
            // Get all products
            $products = $sc->call('GET', '/admin/products.json', array('published_status'=>'published'));
            
            echo '<pre>';
            // print_r( $products );
            echo '</pre>';
            try
            { 
                // API call limit helpers
                echo $sc->callsMade(); // 2
                echo $sc->callsLeft(); // 498
                echo $sc->callLimit(); // 500

            }
            catch (ShopifyApiException $e)
            {
                // If you're here, either HTTP status code was >= 400 or response contained the key 'errors'
                echo '<pre>';
                print_r( $e->getMessage() );
                echo '</pre>';
            }

        }
        catch (ShopifyApiException $e)
        {
            /* 
             $e->getMethod() -> http method (GET, POST, PUT, DELETE)
             $e->getPath() -> path of failing request
             $e->getResponseHeaders() -> actually response headers from failing request
             $e->getResponse() -> curl response object
             $e->getParams() -> optional data that may have been passed that caused the failure

            */
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        catch (ShopifyCurlException $e)
        {
            // $e->getMessage() returns value of curl_errno() and $e->getCode() returns value of curl_ error()
            echo '<pre>';
            print_r( $e->getMessage() );
            echo '</pre>';
        }
        // header("Location: index.php");
        exit;       
        
    
    }
    else{

    // if they posted the form with the shop name
       // if they posted the form with the shop name
    if(isset($_GET['shop'])) {

    $hmac=$_GET['hmac'];
    $timestamp=$_GET['timestamp'];

       
        // Step 1: get the shopname from the user and redirect the user to the
        // shopify authorization page where they can choose to authorize this app
        $shop = $_GET['shop'];
  $select_shop_record=mysqli_query($conn,"SELECT * FROM  `app_data_tbl` WHERE  `shop_address` =  '$shop' LIMIT 1");
        $shop_record=mysqli_fetch_array($select_shop_record);
		$hmac = $_GET['hmac'];
        $shop_address=$shop_record['shop_address'];
        $shop_name=$shop_record['shop_address'];
        //$plan=$shop_record['app_plan'];
			$charge=$shop_record['charge_status'];
		$confirmation_url=$shop_record['confirm_url'];
        if($shop_address == $shop)
        {
        
        include "api_call.php";
	   
	   echo "hello";
        }
       else
      {
        $shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
        }
        header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
        exit;
		}
    }
    
    // first time to the page, show the form below
?>



    <?php 
    }
     ?>
    

<script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
  

  <script type="text/javascript">
  ShopifyApp.init({
    apiKey: '5f3265f5e0f39bd7777e3978cd9758ec',
    shopOrigin: 'https://<?php echo $shop_name;?>'
  });

  ShopifyApp.ready(function(){
    ShopifyApp.Bar.initialize({
      title: "Dashboard"
    });

    ShopifyApp.Bar.loadingOff();
  });
</script>

