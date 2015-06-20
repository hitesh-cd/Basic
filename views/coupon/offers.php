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