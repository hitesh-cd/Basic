<?php
use yii\helpers\Html; /* global globalParams */
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;

?>
<html>
    <head>
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <style>
            body{
                background-color: #F2F2F2;
            }
            hr{
                margin-bottom: 0px;
            }
        </style>
        <script>
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>FILTERS</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php //$form = ActiveForm::begin(); ?>
                                <?php //$form->field($formdata, 'isDeal')->checkbox(); ?>
                                <?php //ActiveForm::end(); ?>
                                <h5>OFFER TYPE</h5>
                                <hr>
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="checkbox" id="couponscheck" name ="Coupon[couponscheck]" checked="true" onchange="checkCouponDeal()"> Coupon
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="checkbox" id="dealscheck" name ="Coupon[dealscheck]" checked="true" onchange="checkCouponDeal()"> Deal
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row" style="height:25px">

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>WEBSITES</h5>
                                <hr>
                                <form role="form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="radio" id="Allvendors" value="Allvendors" name ="Vendors" onchange="checkCouponDeal()" checked="true"> All Vendors
                                        </div>
                                    </div>
                                    <?php foreach ($vendors as $vendor) { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="radio" id="<?= $vendor->WebsiteID; ?>" value="<?= $vendor->WebsiteID; ?>" name ="Vendors"onchange="checkCouponDeal()">
                                                <?php echo $vendor->WebsiteTitle; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <h1>View all Offers</h1>
                    <div id="loading" align="center">

                    </div>
                    <div id="offers_ajax">

                    </div>
                    <div id="offers">


                        <?php foreach ($coupons as $coupon): ?>
                            <div class="thumbnail">
                                <div class="caption">
                                    <?php if ($coupon->Title == NULL) { ?>
                                        <h3><?= substr($coupon->Description, 0, 20) . '...'; ?></h3>
                                    <?php } else { ?>
                                        <h3><?= $coupon->Title ?></h3>
                                    <?php } ?>
                                    <p><?= $coupon->Description ?></p>

                                    <p>Vendor : <b><?= $coupon->website->WebsiteName ?></b></p>

                                    <?php if ($coupon->IsDeal == 1) { ?>
                                        <h5>
                                            <button type="button" class="btn btn-warning">ACTIVATE DEAL</button>
                                        </h5>
                                    <?php } else {

                                        ?>
                                        <h5>
                                            Coupon Code :
                                            <button type="button" class="btn btn-info">
                                                <?= $coupon->CouponCode ?>
                                            </button>
                                        </h5>
                                    <?php } ?>

                                    <p>
                                        <i class="fa fa-thumbs-up"></i><?= $coupon->CountSuccess ?>
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="fa fa-thumbs-down"></i><?= $coupon->CountFail ?>
                                    </p>
                                </div>
                            </div>

                        <?php endforeach; ?>
                        <?= LinkPager::widget(['pagination' => $pagination]) ?>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>