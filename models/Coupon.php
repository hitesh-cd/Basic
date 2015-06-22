<?php namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Website;
use app\models\CouponCategories;
use app\models\CouponCategoryInfo;

class Coupon extends \yii\db\ActiveRecord
{

    public function getTableName()
    {
        return 'coupon';
    }

    public function getWebsite()
    {
        return $this->hasOne(Website::className(), ['WebsiteID' => 'WebsiteID']);
    }

    public function getCouponCategories()
    {
        return $this->hasMany(CouponCategories::className(), ['CategoryID' => 'CategoryID'])
                ->viaTable('CouponCategoryInfo', ['CouponID' => 'CouponID']);
    }

    public static function getCouponsBasedOnTypeVendorCategory($choice_type, $vendor_id, $category_id)
    {
        $query = Coupon::find()
                ->joinWith('couponCategories')
                ->with('website')
                ->orderBy('CouponID')->limit(30); //limiting to 30 coupons only for simplicity

        $coupons = $query; //cloning that to coupon for choice : 3
        if ($choice_type == 1) { //coupons
            $coupons = $query->where("isDeal=0");
        } elseif ($choice_type == 2) { //deals
            $coupons = $query->where("isDeal=1");
        }

        if ($vendor_id != "Allvendors") {
            $coupons = $coupons->andWhere(array("WebsiteID" => $vendor_id));
        }

        if ($category_id != 'Allcategories') {
            $coupons = $coupons->andWhere(array("`CouponCategories`.`CategoryID`    " => $category_id));
        } else {
            $category_id = -1;
        }
        $coupons = $coupons->all();

        return $coupons;
    }
}

?>