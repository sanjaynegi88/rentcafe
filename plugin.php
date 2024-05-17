<?php

/**
 * @package cazarin_shortcodes
 * @version 1.6
 */
/*
Plugin Name: Rentcafe API Connection
Plugin URI: #
Description: Additional Shortcodes of Cazarin Interactive
Author: Cazarin Interactive
Version: 1.1
Author URI: #
*/


$apikey = "xxxxxx-xxxx-xxxx-xxxx-xxxxxxxx751";
ini_set("allow_url_fopen", 1);

function cazarin_additon_styling_forrentcafe()
{
    wp_register_style('popup_style', plugins_url('rentcafe.css', __FILE__));
    wp_enqueue_style('popup_style');
    wp_register_style('owl_style', plugins_url('owl.theme.default.css', __FILE__));
    wp_enqueue_style('owl_style');
    wp_enqueue_script('jquery');
    wp_enqueue_script('owl-js', plugins_url('owl.carousel.js', __FILE__));
    wp_enqueue_script('popup-js', plugins_url('rentcafe.js', __FILE__));
    //  wp_localize_script( 'popup-js', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('init', 'cazarin_additon_styling_forrentcafe');

function call_for_property($attr)
{
    ob_start();
    global $apikey;
	global $post;
    if ($attr['id'] != "") {
        $propertydata = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&propertyId=' . $attr['id']);
        $amenities = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=amenities&apiToken=' . $apikey . '&propertyId=' . $attr['id']);
		
		    $petpolicy = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=petPolicy&apiToken=' . $apikey . '&propertyId=' . $attr['id']);
		
		
        $floorplan = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&type=amenities&apiToken=' . $apikey . '&propertyId=' . $attr['id']);
        $images = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=images&type=propertyData&apiToken=' . $apikey . '&propertyId=' . $attr['id']);
    } else {
        $propertydata = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . $attr['code']);
        $amenities = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=amenities&apiToken=' . $apikey . '&PropertyCode=' . $attr['code']);
        $floorplan = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&type=amenities&apiToken=' . $apikey . '&PropertyCode=' . $attr['code']);
        $images = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=images&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . $attr['code']);
		
 $petpolicy = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=petPolicy&apiToken=' . $apikey . '&PropertyCode=' . $attr['code']);
		
    }
	
    $obj = json_decode($propertydata);
    $petpolicy = json_decode($petpolicy);
    $amenities = json_decode($amenities);
    $floorplan = json_decode($floorplan);
    $images = json_decode($images);
    $custom = array();
    $regular = array();
   //print_r($petpolicy);
    
  // print_r($amenities);
    foreach ($amenities as $ameniti) {

        if ($ameniti->CustomAmenityType == 1) {

            array_push($custom, $ameniti->CustomAmenityName);
        } else {
            array_push($regular, $ameniti->CustomAmenityName);
        }
    } ?>
    <style>
        section.main-content {
            padding-top: 0 !important;
        }

        section.main-content>.container {
            width: 100% !important;
            padding: 0 !important;
        }

        .col-md-12>.container {
            max-width: 1140px;
        }
    </style>
    <section class="cs-section no-padding">
        <?php 
        
        if (has_post_thumbnail($attr['content']) ){
            
            $image_url = get_the_post_thumbnail_url($attr['content'],'full');
            
        }else{
            $image_url = $images[0]->ImageURL;
        }
        
        ?>
        
        
        <div class="header_property" style="height:600px;background:url('<?php echo $image_url; ?>');background-size: cover;
    background-position: center !important;background-repeat:no-repeat;background-color:#000;">
           <?php /* <h1><?php echo $obj[0]->name; ?></h1> */ ?>
        </div>
    </section>
    <section class="cs-section no-padding">
        <div class="container-fluid">
        </div>
        </div>
        </div>
        <div style="padding:40px;clear:both;"></div>
        <div class="col-md-12">
            <div class="container">
                <h1 class="lower_border">Welcome To <?php echo $obj[0]->name; ?></h1>
                <div class="description_property">
                    
                    
                    <?php 
               
                    $poid = $attr['content'];   
              
                
                    $replace = ' ';
                    //echo preg_replace('(.*?)/\./(.*?)/i', $replace, $obj[0]->description);
                    
                    $dot = str_replace(".",". <div class='space_5'></div>",$obj[0]->description);
                    
                    $dot = str_replace(". <div class='space_5'></div>com",".com",$dot);
                    
                    $con = str_replace("!",". <div class='space_5'></div>",$dot);
                    
 
                    $count = 0;
              // $s1 = preg_replace_callback('/./',function($m) use (&$count) { ++$count; return $count % 2 ? '<code>' : '</code>'; },$s);
                 
        
                    
            //    $parsedown = new Parsedown();
                
               // echo $parsedown->text($obj[0]->description);
                    
                    
                    if($poid > 0){
                        
                        rwmb_the_value( 'customcontent',$poid );
                        
                    }else{
                    
                    echo $con;
                    }
					
					$price =  rwmb_meta( 'custompricing',$poid );
				    $counter = 0;
					
                    //echo $obj[0]->description; ?>
                
                    
                    <div style="padding:30px;"></div>
                    <h2 class="lower_border">Address</h2>
                    <div style="padding:10px;"></div>
                    <?php echo $obj[0]->address; ?> , <?php echo $obj[0]->city; ?> <?php echo $obj[0]->state; ?> <?php echo $obj[0]->zipcode; ?>
                </div>
                
                <div style="padding:30px;"></div>
                
                
                
                <?php 
                $add = rwmb_meta( 'additional_content',$poid );
                if(strlen($add)){
                
                echo "<div class='additional_details'>".$add."</div>";    
                    
                }
                
                ?>
                
                
                
                
                <?php 
                
                $size = sizeOf(rwmb_meta( 'faq_list',$poid ));
                
                if($size > 0){ ?>
                <div style="padding:30px;"></div>
                <div class="faq_section additional_details">
                <h2>Common Queries About <?php echo $obj[0]->name; ?></h2>    
                <?php 
                foreach(rwmb_meta( 'faq_list',$poid ) as $ques){
                    
                    echo "<p><b>".$ques[0]."</b></p>";
                    echo "<p>".$ques[1]."</p>";
                    echo "<br>";
                }
                echo "</div>";    
                }
                
                ?>
                
                
                
                
                
                
                
                <div style="padding:30px;"></div>
                <div class="amenities_property">
                    <h2 class="lower_border">AMENITIES</h2>
                    <div style="padding:20px;"></div>
                    <div class="col-md-4">
                        <h4>Community Amenities</h4>
                        <ul><?php echo list_display_am($custom); ?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h4>Amenities</h4>
                        <ul><?php echo list_display_am($regular); ?>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        
                    <?php 
                    if(sizeof($petpolicy) > 1){
                        $total = 0;
                        foreach($petpolicy as $policy){
                            $total = $total + $policy->PetType;
                         
                        }
                    }else{
                        
                        $total = $petpolicy[0]->PetType;
                    }
                 
                    
                    
                    $pp = "";
                    switch($total){
                    
                    case "1":    
                    $pp = "Only Allow Cats";    
                    break;
                    
                    case "2":    
                    $pp = "Only Allow Dogs";    
                    break;
                    
                    case "3":    
                    $pp = "Cats and Dogs Allowed";    
                    break;
                    
                    case "4":    
                    $pp = "No Pets Allowed";    
                    break;
                    
                    default:    
                    $pp = "No Pets Allowed";    
                    break;
                    
                    }
                    
                    
                    ?>    
                        
                        <h4>
                        </h4>
                        <ul>
                            <li><?php echo $pp; ?></li>
                        </ul>
                    </div>
                </div>
                <div style="clear:both;padding:30px;"></div>
                <h2 class="lower_border">Floorplans</h2>
                <div style="padding:20px;"></div>
                <div class="verticle_tabs_plans">
                    <ul class="tab_navs">
                        <?php foreach ($floorplan as $plan) { ?>
                            <li><a href="#floorplan<?php echo $plan->FloorplanId; ?>"><?php echo $plan->FloorplanName; ?></a></li>
                        <?php } ?>

                    </ul>
                    
                  
                    <div class="plan_content">
                        <?php foreach ($floorplan as $key => $plans) { ?>
                            <div id="floorplan<?php echo $plans->FloorplanId; ?>" class="plan_content_inner" <?php if ($key == 0) { echo "style='display:block;'"; } ?>>
                                <div class="col-md-12">
                                    
                                    
                                    <?php 
																	  $cutom_fpimages = array();
                                 if($_SERVER["REMOTE_ADDR"]=='45.116.122.142'){

		$cutom_fpimages = get_post_meta($post->ID, 'floorplans_images_'.$key );
	}
                                     $fpimages = explode(",",$plans->FloorplanImageURL);
                                    ?>
                                    <h3><?php echo $plans->FloorplanName; ?></h3>
                                    <p style="display:none;"><?php print_r($plans); ?></p>
                                    <p>(Contact for Availability)</p>
                                    <?php
                                    $rent = $plans->MaximumRent;
									$rentMin = $plans->MinimumRent;								  
                                    if ($rent > 0 && $rent > $rentMin) {
                                        $rent = "$".$rentMin." - "."$" . $plans->MaximumRent;
                                    }else if($rent == $rentMin && $rent > 0){
										$rent = "$" . $plans->MaximumRent;
									} else {
                                        $rent = "Call for Price";
										//$rent = "$" . $plans->MaximumRent;
                                    }
                                    
                                
                                    
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr data-selenium-id="tRow6_1">
                                                <td style="width: 40%;"><strong>Bed</strong></td>
                                                <td style="width: 60%;" data-selenium-id="Bed_6"><?php echo $plans->Beds; ?></td>
                                            </tr>
                                            <tr data-selenium-id="tRow6_2">
                                                <td style="width: 40%;"><strong>Bath</strong></td>
                                                <td style="width: 60%;" data-selenium-id="Bath_6"><?php echo $plans->Baths; ?></td>
                                            </tr>
                                            <tr data-selenium-id="tRow6_3">
                                                <td><strong>Sq.Ft.</strong></td>
                                                <?php 
                                                if($plans->MinimumSQFT > 0 && $plans->MinimumSQFT != $plans->MaximumSQFT){
                                                ?>
                                                
                                                <td data-selenium-id="Sqft_6"><?php echo $plans->MinimumSQFT; ?> - <?php echo $plans->MaximumSQFT; ?></td>
                                            <?php }else{ ?>
                                            <td data-selenium-id="Sqft_6"><?php echo $plans->MaximumSQFT; ?></td>
                                            <?php } ?>
                                            
                                            </tr>
                                            <tr data-selenium-id="tRow6_4">
    <td style="width: 40%;"><strong>Rent</strong></td>
   
   <?php 
   
   if(is_numeric($rent)){
      $pr = "$"; 
   }else{
            $pr = ""; 
   }
   
   
   
   if($rent >= $price[$counter]){
   
   ?>
   
    <td style="width: 60%;" data-selenium-id="Rent_6"><?php echo $pr.$rent; ?></td>
    
    <?php }else{ ?>
 <td style="width: 60%;" data-selenium-id="Rent_6"><?php echo $pr.$rent; ?></td>

    
    
    <?php } 
    
    $counter++;
    
    ?>
    
    
    
    
                                            </tr>
                                            <?php if ($plans->MaximumDeposit > 0) { ?>
                                                <tr data-selenium-id="tRow6_6">
                                                    <td style="width: 40%;"><strong>Deposit</strong></td>
                                                    <td style="width: 60%;" data-selenium-id="Deposit_6"></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                              
                                    <?php if ($plans->AvailabilityURL != "") { ?>
                                        <a style="border: 1px solid;" href="<?php echo $plans->AvailabilityURL; ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-lg cs-btn-custom-61af6051c28d1">View Current Availability</a>
                                    <?php } else { ?>
                              
                              
<a style="border: 1px solid;" href="https://boisclaircorporation.com/enquiry?pid=<?php echo $poid; ?>&property=<?php echo $obj[0]->name; ?>&contact=<?php echo $obj[0]->email; ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-lg cs-btn-custom-61af6051c28d1">Contact Us</a>
                                    <?php } ?>
                                    <?php
                                    $Beds = $plans->Beds . 'BR';
                                 
                                     
                                    $fpimages= array_filter($fpimages);
																	  $cutom_fpimages =  array_filter($cutom_fpimages);
																	  
																	  if(!empty($cutom_fpimages)){
																		   if (count($cutom_fpimages) > 0) { ?>
																			   <div class="owl-carousel owl-theme">
                                            <?php 
                                            
                                            foreach($cutom_fpimages as $image){
                                                $cleaner_image = wp_get_attachment_image_url( $image, 'full');
                                                echo "<div><img src=".$cleaner_image."></div>";
                                            }
										}
                                            ?>
                                            
                                            </div>
																	<?php	   
																	  }else{
                                        if (count($fpimages) > 0) { ?>
                                            <div class="owl-carousel owl-theme">
                                            <?php 
                                            
                                            foreach($fpimages as $image){
                                                $cleaner_image = str_replace(' ', '%20', $image);
                                                echo "<div><img src=".$cleaner_image."></div>";
                                            }
										}
                                            ?>
                                            
                                            </div>
                                    <?php }
                                    
                                    
                                    
                                    ?>
                                </div>
                                <div class="col-md-5">
                           
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div style="clear:both;padding:30px;"></div>
                <h2 class="lower_border">Image Gallery</h2>
                <div class="owl-carousel owl-theme">
                    <?php
                    foreach ($images as $image) {
                         $clean_image = str_replace(' ', '%20', $image->ImageURL);
                        echo "<div><img src=" .$clean_image. " height='200' /></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('fetch_listing', 'call_for_property');

function list_display_am($arr)
{
    foreach ($arr as $ar) {
        echo "<li>" . $ar . "</li>";
    }
}
add_shortcode('search_properties', 'search_results_properties');

function search_results_properties($attr)
{
    global $apikey;
    $city = str_replace(" ", "%20", $attr['city']);
    $propertydata = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=searchJSON&apiToken=' . $apikey . '&city=' . $city);
    ob_start();
    $obj = json_decode($propertydata);


    if ($attr['mannual'] == "") {
        echo fetch_property_from_object($obj, $attr['city']);
    } else {
        $ids = explode(",", $attr['mannual']);
        $ids = array_filter($ids);
        echo fectch_property_from_id($ids);
    }
    return ob_get_clean();
}
add_shortcode('property_output', 'property_output');

function property_output()
{
    ob_start();
    if (isset($_GET['propertyid'])) {
        echo do_shortcode('[fetch_listing code=' . $_GET["propertyid"] . ']');
    }
    if (isset($_GET['city'])) {
        $city =  str_replace("+", " ", $_GET['city']);
        $string = get_id_by_cityname($city);
        if ($string == "") {
            echo "<h2>Sorry No Results Found</h2>";
        } else {
            echo "<h2>Search Results</h2>";
            echo do_shortcode('[search_properties mannual="' . $string . '"]');
        }
    } else {
        echo "<h2>Sorry No Property Data Found</h3>";
    }
    return ob_get_clean();
}

function fetch_property_from_object($obj, $city)
{
    foreach ($obj as $property) {
        if ($property->City == $city) { ?>
            <div class="row md-padding property_search_results">
                <div class="container" style="box-shadow: 0 0 3px #ccc;">
                    <div class="col-md-4 property_image" style="background:url('https://cdngeneralcf.rentcafe.com/<?php echo $property->ImageURL; ?>') no-repeat;background-size:cover;">
                    </div>
                    <div class="col-md-8 sm-padding">
                        <div class="property_cover" style="padding:0 30px;">
                            <?php $post_id = get_post_id_where_title_is($property->PropertyName); ?>
                            <h3><a href="<?php echo get_permalink($post_id); ?>"><?php echo $property->PropertyName; ?></a></h3>
                            <p><b>Address</b> : <?php echo $property->Address; ?> , <?php echo $property->ZipCode; ?></p>
                            <p><b>Bedrooms</b> : <?php echo $property->maxbed; ?></p>
                            <p><b>Bathrooms</b> : <?php echo $property->maxbath; ?></p>
                            <?php if ($property->maxrent == 0) { ?>
                                <p><b>Rent</b> : Contact for Details</p>
                            <?php } else { ?>
                                <p><b>Rent</b> : <?php if ($property->minrent > 0 && $property->minrent != $property->maxrent) { echo "$" . $property->minrent . " - "; } ?><?php echo "$" . $property->maxrent; ?></p>
                            <?php } ?>
                            <div class="cs-btn-align text-left">
                                <a href="<?php echo get_permalink($post_id); ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-lg cs-btn-custom-61af6051c28d1">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    }
}

function fectch_property_from_id($ids)
{
    global $apikey;
    foreach ($ids as $id) {
		
        $propertydata = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . $id);
        $images = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=images&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . $id);
        $images = json_decode($images);
        $property = json_decode($propertydata);
        ?>
        <div class="row md-padding property_search_results cs-equal-height">
            <div class="container" style="box-shadow: 0 0 3px #ccc;">
                <div class="col-md-4 property_image" style="background:url('<?php echo $images[0]->ImageURL; ?>') no-repeat;background-size:cover;">
                </div>
                <div class="col-md-8 sm-padding">
                    <div class="property_cover" style="padding:0 30px;">
                        <?php $page = get_page_by_title($property[0]->name, OBJECT, 'properties'); ?>
                        <h3><a href="<?php echo get_permalink($page->ID); ?>"><?php echo $property[0]->name; ?></a></h3>
                        <p><b>Address</b> : <?php echo $property[0]->address; ?> , <?php echo $property[0]->state; ?> <?php echo $property[0]->zipcode; ?></p>
                        <?php 
                        $ex = substr($property[0]->description, 0, 350);
                        $ex = str_replace(".",".&nbsp;",$ex);
                        $ex = str_replace("!","!&nbsp;",$ex);
                       
                       $ann = rwmb_meta('custom_announcement','',$page->ID);
                       
                       if($ann !=""){
                           echo "<p class='custom_announcement'><strong>".$ann."</strong></p>";
                       }
                       
                        ?>
                    
                        
                    <p><b>Details</b> : <?php echo $ex; ?>....
                    <a href="<?php echo get_permalink($page->ID); ?>"><b><i>Read More</i></b></a>
                        </p>
                        <br>
                        <div class="cs-btn-align text-left">
                            <a href="<?php echo get_permalink($page->ID); ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-lg cs-btn-custom-61af6051c28d1">View Details</a>
                            <a href="mailto:<?php echo $property[0]->email; ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-lg cs-btn-custom-61af6051c28d1">
                                <i class="fa fa-envelope"></i> Email</a>
                            <?php if ($property[0]->phone != "") { ?>
                                <a href="tel:<?php echo $property[0]->phone; ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-lg cs-btn-custom-61af6051c28d1">
                                    <i class="fa fa-phone"></i> <?php echo $property[0]->phone; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
add_shortcode('search_form', 'search_form_call');

function search_form_call()
{
    ob_start(); ?>
    <div class="col-md-12" style="margin-bottom: 90px;">
        <h4>Search By Community</h4>
        <form action="/property/" method="get">

            <select name="propertyid" id="community_search" required="required">
                <option value="">Select a Community</option>
                <?php echo get_all_communities(); ?>
            </select>
            <br>
            <input type="submit" class="search_filter" value="Search Community">
        </form>
    </div>
    <div class="col-md-12">
        <h4>Search Options</h4>
        <form action="#" method="get">
            <div class="">
                <label>Number of Bedrooms</label>
                <select name="bedrooms" id="beds_av">
                    <option>Any</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                </select>
                <br>
            </div>
            <div style="clear:both;"></div>
            <div class="">
                <br>
                <label>Select City</label>
                <select name="city" id="city_av">
                    <option>Any</option>
                    <?php
                        $cities = get_all_cities();
                        foreach ($cities as $citi) {
                            echo $citi;
                        }
                    ?>
                </select>
            </div>
            <div style="clear:both;"></div>
            <div class="">
                <br>
                <input type="button" class="search_filter search_filter_call" value="Apply Filter">
            </div>
        </form>
    </div>
    <?php
    return ob_get_clean();
}

function get_all_communities()
{
    $data = get_option('property_id');
    global $apikey;
    if (!empty($data)) {
        $pList = explode(PHP_EOL, $data);
        foreach ($pList as $item) {
            if ($item != "") {
                $query = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . trim($item);
                $propertydata = file_get_contents($query);
                $property = json_decode($propertydata);

                if ($property[0]->name != "") {
                    echo "<option value='" . $property[0]->PropertyCode . "'>" . $property[0]->name . "</option>";
                }
            }
        }
    }
}

function get_all_cities()
{
   
    $returnArray = [];
    $data = get_option('property_id');
    global $apikey;

    if (!empty($data)) {
        $pList = explode(PHP_EOL, $data);
        foreach ($pList as $item) {
            if ($item != "") {
                $query = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . trim($item);
                $propertydata = file_get_contents($query);
                $property = json_decode($propertydata);
                if ($property[0]->city != "") {
                    $option = "<option>" . $property[0]->city . "</option>";
                    array_push($returnArray, $option);
                }
            }
        }
    }
    $returnArray = array_unique($returnArray);
    $returnArray = array_filter($returnArray, function ($a) {
        return trim($a) !== "";
    });
    return $returnArray;
}

function get_id_by_cityname($city)
{
    $data = get_option('property_id');
    global $apikey;
    $dataReturn = "";
    if (!empty($data)) {
        $pList = explode(PHP_EOL, $data);
        foreach ($pList as $item) {
            if ($item != "") {
                $query = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . trim($item);
                $propertydata = file_get_contents($query);
                $property = json_decode($propertydata);

                if ($property[0]->city == $city || $city == 1) {

                    $dataReturn .= $property[0]->PropertyCode . ",";
                }
            }
        }
    }
    return $dataReturn;
}
add_action('init', 'step_function_backend');

function step_function_backend()
{
    if (isset($_POST['update_properties'])) {
        $data = get_option('property_id');
        global $apikey;
        if (!empty($data)) {
            $pList = explode(PHP_EOL, $data);
            foreach ($pList as $item) {
                if ($item != "") {
                    $query = 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . trim($item);
                    $propertydata = file_get_contents($query);
                    $property = json_decode($propertydata);
                    if (get_page_by_title($property[0]->name) == null) {
                        $post_id = wp_insert_post(array(
                            'post_type' => 'properties',
                            'post_title' => $property[0]->name,
                            'post_content' => $property[0]->PropertyCode,
                            'post_status' => 'publish',
                            'comment_status' => 'closed',   // if you prefer
                            'ping_status' => 'closed',      // if you prefer
                        ));
                    }
                }
            }
        }
    }
}
add_shortcode('all_properties', 'all_properties');

function all_properties()
{
    global $apikey;
    $data = get_option('property_id');
    ob_start();
    if (!empty($data)) { ?>
        <div class="row">
            <div class="col-md-3">
                <?php echo do_shortcode('[search_form]'); ?>
            </div>
            <div class="col-md-9">
                <?php
                $pList = explode(PHP_EOL, $data);
                $pList = array_filter($pList, function ($a) {
                    return trim($a) !== "";
                });
                foreach ($pList as $item) {
                    if ($item != "") {
                        $propertydata = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . trim($item));
                        $images = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=images&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . trim($item));
                        $images = json_decode($images);
                        $property = json_decode($propertydata);
                        $status = "display:block;";
                        if ($_POST['search_action'] == "true") {
                            $status = "display:block;";
                            if (is_numeric($_POST['search_value']) && $_POST['search_value'] == $property[0]->zipcode) {
                                $status = "display:block;";
                            } else if (str_contains(strtolower($_POST['search_value']), strtolower($property[0]->city))) {
                                $status = "display:block;";
                            } else {
                                $status = "display:none;";
                            }
                        } ?>
                        <div class="col-md-4 no-padding property_search_results_grid" style="margin-bottom: 20px;<?php echo $status; ?>" city="<?php echo $property[0]->city; ?>" beds="<?php echo get_max_beds(trim($item)); ?>" zip="<?php echo $property[0]->zipcode; ?>" state="<?php echo $property[0]->state; ?>">
                            <div class="container" style="box-shadow: 0 0 10px #ccc;">
                                <div class="property_image_grid" style="background:url('<?php echo $images[0]->ImageURL; ?>') no-repeat;background-size:cover;">
                                </div>
                                <div class=" sm-padding">
                                    <div class="property_cover" style="padding:0 15px;">
                                        <?php $page = get_page_by_title($property[0]->name, OBJECT, 'properties'); ?>
                                        <h3><a pid="<?php echo $page->ID; ?>" href="<?php echo get_permalink($page->ID); ?>"><?php echo $property[0]->name; ?></a></h3>
                                        <p><b>Address</b> : <?php echo $property[0]->address; ?>, <?php echo $property[0]->state; ?> <?php echo $property[0]->zipcode; ?></p>
                                        <?php if ($property[0]->phone != "") { ?>
                                            <p><b>Phone</b> : <a href="tel:<?php echo $property[0]->phone; ?>" class="">
                                                    <?php echo $property[0]->phone; ?></a></p>
                                        <?php } ?>
                                        <div class="cs-btn-align text-left">
                                            <a href="<?php echo get_permalink($page->ID); ?>" class="cs-btn cs-btn-custom cs-btn-square cs-btn-custom-own cs-btn-sm cs-btn-custom-61af6051c28d1">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    }  ?>
                </div>
            </div>
        <?php }
    return ob_get_clean();
}

function get_max_beds($id)
{
    global $apikey;
    $arr = array();
    $floorplan = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&type=amenities&apiToken=' . $apikey . '&PropertyCode=' . $id);
    $floorplan = json_decode($floorplan);
    foreach ($floorplan as $plan) {
        array_push($arr, $plan->Beds);
    }
    $arr = array_unique($arr);
    foreach ($arr as $ar) {
        echo $ar . ",";
    }
}





add_shortcode('enquiry_details','enquiry_details');

function enquiry_details(){
    
ob_start(); 

    global $apikey;
	
$content = get_post($_GET['pid']);
$content = $content->post_content;	
	
        $propertydata = file_get_contents('https://api.rentcafe.com/rentcafeapi.aspx?requestType=property&type=propertyData&apiToken=' . $apikey . '&PropertyCode=' . $content);
		
    $obj = json_decode($propertydata);
   
?>   

<h2>Enquiry For</h2>
<h3><?php echo $_GET['property']; ?></h3>
<p><?php echo $obj[0]->address.", ".$obj[0]->city.", ".$obj[0]->state; ?></p>



<?php    
return ob_get_clean();    
}
