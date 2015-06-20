<?php namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use Yii;
use app\models\Coupon;
use app\models\Website;

class CouponController extends Controller
{

    public function actionTest()
    {

    }

    public function actionIndex()
    {
        $query_coupons = Coupon::find();

        $pagination = new Pagination([
            'defaultPageSize' => 30,
            'totalCount' => $query_coupons->count(),
        ]);

        $query_vendors = \app\models\Website::find();

        $vendors = $query_vendors->orderBy('WebsiteName')
            ->limit(10)
            ->all();

        $coupons = $query_coupons
            ->orderBy('CouponID')
            ->with('website')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
                'coupons' => $coupons,
                'pagination' => $pagination,
                'vendors' => $vendors
        ]);
    }

    public function actionOffers($choice, $vendor_id)
    {
        /*
         * Description about arguments
         * $choice : 1 for coupon , 2 for deal and 3 for coupon+deal
         * $vendor_id : Either "Allvendors or vendorid
         * Designed to return the ajax calls made from VIEW
         */

        $request = Yii::$app->request;

        if ($request->isAjax) {
            //$data = Yii::$app->getRequest()->getBodyParam('data');
            $coupons = array('test');

            $query = Coupon::find();

            $pagination = new Pagination([
                'defaultPageSize' => 60,
                'totalCount' => $query->count(),
            ]);
            if ($choice == 1) {
                if ($vendor_id == "Allvendors") {
                    $coupons = $query->orderBy('CouponID')
                        ->offset($pagination->offset)
                        ->with('website')
                        ->limit($pagination->limit)
                        ->where("isDeal=0")
                        ->all();
                } else {
                    $coupons = $query->orderBy('CouponID')
                        ->offset($pagination->offset)
                        ->with('website')
                        ->limit($pagination->limit)
                        ->where(array("isDeal" => 0, "WebsiteID" => $vendor_id))
                        ->all();
                }
            } else if ($choice == 2) {

                if ($vendor_id == "Allvendors") {

                    $coupons = $query->orderBy('CouponID')
                        ->offset($pagination->offset)
                        ->with('website')
                        ->limit($pagination->limit)
                        ->where("isDeal=1")
                        ->all();
                } else {

                    $coupons = $query->orderBy('CouponID')
                        ->offset($pagination->offset)
                        ->with('website')
                        ->limit($pagination->limit)
                        ->where(array("isDeal" => 1, "WebsiteID" => $vendor_id))
                        ->all();
                }
            } else {
                //choice 3
                $coupons = $query->orderBy('CouponID')
                    ->offset($pagination->offset)
                    ->with('website')
                    ->limit($pagination->limit)
                    ->where(array("WebsiteID" => $vendor_id))
                    ->all();
            }
            return $this->renderAjax('offers', ['coupons' => $coupons, 'pagination' => $pagination]);
            //return json_encode(['status' => 'SUCCESS', 'coupons' => $coupons]);
        }
    }
}
