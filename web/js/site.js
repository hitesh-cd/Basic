
function checkCouponDeal(){

   var check1 = $("#couponscheck").is(":checked"); //check for coupons checkbox
   
   var check2 = $("#dealscheck").is(":checked"); //check for deals checkbox
   
   var vendor_id = $('input:radio[name="Vendors"]:checked').val(); //checking for vendor radio buttons
   
   var category_id = $('input:radio[name="Categories"]:checked').val(); //checking for categories radio buttons

   $('#loading').html('<img src="http://preloaders.net/preloaders/287/Filling%20broken%20ring.gif">'); //loading the ajax gif in the loading div on index.php

   if((check1 == true && check2 == true) || (check1 == false && check2 == false))
   {
       //both deals and coupons
       if(vendor_id == 'Allvendors' && category_id == 'Allcategories'){
           //no need for a ajax request because it is on same page
           
            $("#loading").fadeIn(); //for the ajax effect
            
            $('#offers').show(); //showing the offers div which will toggle based on below/other conditions
            
            $('#offers_ajax').hide(); //hiding the div in which ajax is loaded
            
            $("#loading").fadeOut(); //for the ajax effect
        }
        else
        {
            //ajax call
            //coupons+deals but vendor is changed
            $.ajax({
            //type: 'GET',
            beforeSend:function (XMLHttpRequest) {
                
                    $("#loading").fadeIn(); //ajax effect before sending the ajax request
                    
                },
            url: "index.php?r=coupon/offers&choice=3&vendor_id="+vendor_id+"&category_id="+category_id, //passing 3 arguments in get parameters
            dataType: "html",
            success: function (data) {
                    
                    $( '#offers_ajax' ).html( data ); //loading the data in that div
                    
                    $('#offers_ajax').show(); //showing the div in which ajax will be loaded
                    
                    $('#offers').hide(); //hiding the offers div
                    
                    $("#loading").fadeOut(); //for the ajax effect

                }
            });
        }
   }
   else if(check1 == true && check2 == false)
   {
       //only coupons
       $.ajax({
        //type: 'GET',
        beforeSend:function (XMLHttpRequest) {
            
                $("#loading").fadeIn();
                
            },
        url: "index.php?r=coupon/offers&choice=1&vendor_id="+vendor_id+"&category_id="+category_id,
        dataType: "html",
        success: function (data) {

                $( '#offers_ajax' ).html( data );
                
                $('#offers_ajax').show();
                
                $('#offers').hide();
                
                $("#loading").fadeOut();

            }
        });

   }
   else
   {
       //only deals
       $.ajax({
        //type: 'GET',
        beforeSend:function (XMLHttpRequest) {
            
                $("#loading").fadeIn();
                
            },
        url: "index.php?r=coupon/offers&choice=2&vendor_id="+vendor_id+"&category_id="+category_id,
        dataType: "html",
        success: function (data) {
                
                $( '#offers_ajax' ).html( data );
                
                $('#offers_ajax').show();
                
                $('#offers').hide();
                
                $("#loading").fadeOut();
                
              }
          });
    }


};

function downloadNow(){ //function to start downloading the excel sheet

   var check1 = $("#couponscheck").is(":checked"); //check for coupons checkbox
   
   var check2 = $("#dealscheck").is(":checked"); //check for deals checkbox
   
   var vendor_id = $('input:radio[name="Vendors"]:checked').val(); //checking for vendor radio buttons
   
   var category_id = $('input:radio[name="Categories"]:checked').val(); //checking for categories radio buttons
   
   var url = "";

   if((check1 == true && check2 == true) || (check1 == false && check2 == false))
   {
      //choice : 3 coupons+deals
        url = "index.php?r=coupon/excelcoupons&choice=3&vendor_id="+vendor_id+"&category_id="+category_id; //passing 3 arguments in get parameters
   
   }
   else if(check1 == true && check2 == false)
   {
       //only coupons choice:1
        url = "index.php?r=coupon/excelcoupons&choice=1&vendor_id="+vendor_id+"&category_id="+category_id;
  
   }
   else
   {
       //only deals choice:2
        url = "index.php?r=coupon/excelcoupons&choice=2&vendor_id="+vendor_id+"&category_id="+category_id;
       
   }
    
    window.location = url; //redirecting to the download link
    
};