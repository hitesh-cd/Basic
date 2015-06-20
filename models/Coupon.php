<?php namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Website;

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
}

?>