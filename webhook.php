<?php
   
    require 'shopify.php';
		$conn=mysqli_connect("localhost","","","")or die("sorry! No server not found");
    define('SHOPIFY_API_KEY','');
    define('SHOPIFY_SECRET','');
    include "dbcon.php";

    $query_params['shop'] = $_GET['shop'];
    $query_params['timestamp'] = $_GET['timestamp'];
    $query_params['signature'] = $_GET['signature'];
    $query_params['hmac'] = $_GET['hmac'];


    $select_store_data=mysqli_query($conn,"SELECT * FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
    $shop_details=mysqli_fetch_array($select_store_data);
    
    $shop_name=$shop_details['shop_address'];
    $shop_token=$shop_details['shop_token'];
    
    if($shop_details)
    {
        echo "yes";
 $select_store_data = mysqli_query($conn,"DELETE FROM `app_data_tbl` WHERE `shop_address` = '".$query_params['shop']."'");
  $select_store_data = mysqli_query($conn,"DELETE FROM `videos` WHERE `shop_address` = '".$query_params['shop']."'");
   $select_store_data = mysqli_query($conn,"DELETE FROM `gallery_settings` WHERE `shop_address` = '".$query_params['shop']."'");
	//	include "uninstall_app_email.php";
        if($select_store_data != '')
        {
            echo "database deleted";
// ===================================================

	$sc = new ShopifyClient($shop_name, $shop_token, SHOPIFY_API_KEY, SHOPIFY_SECRET);

        try
        {
            // Get all products
            $script_tags = $sc->call('GET', '/admin/script_tags.json', array('published_status'=>'published')); //receive list of webhooks
            $tagid = $script_tags[0]['id']  ;

		 	$ch = curl_init("https://$shop_name/admin/script_tags/$tagid.json");
		    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $script_tag); 
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "X-Shopify-Access-Token: $shop_token"));
		    $run = curl_exec($ch); 

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

 // ===============================================================
        }
    }
    else
	    {
	        echo "no";
	    }
?>