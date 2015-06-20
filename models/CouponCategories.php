<?php namespace app\models;

use Yii;

class CouponCategories extends \yii\db\ActiveRecord
{

    public function getCoupons()
    {
        return $this->hasMany(Coupon::className(), ['CouponID' => 'CouponID'])
                ->viaTable('CouponCategoryInfo', ['CategoryID' => 'CategoryID']);
    }
}

?>