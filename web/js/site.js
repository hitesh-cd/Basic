/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//globalParams = {
//                   'loginUrl' : "<?= \yii\helpers\Url::to(['coupon/offers']) ?>"
//               };
            function checkCouponDeal(){
                
               var check1 = $("#couponscheck").is(":checked");
               var check2 = $("#dealscheck").is(":checked");
               var vendor_id = $('input:radio[name="Vendors"]:checked').val();
               $('#loading').html('<img src="http://preloaders.net/preloaders/287/Filling%20broken%20ring.gif">');

               if((check1 == true && check2 == true) || (check1 == false && check2 == false))
               {
                   //both deals and coupons
                   if(vendor_id == 'Allvendors'){
                       //no need for a ajax request because it is on same page
                        $("#loading").fadeIn();
                        $('#offers').show();
                        $('#offers_ajax').hide();
                        $("#loading").fadeOut();
                    }
                    else
                    {
                        //ajax call
                        //coupons+deals but vendor is changed
                        $.ajax({
                        //type: 'GET',
                        beforeSend:function (XMLHttpRequest) {
                                $("#loading").fadeIn();
                            },
                        url: "index.php?r=coupon/offers&choice=3&vendor_id="+vendor_id,
                        dataType: "html",
                        success: function (data) {
                                //( '#offers_ajax' ).load( 'index.php?r=coupon/offers', { coupons: data } );
                                $( '#offers_ajax' ).html( data );
                                $('#offers_ajax').show();
                                $('#offers').hide();
                                $("#loading").fadeOut();

                                //$('#offers')
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
                    url: "index.php?r=coupon/offers&choice=1&vendor_id="+vendor_id,
                    dataType: "html",
                    success: function (data) {
                            //( '#offers_ajax' ).load( 'index.php?r=coupon/offers', { coupons: data } );
                            $( '#offers_ajax' ).html( data );
                            $('#offers_ajax').show();
                            $('#offers').hide();
                            $("#loading").fadeOut();

                            //$('#offers')
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
                    url: "index.php?r=coupon/offers&choice=2&vendor_id="+vendor_id,
                    dataType: "html",
                    success: function (data) {
                            //( '#offers_ajax' ).load( 'index.php?r=coupon/offers', { coupons: data } );
                            $( '#offers_ajax' ).html( data );
                            $('#offers_ajax').show();
                            $('#offers').hide();
                            $("#loading").fadeOut();
                            //$('#offers')
                          }
                      });
                }
                

            };

//        $(document).ready(function () {$("#link-985304517").bind("click", function (event) {
//                $.ajax({
//                    beforeSend:function (XMLHttpRequest) {
//                            $("#loading").fadeIn();
//                        },
//                    dataType:"html",
//                    success:function (data, textStatus) {
//                        $("#loading").fadeOut();
//                        $("#receiving").html(data);
//                    },
//                    url:"\/TimetableModule\/Days\/add"
//                            });
//                        });
//        });