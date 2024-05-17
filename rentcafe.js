jQuery(document).ready(function(){
    
    
 jQuery(".tab_navs li a").click(function(e){
     e.preventDefault();
    jQuery(".plan_content_inner").hide(); 
   var activeTab = jQuery(this).attr("href"); 
      jQuery(activeTab).fadeIn();	    
     
     
     
 });   
    
   jQuery(".owl-carousel").owlCarousel({
       
       items:1,
       nav:true,
       autoHeight:true
       
   });  
    
    
    
jQuery(".search_filter_call").click(function(){

var beds = jQuery("#beds_av").val();
var city = jQuery("#city_av").val();    

if(beds > 0 && beds !="Any" && city =="Any"){

jQuery(".property_search_results_grid").each(function(){
var cur = jQuery(this);
var bed = cur.attr("beds");
var city_cur = cur.attr("city");
if(bed.search(beds) <=0){
cur.hide();
}else{
cur.show();
}
});

}else if(city !="Any" && beds =="Any"){


jQuery(".property_search_results_grid").each(function(){
var cur = jQuery(this);
var bed = cur.attr("beds");
var city_cur = cur.attr("city");
if(city_cur != city){
cur.hide();
}else{
cur.show();
}
});


    
    
}else if(city =="Any" && beds =="Any"){
  
  
jQuery(".property_search_results_grid").each(function(){
var cur = jQuery(this);
cur.show();
});  
  
    
    
}else if(city !="Any"){


jQuery(".property_search_results_grid").each(function(){
var cur = jQuery(this);
var bed = cur.attr("beds");
var city_cur = cur.attr("city");
if(city_cur != city){
cur.hide();
}else{
cur.show();
}
});    
    
}


    
    
});    
    
    
    
    
    
    
    
    
    
});