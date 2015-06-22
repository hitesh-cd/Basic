<?php if (empty($coupons)) { ?>
    <hr>
    <p><h4>No Coupons Available</h4></p>
<?php } else { ?>
    <?php foreach ($coupons as $coupon): ?>
        <?php //var_dump($coupon->couponCategories);  ?>
        <?php //if ($coupon->couponCategories->CategoryID != $category_id) {                   ?>
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
        <?php //}  ?>

    <?php endforeach; ?>
<?php } ?>
